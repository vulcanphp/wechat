<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use App\Models\User;
use App\Models\UserMeta;
use DateTime;
use VulcanPhp\Core\Helpers\PrettyDateTime;
use VulcanPhp\Core\Helpers\Str;
use VulcanPhp\FileSystem\Image;

class UserManager
{
    public function register()
    {
        if (($model = new User) && $model->inputValidate() && $model->save()) {
            session()->setFlash('success', 'Registration Success');
            return redirect('/');
        } else {
            return $this->modelError($model) && redirect('/account?tab=register');
        }
    }

    public function login()
    {
        if (($user = User::find(sprintf("email = '%s' OR username = '%s'", input('user'), input('user'))))
            && password(input('password'), $user->password)
        ) {
            return app()->getComponent('auth')->attempLogin($user) && redirect('/');
        }

        session()->setFlash('error', 'Incorrect User/Password');
        return redirect('/account');
    }

    public function logout()
    {
        return app()->getComponent('auth')->attemptLogout() && redirect('/account');
    }

    public function updateProfile()
    {
        if (request()->isMethod('post')) {
            $auth = app()->getComponent('auth');
            $user = $auth->getUser();

            unset($user->password, $user->created_at, $user->status, $user->role);

            if ($user->inputValidate()) {
                $user->save();
            } else {
                $this->modelError($user);
            }

            if (input()->hasFile('avatar')) {
                if (!empty($user->meta('avatar')) && file_exists(storage_dir($user->meta('avatar')))) {
                    unlink(storage_dir($user->meta('avatar')));
                }

                $upload = input()->getFile('avatar');
                $avatar = storage_dir('/avatar/' . uniqid($user->username . '_') . '.jpg');

                Image::resize($upload->getTmpName(), 145, 145, $avatar);

                if (file_exists($avatar)) {
                    $avatar = str_replace(storage_dir(), '', $avatar);
                    UserMeta::saveMeta(['avatar' => $avatar], $user->id);
                }
            }

            $auth->getDriver()->RemoveCacheUser($user->id);

            return response()->back();
        }

        return view('profile');
    }

    public function updateActivities()
    {
        $user = app()->getComponent('auth')->getUser();

        // update user activity
        UserMeta::saveMeta(['last_activity' => time()], $user->id);

        $append = explode(',', input('append', ''));

        if (in_array('seen', $append) && input('friend') != null) {
            Conversations::where("sender = " . input('friend') . " AND receiver = $user->id AND read = 0")
                ->update(['read' => 1]);
        }

        $response   = [];
        $userIds    = array_filter(array_unique(input('ids', [])));
        $timestamps = array_filter(array_unique(input('timestamps', [])));

        $response['users'] = !empty($userIds) ? UserMeta::select('user, value')
            ->whereIn('user', $userIds)
            ->where(['meta_key' => 'last_activity'])
            ->fetch(\PDO::FETCH_ASSOC)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity['user'],
                    'status' => $activity['value'] >= strtotime('- 2 minutes') ? 'teal' : 'amber',
                    'text' => $activity['value'] >= strtotime('- 2 minutes')
                        ? 'Active Now'
                        : '<span class="hidden md:inline-block">Last Seen: </span>' . PrettyDateTime::parse(new DateTime(date('Y-m-d H:i:s', $activity['value'])))
                ];
            })
            ->all() : [];

        $response['timestamps'] = !empty($timestamps) ? collect($timestamps)
            ->map(function ($time) {
                return [
                    'time' => $time,
                    'info' => PrettyDateTime::parse(new DateTime(date('Y-m-d H:i:s', $time)))
                ];
            })->all() : [];

        return response()->json($response);
    }

    protected function modelError($model): bool
    {
        session()->setFlash(
            'error',
            Str::read($model->errorField()) . ': ' .  $model->firstError()
        );

        return true;
    }
}
