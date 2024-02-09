<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $this->getBlock('title') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= resource_url('assets/dist/bundle.min.css') ?>">
    <script defer src="<?= resource_url('assets/dist/bundle.min.js') ?>"></script>
</head>

<body class="text-slate-800 bg-gradient-to-b from-sky-100 to-fuchsia-200 flex items-center justify-center container min-h-screen">
    <main x-data="{tab: '<?= input('tab', 'login') ?>'}" class="w-11/12 sm:w-8/12 md:w-7/12 lg:w-6/12 xl:w-4/12 mx-auto">
        <div class="bg-white rounded p-6 md:p-8 shadow">
            <?php $this
                ->include('parts.auth.login')
                ->include('parts.auth.register')
                ->include('include.flash')
            ?>
        </div>
    </main>

</body>

</html>