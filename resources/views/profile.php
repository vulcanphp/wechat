<?php
$this->layout('master')
    ->block('title', 'Profile - WeChat')
    ->with([
        'auth' => $auth = app()->getComponent('auth'),
        'user' => $user = $auth->getUser()
    ]);
?>
<?php $this
    ->include('include.header')
    ->include('include.flash')
?>
<div class="mt-8">
    <div class="border-b pb-3 border-sky-50 font-semibold flex items-center">
        <a href="/" class="text-teal-500 hover:text-teal-600">Chatroom</a>
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-6 text-slate-300" viewBox="0 0 24 24">
                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
            </svg>
        </span>
        <span class="text-slate-500">Profile Settings</span>
    </div>
    <form action="/profile" method="post" enctype="multipart/form-data" class="mx-auto max-w-96">
        <?= csrf() ?>
        <div class="md:md:flex items-center my-5">
            <div class="md:w-4/12 text-center mb-2 md:mb-0 md:text-right">
                <label for="name" class="mr-5">Name</label>
            </div>
            <div class="md:md:w-8/12">
                <input type="text" id="name" class="border border-slate-200 bg-slate-100 rounded-full px-4 py-2 w-full" name="name" value="<?= $user->name ?? '' ?>" placeholder="Enter Your Name">
            </div>
        </div>
        <div class="md:flex items-center my-5">
            <div class="md:w-4/12 text-center mb-2 md:mb-0 md:text-right">
                <label for="username" class="mr-5">Username</label>
            </div>
            <div class="md:w-8/12">
                <input type="text" id="username" class="border border-slate-200 bg-slate-100 rounded-full px-4 py-2 w-full" name="username" value="<?= $user->username ?>" placeholder="Enter Unique Username">
            </div>
        </div>
        <div class="md:flex items-center my-5">
            <div class="md:w-4/12 text-center mb-2 md:mb-0 md:text-right">
                <label for="email" class="mr-5">Email</label>
            </div>
            <div class="md:w-8/12">
                <input type="email" id="email" class="border border-slate-200 bg-slate-100 rounded-full px-4 py-2 w-full" name="email" value="<?= $user->email ?>" placeholder="Enter Email Address">
            </div>
        </div>
        <div class="md:flex items-center my-5">
            <div class="md:w-4/12 text-center mb-2 md:mb-0 md:text-right">
                <label for="password" class="mr-5">Password</label>
            </div>
            <div class="md:w-8/12">
                <input type="password" id="password" class="border border-slate-200 bg-slate-100 rounded-full px-4 py-2 w-full" name="password" placeholder="Change Password">
            </div>
        </div>
        <div class="md:flex items-center my-5">
            <div class="md:w-4/12 text-center mb-2 md:mb-0 md:text-right">
                <label for="avatar" class="mr-5">Avatar</label>
            </div>
            <div class="md:w-8/12 block">
                <span class="sr-only">Choose profile photo</span>
                <input type="file" id="avatar" name="avatar" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>
        </div>
        <div class="flex items-center justify-center md:justify-start pt-2">
            <div class="md:w-4/12 text-center mb-2 md:mb-0 md:text-right">
            </div>
            <div class="md:8-4/12">
                <button type="submit" class="px-6 py-2 rounded-full bg-teal-400 hover:bg-teal-500 text-white">Save Changes</button>
            </div>
        </div>
    </form>
</div>