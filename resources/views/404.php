<!DOCTYPE html>
<html lang="<?= __lang() ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oops! Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0f172a;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        main {
            color: #e2e8f0;
            text-align: center;
            font-size: 16px;
            width: 90%;
            max-width: 400px;
        }
    </style>
</head>

<body>
    <main>
        <h2 style="font-size:72px; color: #fbbf24;">Oops!</h2>
        <br>
        <h2 style="font-size: 36px;">Page Not Found</h2>
        <br><br>
        <p style="color: #fcd34d;font-size: 20px;">We can't seem to find what you were looking for, that might be deleted or does not exist any more.</p>
        <br><br>
        <a href="<?= home_url() ?>" style="color: #f1f5f9;">&larr; Back To Home</a>
    </main>
</body>

</html>