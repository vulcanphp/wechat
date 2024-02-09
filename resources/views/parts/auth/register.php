<template x-if="tab == 'register'">
    <div>
        <img src="<?= resource_url('assets/images/register-icon.png') ?>" alt="Register - WeChat" class="w-10/12 mx-auto">
        <form action="/register" method="post" class="mt-8 md:mt-16">
            <?= csrf() ?>
            <div class="relative border-b pb-2 border-sky-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-teal-500 w-14 absolute top-0 left-0">
                    <path d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 6.223-8-6.222V6h16zM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4z"></path>
                </svg>
                <input type="email" name="email" class="w-full pl-9 outline-none placeholder:text-slate-400" placeholder="Email">
            </div>
            <div class="relative border-b pb-2 border-sky-50 mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-teal-500 w-14 absolute top-0 left-0">
                    <path d="M15 11h7v2h-7zm1 4h6v2h-6zm-2-8h8v2h-8zM4 19h10v-1c0-2.757-2.243-5-5-5H7c-2.757 0-5 2.243-5 5v1h2zm4-7c1.995 0 3.5-1.505 3.5-3.5S9.995 5 8 5 4.5 6.505 4.5 8.5 6.005 12 8 12z"></path>
                </svg>
                <input type="text" name="username" class="w-full pl-9 outline-none placeholder:text-slate-400" placeholder="Username">
            </div>
            <div class="relative border-b pb-2 border-sky-50 mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-teal-500 w-14 absolute top-0 left-0">
                    <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zm6 10 .002 8H6v-8h12zm-9-2V7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9z"></path>
                </svg>
                <input type="password" name="password" class="w-full pl-9 outline-none placeholder:text-slate-400" placeholder="Password">
            </div>
            <div class="mt-6 text-center">
                <button type="submit" class="px-6 py-2 rounded-full bg-teal-400 hover:bg-teal-500 text-white">Register</button>
            </div>
            <p class="text-slate-400 mt-8 text-center">Already an account? <button class="text-teal-500" @click="tab='login'">Login</button></p>
        </form>
    </div>
</template>