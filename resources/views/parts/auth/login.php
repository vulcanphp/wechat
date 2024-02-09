<template x-if="tab == 'login'">
    <div>
        <img src="<?= resource_url('assets/images/login-icon.png') ?>" alt="Login - WeChat" class="w-10/12 mx-auto">
        <form action="/login" method="post" class="mt-8 md:mt-16">
            <?= csrf() ?>
            <div class="relative border-b pb-2 border-sky-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-teal-500 w-14 absolute top-0 left-0">
                    <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path>
                </svg>
                <input type="text" name="user" class="w-full pl-9 outline-none placeholder:text-slate-400" placeholder="Username/Email">
            </div>
            <div class="relative border-b pb-2 border-sky-50 mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-teal-500 w-14 absolute top-0 left-0">
                    <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zm6 10 .002 8H6v-8h12zm-9-2V7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9z"></path>
                </svg>
                <input type="password" name="password" class="w-full pl-9 outline-none placeholder:text-slate-400" placeholder="Password">
            </div>
            <div class="mt-6 text-center">
                <button type="submit" class="px-6 py-2 rounded-full bg-teal-400 hover:bg-teal-500 text-white">Login</button>
            </div>
        </form>
        <p class="text-slate-400 mt-8 text-center">Don't have an account? <button class="text-teal-500" @click="tab='register'">Register</button></p>
    </div>
</template>