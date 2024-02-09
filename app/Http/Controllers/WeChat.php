<?php

namespace App\Http\Controllers;

use App\Core\Pusher;
use App\Models\Conversations;
use App\Models\User;
use DateTime;
use VulcanPhp\Core\Helpers\PrettyDateTime;
use VulcanPhp\Core\Helpers\Time;

class WeChat
{
    public function user($username)
    {
        $friend = User::find(['username' => $username]);

        if ($friend === false) {
            abort(404);
        }

        return view('chat', [
            'friend' => $friend,
            'chatlist' => $this->getChatlist(
                app()->getComponent('auth')->getUser()->id,
                $friend->id
            )
        ]);
    }

    public function pusherAuth()
    {
        return Pusher::$client->authorizeChannel(
            input('channel_name'),
            input('socket_id')
        );
    }

    protected function getChatlist(int $userId, int $friendId, int $page = 1): array
    {
        $chatlist = [];

        foreach (array_reverse(Conversations::where("(sender = $userId AND receiver = $friendId) OR (sender = $friendId AND receiver = $userId)")
            ->order('id DESC')
            ->limit((100 * ($page - 1)), 100)
            ->fetch(\PDO::FETCH_ASSOC)
            ->get()
            ->map(function ($m) {
                $m['time'] = date('g:i A', strtotime($m['created_at']));
                $m['day'] = PrettyDateTime::parse(new DateTime($m['created_at']));
                $m['day'] = date('Y-m-d', strtotime($m['created_at'])) == date('Y-m-d') ? 'Today' : $m['day'];
                return $m;
            })
            ->all()) as $chat) {
            $chat['self'] = $chat['sender'] == $userId;
            $chatlist[$chat['day']][] = $chat;
        }

        return $chatlist;
    }

    public function messageList()
    {
        return response()->json($this->getChatlist(
            app()->getComponent('auth')->getUser()->id,
            input('friend'),
            input('page'),
        ));
    }

    public function sendMessage()
    {
        $user = app()->getComponent('auth')->getUser();
        $model = new Conversations;

        $type = input()->hasFile('file') ? 'textfile' : 'text';

        if ($type == 'textfile') {
            storage()->setConfig('upload_dir', 'uploads');
            $content = encode_string([
                'message' => input('message'),
                'file' => str_replace(storage_dir(), '', storage()->upload('file')[0])
            ]);
        } else {
            $content = input('message');
        }

        $model->load([
            'sender' => $user->id,
            'receiver' => input('to'),
            'content' => $content,
            'type' => $type,
            'created_at' => Time::getDateTime()
        ]);

        if ($model->validate() && $model->save()) {
            $message = array_merge($model->toArray(), [
                'timestamp' => time(),
                'time' => date('g:i A'),
                'day' => 'Today',
                'self' => false,
            ]);

            Pusher::$client->trigger(
                "private-encrypted-chatroom-$model->receiver",
                'message',
                $message
            );

            return response()->json([
                'message' => 'Message Sent Successfully',
                'data' => array_merge($message, ['self' => true])
            ]);
        }

        return response()->httpCode(503)->json(['message' => 'Failed to Send Message']);
    }

    public function sendToSocket(int $id): void
    {
        Pusher::$client->trigger("private-encrypted-chatroom-$id", input('event'), input('data'));

        $events = [
            'call-busy' => [$this, 'missedCall'],
            'call-cancel' => [$this, 'missedCall'],
            'already-in-call' => [$this, 'missedCall'],
        ];

        if (isset($events[input('event')])) {
            call_user_func($events[input('event')], $id);
        }
    }

    protected function missedCall($id)
    {
        if (in_array(input('event'), ['call-busy', 'already-in-call'])) {
            $sender = $id;
            $receiver = input('data')['user'];
        } else {
            $sender = input('data')['user'];
            $receiver = $id;
        }

        $message =  [
            'sender' => $sender,
            'receiver' => $receiver,
            'content' => 'Missed Live Call',
            'type' => input('data')['type'] == 'video' ? 'videocall' : 'voicecall',
            'created_at' => Time::getDateTime(),
            'timestamp' => time(),
            'time' => date('g:i A'),
            'day' => 'Today',
            'self' => true
        ];

        $model = new Conversations;
        $model->load($message);

        if ($model->validate() && $model->save()) {
            Pusher::$client->trigger("private-encrypted-chatroom-$sender", 'message', $message);
            Pusher::$client->trigger("private-encrypted-chatroom-$receiver", 'message', array_merge($message, [
                'self' => false
            ]));
        }
    }
}
