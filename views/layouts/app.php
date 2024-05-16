<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $env['APP_NAME'] ?></title>
    <link rel="stylesheet" href="public/styles/app.css">
</head>
<body>
    <header class="bg-primary">
        <a class="logo" href="/">
            <span><?= $env['APP_NAME'] ?></span>
        </a>
        <input type="checkbox" id="toggleNav" class="toggleNav">
            <nav class="bg-primary">
                <ul>
                    <?php if (true): ?>
                        <li><a href="/flights">Vluchten</a></li>
                        <li><a href="/luggage">Bagage</a></li>
                        <li><a href="/flight-info">Vlucht informatie</a></li>
                    <?php else: ?>
                        <li><a href="/flights">Vluchten</a></li>
                        <li><a href="/luggage">Bagage</a></li>
                        <li><a href="/passengers">Passagiers</a></li>
                    <?php endif ?>

                    <?php if (isset($_SESSION['user'])): ?>
                        <li><a href="/user">Jouw account</a></li>
                        <li><a href="/logout">Uitloggen</a></li>
                    <?php endif ?>
                </ul>
            </nav>
        <label for="toggleNav" class="toggleNavLabel">
            <span></span>
        </label>
    </header>
    <div class="fix"></div>

    <main class="wrapper">
        @content
    </main>
</body>
</html>