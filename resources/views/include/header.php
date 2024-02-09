<header class="flex justify-between items-center">
    <div class="flex items-center">
        <?php if ($user->meta('avatar') != null) : ?>
            <img src="<?= storage_url($user->meta('avatar')) ?>" class="w-14 h-14 md:w-24 md:h-24 rounded-full" alt="<?= $user->getDisplayName() ?> - Avatar">
        <?php else : ?>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 md:w-24 md:h-24 fill-current text-teal-400" viewBox="0 0 24 24">
                <path d="M12 2C6.579 2 2 6.579 2 12s4.579 10 10 10 10-4.579 10-10S17.421 2 12 2zm0 5c1.727 0 3 1.272 3 3s-1.273 3-3 3c-1.726 0-3-1.272-3-3s1.274-3 3-3zm-5.106 9.772c.897-1.32 2.393-2.2 4.106-2.2h2c1.714 0 3.209.88 4.106 2.2C15.828 18.14 14.015 19 12 19s-3.828-.86-5.106-2.228z"></path>
            </svg>
        <?php endif ?>
        <div class="ml-2 md:ml-4">
            <p class="uppercase font-semibold md:text-2xl"><?= $user->getDisplayName() ?></p>
            <p class="text-slate-500">@<?= $user->username ?></p>
        </div>
    </div>
    <div x-data="{dropDown: false}" class="relative" @click.away="dropDown = false">
        <button @click="dropDown = !dropDown">
            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-8 md:w-10 text-slate-400 hover:text-slate-500" viewBox="0 0 24 24">
                <path d="M4 6h16v2H4zm4 5h12v2H8zm5 5h7v2h-7z"></path>
            </svg>
        </button>
        <div x-cloak x-show="dropDown" x-transition class="bg-gray-50 border border-gray-100 px-4 py-3 rounded shadow absolute z-20 right-0">
            <a href="/profile" class="flex items-center opacity-85 hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 fill-current text-amber-500" viewBox="0 0 24 24">
                    <path d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path>
                    <path d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path>
                </svg>
                <span class="ml-2">Edit</span>
            </a>
            <p class="my-3 border-t"></p>
            <form action="/logout" method="post">
                <?= csrf() ?>
                <button class="flex items-center opacity-85 hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 fill-current text-rose-500" viewBox="0 0 24 24">
                        <path d="m2 12 5 4v-3h9v-2H7V8z"></path>
                        <path d="M13.001 2.999a8.938 8.938 0 0 0-6.364 2.637L8.051 7.05c1.322-1.322 3.08-2.051 4.95-2.051s3.628.729 4.95 2.051 2.051 3.08 2.051 4.95-.729 3.628-2.051 4.95-3.08 2.051-4.95 2.051-3.628-.729-4.95-2.051l-1.414 1.414c1.699 1.7 3.959 2.637 6.364 2.637s4.665-.937 6.364-2.637c1.7-1.699 2.637-3.959 2.637-6.364s-.937-4.665-2.637-6.364a8.938 8.938 0 0 0-6.364-2.637z"></path>
                    </svg>
                    <span class="ml-2">Logout</span>
                </button>
            </form>
        </div>
    </div>
</header>