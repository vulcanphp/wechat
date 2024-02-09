<?php

use App\Models\User;
use App\Models\Conversations;
use VulcanPhp\Core\Helpers\Str;
use VulcanPhp\Core\Helpers\PrettyDateTime;

$users = User::select('
    p.*, t1.value as last_activity, (SELECT c.id FROM ' . Conversations::tableName() . ' as c WHERE (c.sender = p.id AND c.receiver = ' . $user->id . ') OR (c.receiver = p.id AND c.sender = ' . $user->id . ') ORDER BY c.id DESC LIMIT 1) as message,
    (SELECT COUNT(1) FROM ' . Conversations::tableName() . ' as c WHERE c.read = 0 AND c.sender = p.id AND c.receiver = ' . $user->id . ' ORDER BY c.id DESC LIMIT 1) as unseen
')
    ->where('p.id != ' . $user->id)
    ->leftJoin(UserMeta::class, "t1.user = p.id AND t1.meta_key = 'last_activity'")
    ->order('message DESC')
    ->get();

$messages = Conversations::whereIn('id', $users->column('message'))
    ->fetch(\PDO::FETCH_ASSOC)
    ->get()
    ->all();

$users->map(function ($user) use ($messages) {
    foreach ($messages as $message) {
        if ($message['id'] == $user->message) {
            $user->message = $message;
            break;
        }
    }
    return $user;
});

?>
<div class="mt-8 md:mt-10 h-[50vh] overflow-y-scroll" chatlist>
    <?php foreach ($users->all() as $chat) : ?>
        <div pushchat="<?= $chat->id ?>" chat-filter="<?= $chat->getDisplayName() ?>">
            <a href="/<?= $chat->username ?>" class="mb-4 md:mb-6 flex items-center">
                <div class="relative mr-1 sm:mr-2 md:mr-3">
                    <?php if ($chat->meta('avatar') != null) : ?>
                        <img class="w-12 h-12 md:w-14 md:h-14 rounded-full" src="<?= storage_url($chat->meta('avatar')) ?>" alt="<?= $chat->getDisplayName() ?> - Avatar">
                    <?php else : ?>
                        <p class="w-12 h-12 md:w-14 md:h-14 bg-slate-200 text-slate-500 text-2xl flex items-center justify-center rounded-full uppercase">
                            <?php
                            $name = $chat->getDisplayName();
                            echo strpos($name, ' ') !== false ? substr($name, 0, 1) . substr($name, strpos($name, ' ') + 1, 1) : substr($name, 0, 2);
                            ?>
                        </p>
                    <?php endif ?>
                    <span activity="<?= $chat->id ?>" class="<?= !empty($chat->last_activity) ? ($chat->last_activity >= strtotime('- 2 minutes') ? 'bg-teal-400' : 'bg-amber-400') : 'bg-slate-400' ?> w-2 h-2 md:w-3 md:h-3 rounded-full border-1 md:border-2 border-white absolute bottom-1 md:bottom-0 right-1"></span>
                </div>
                <div class="ml-1 w-10/12 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-sm sm:text-base md:text-lg"><?= $chat->getDisplayName() ?></p>
                        <p message class="text-xs md:text-sm flex items-center <?= isset($chat->message['read']) && $chat->message['receiver'] == $user->id && !$chat->message['read'] ? 'text-slate-600 font-semibold' : 'text-slate-500' ?>">
                            <?php
                            if (isset($chat->message)) {
                                if ($chat->message['sender'] == $user->id) {
                                    echo '<i>Me: </i>';
                                }
                                if ($chat->message['type'] == 'textfile') {
                                    echo '<span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-3 md:w-4" viewBox="0 0 24 24">
                                    <path d="M19.937 8.68c-.011-.032-.02-.063-.033-.094a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.99.99 0 0 0-.05-.258zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z"></path>
                                </svg> Send An Attachment</span>';
                                } elseif ($chat->message['type'] == 'voicecall') {
                                    echo '<span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-3 md:w-4" viewBox="0 0 24 24">
                                    <path d="M17.707 12.293a.999.999 0 0 0-1.414 0l-1.594 1.594c-.739-.22-2.118-.72-2.992-1.594s-1.374-2.253-1.594-2.992l1.594-1.594a.999.999 0 0 0 0-1.414l-4-4a.999.999 0 0 0-1.414 0L3.581 5.005c-.38.38-.594.902-.586 1.435.023 1.424.4 6.37 4.298 10.268s8.844 4.274 10.269 4.298h.028c.528 0 1.027-.208 1.405-.586l2.712-2.712a.999.999 0 0 0 0-1.414l-4-4.001zm-.127 6.712c-1.248-.021-5.518-.356-8.873-3.712-3.366-3.366-3.692-7.651-3.712-8.874L7 4.414 9.586 7 8.293 8.293a1 1 0 0 0-.272.912c.024.115.611 2.842 2.271 4.502s4.387 2.247 4.502 2.271a.991.991 0 0 0 .912-.271L17 14.414 19.586 17l-2.006 2.005z"></path>
                                </svg> ' . ($chat->message['sender'] == $user->id ? 'Voice Call' : 'Missed Voice Call') . '</span>';
                                } elseif ($chat->message['type'] == 'videocall') {
                                    echo '<span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-3 md:w-4" viewBox="0 0 24 24">
                                    <path d="M18 7c0-1.103-.897-2-2-2H6.414L3.707 2.293 2.293 3.707l18 18 1.414-1.414L18 16.586v-2.919L22 17V7l-4 3.333V7zm-2 7.586L8.414 7H16v7.586zM4 19h10.879l-2-2H4V8.121L2.145 6.265A1.977 1.977 0 0 0 2 7v10c0 1.103.897 2 2 2z"></path>
                                </svg> ' . ($chat->message['sender'] == $user->id ? 'Video Call' : 'Missed Video Call') . '</span>';
                                } else {
                                    echo Str::limit($chat->message['content'], 20);
                                }
                            } else {
                                echo '<i>Be First To Start Conversation</i>';
                            }
                            ?>
                        </p>
                    </div>
                    <div info class="ml-1 md:ml-2">
                        <?php if (isset($chat->message['created_at'])) : ?>
                            <p time timestamp="<?= strtotime($chat->message['created_at']) ?>" class="text-slate-400 mb-1 text-xs"><?= PrettyDateTime::parse(new DateTime($chat->message['created_at'])) ?></p>
                        <?php else : ?>
                            <p time timestamp="" style="display: none;" class="text-slate-400 mb-1 text-xs"></p>
                        <?php endif ?>
                        <?php if ($chat->unseen > 0) : ?>
                            <span unseen class="text-sm bg-teal-400 text-white w-5 h-5 rounded-full ml-auto flex items-center justify-center"><?= $chat->unseen ?></span>
                        <?php else : ?>
                            <span unseen style="display: none;" class="text-sm bg-teal-400 text-white w-5 h-5 rounded-full ml-auto flex items-center justify-center">0</span>
                        <?php endif ?>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach ?>
</div>