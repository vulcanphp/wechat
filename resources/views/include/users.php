<?php

use App\Models\Conversations;
use App\Models\User;
use App\Models\UserMeta;

$users = User::select(
    'p.*, t1.value as last_activity, (SELECT c.created_at FROM ' . Conversations::tableName() . ' as c WHERE (c.sender = p.id AND c.receiver = ' . $user->id . ') OR (c.receiver = p.id AND c.sender = ' . $user->id . ') ORDER BY c.id DESC LIMIT 1) as last_message'
)
    ->where("p.id != $user->id AND last_message IS NOT NULL")
    ->leftJoin(UserMeta::class, "t1.user = p.id AND t1.meta_key = 'last_activity'")
    ->limit(5)
    ->order('last_message DESC')
    ->get()
    ->all();
?>
<?php if (!empty($users)) : ?>
    <div class="flex mt-4 md:mt-6 justify-center flex-wrap">
        <?php foreach ($users as $key => $chat) : ?>
            <a href="/<?= $chat->username ?>" class="relative m-1 sm:m-2 md:m-3" chat-filter="<?= $chat->getDisplayName() ?>">
                <?php if ($chat->meta('avatar') != null) : ?>
                    <img class="w-16 h-16 md:w-20 md:h-20 rounded-full" src="<?= storage_url($chat->meta('avatar')) ?>" alt="<?= $chat->getDisplayName() ?> - Avatar">
                <?php else : ?>
                    <p class="w-16 h-16 md:w-20 md:h-20 bg-slate-200 text-slate-500 text-2xl flex items-center justify-center rounded-full uppercase">
                        <?php
                        $name = $chat->getDisplayName();
                        echo strpos($name, ' ') !== false ? substr($name, 0, 1) . substr($name, strpos($name, ' ') + 1, 1) : substr($name, 0, 2);
                        ?>
                    </p>
                <?php endif ?>
                <span activity="<?= $chat->id ?>" class="<?= !empty($chat->last_activity) ? ($chat->last_activity >= strtotime('- 2 minutes') ? 'bg-teal-400' : 'bg-amber-400') : 'bg-slate-400' ?> w-3 h-3 md:w-4 md:h-4 rounded-full border-2 border-white absolute bottom-0 right-2"></span>
            </a>
        <?php endforeach ?>
    </div>
<?php endif ?>