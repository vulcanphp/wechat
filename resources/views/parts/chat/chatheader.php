<header class="flex flex-col md:flex-row justify-between items-center">
    <div class="flex items-center">
        <a href="<?= home_url() ?>" class="mr-3 md:mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 md:w-12 md:h-12 rounded-full fill-current bg-slate-100 text-slate-400 hover:bg-teal-50 hover:text-teal-400" viewBox="0 0 24 24">
                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
            </svg>
        </a>
        <?php

        use VulcanPhp\Core\Helpers\PrettyDateTime;

        $userString = json_encode([
            'id' => $friend->id,
            'name' => $friend->getDisplayName(),
            'avatar' => $friend->meta('avatar'),
        ]);

        if ($friend->meta('avatar') != null) : ?>
            <img src="<?= storage_url($friend->meta('avatar')) ?>" class="w-12 h-12 md:w-16 md:h-16 rounded-full" alt="<?= $friend->getDisplayName() ?> - Avatar">
        <?php else : ?>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 md:w-16 md:h-16 fill-current text-teal-400" viewBox="0 0 24 24">
                <path d="M12 2C6.579 2 2 6.579 2 12s4.579 10 10 10 10-4.579 10-10S17.421 2 12 2zm0 5c1.727 0 3 1.272 3 3s-1.273 3-3 3c-1.726 0-3-1.272-3-3s1.274-3 3-3zm-5.106 9.772c.897-1.32 2.393-2.2 4.106-2.2h2c1.714 0 3.209.88 4.106 2.2C15.828 18.14 14.015 19 12 19s-3.828-.86-5.106-2.228z"></path>
            </svg>
        <?php endif ?>
        <div class="ml-2 sm:ml-3 md:ml-4">
            <p class="uppercase font-semibold text-sm sm:text-base md:text-lg"><?= $friend->getDisplayName() ?></p>
            <p class="text-slate-500 text-xs" onlinestatus="<?= $friend->id ?>">
                <?php if (!empty($friend->meta('last_activity'))) : ?>
                    <?php if ($friend->meta('last_activity') >= strtotime('- 2 minutes')) : ?>
                        Active Now
                    <?php else : ?>
                        <span class="hidden md:inline-block">Last Seen: </span><?= PrettyDateTime::parse(new DateTime(date('Y-m-d H:i:s', $friend->meta('last_activity')))) ?>
                    <?php endif ?>
                <?php else : ?>
                    Activity Unknown
                <?php endif ?>
            </p>
        </div>
    </div>
    <div class="flex items-center justify-end mt-3 md:mt-0">
        <button @click='startCall("audio", <?= $userString ?>)'>
            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-7 text-slate-400 hover:text-teal-500" viewBox="0 0 24 24">
                <path d="M17.707 12.293a.999.999 0 0 0-1.414 0l-1.594 1.594c-.739-.22-2.118-.72-2.992-1.594s-1.374-2.253-1.594-2.992l1.594-1.594a.999.999 0 0 0 0-1.414l-4-4a.999.999 0 0 0-1.414 0L3.581 5.005c-.38.38-.594.902-.586 1.435.023 1.424.4 6.37 4.298 10.268s8.844 4.274 10.269 4.298h.028c.528 0 1.027-.208 1.405-.586l2.712-2.712a.999.999 0 0 0 0-1.414l-4-4.001zm-.127 6.712c-1.248-.021-5.518-.356-8.873-3.712-3.366-3.366-3.692-7.651-3.712-8.874L7 4.414 9.586 7 8.293 8.293a1 1 0 0 0-.272.912c.024.115.611 2.842 2.271 4.502s4.387 2.247 4.502 2.271a.991.991 0 0 0 .912-.271L17 14.414 19.586 17l-2.006 2.005z"></path>
            </svg>
        </button>
        <button class="mx-3" @click='startCall("video", <?= $userString ?>)'>
            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-7 text-slate-400 hover:text-teal-500" viewBox="0 0 24 24">
                <path d="M18 7c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-3.333L22 17V7l-4 3.333V7zm-1.998 10H4V7h12l.001 4.999L16 12l.001.001.001 4.999z"></path>
            </svg>
        </button>
    </div>
</header>