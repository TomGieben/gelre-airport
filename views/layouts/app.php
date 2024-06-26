<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_ENV['APP_NAME'] ?></title>
    <link rel="stylesheet" href="<?= asset('styles/app.css') ?>">
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.png') ?>">
</head>

<body>
    <header class="bg-primary">
        <a class="logo" href="/">
            <span><?= $_ENV['APP_NAME'] ?></span>
        </a>
        <input type="checkbox" id="toggleNav" class="toggleNav">
        <nav class="bg-primary">
            <ul>
                <?php if (App\Helpers\Auth::check()) : ?>
                    <?php if (App\Helpers\Auth::user()->isPassenger()) : ?>
                        <li><a href="/flights">Vluchten</a></li>
                        <li><a href="/luggage">Bagage</a></li>
                        <li><a href="/flight-info">Vlucht informatie</a></li>
                    <?php else : ?>
                        <li><a href="/flights">Vluchten</a></li>
                        <li><a href="/luggage">Bagage</a></li>
                        <li><a href="/passengers">Passagiers</a></li>
                    <?php endif ?>
                    <li>
                        <form method="POST" action="/logout">
                            <button type="submit">Uitloggen</button>
                        </form>
                    </li>
                <?php endif ?>
            </ul>
        </nav>
        <label for="toggleNav" class="toggleNavLabel">
            <span></span>
        </label>
    </header>
    <div class="fix"></div>

    <main class="wrapper">
        <div class="container">
            <?= App\Helpers\Error::show() ?>
        </div>
        @content
    </main>

    <footer>
        <div class="copyright">
            <p>&copy; 2024 <?= $_ENV['APP_NAME'] ?>. Alle rechten voorbehouden.</p>
        </div>
    </footer>
</body>

</html>