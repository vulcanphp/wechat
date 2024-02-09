<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $this->getBlock('title') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= resource_url('assets/dist/bundle.min.css') ?>">
    <script defer src="<?= resource_url('assets/dist/bundle.min.js') ?>"></script>
    <script src="https://js.pusher.com/7.0/pusher-with-encryption.min.js"></script>
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script>
        let pusher = new Pusher('<?= config('pusher.key') ?>', {
            cluster: '<?= config('pusher.cluster') ?>',
            encrypted: true,
            authEndpoint: '/pusher-auth',
            auth: {
                headers: {
                    'X-CSRF-Token': '<?= csrf_token() ?>'
                }
            }
        });

        window.chatroom = pusher.subscribe('private-encrypted-chatroom-<?= $auth->getUser()->id ?>');
        window.sounds = {
            notification: new Audio('/resources/assets/audio/mixkit-success-software-tone-2865.wav'),
            ringtone: new Audio('/resources/assets/audio/mixkit-marimba-ringtone-1359.wav'),
            ringing: new Audio('/resources/assets/audio/phone-calling-153844.mp3'),
        };
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<!-- <body> will be include in the alpine methods file -->
<?php $this->include('include.alpine.php'); ?>

<main class="w-full sm:w-10/12 md:w-9/12 lg:w-8/12 mx-auto">
    <div class="bg-white min-h-screen md:min-h-max rounded shadow p-3 sm:p-4 md:p-6 relative" x-data="{activeClient: true}" @mouseleave="activeClient = false" @mouseenter="activeClient = true">
        <?php $this
            ->include('parts.call.outgoing')
            ->include('parts.call.incoming')
            ->include('parts.call.room')
            ->include('include.error')
            ->include('include.flash');
        ?>
        {{content}}
    </div>
</main>

</body>

</html>