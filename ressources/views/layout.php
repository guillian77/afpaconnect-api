<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- WEBSITE: Title -->
    <title><?= $appTitle; ?></title>
</head>
<body>
    <div class="container">
        <header class="header boxed">
            <div class="flex topheader">
                <h1><a class="header__title" href="<?= $router->generate('home'); ?>" title="Aller sur l'accueil">AfpaConnect</a></h1>
                <!-- Hamburger Icon for responsive Menu -->
                <a href="javascript:void(0);" class="icon" onclick="mobileMenuHeader()">
                    <i id="menuIcon" class="fa fa-bars"></i>
                </a>
            </div>

            <?php if(isset($_SESSION['user']['uid'])): ?>
                <nav id="navbar" class="flex navbar">
                    <ul>
                        <li><a href="<?= $router->generate('UserManage'); ?>">Gestion utilisateurs</a></li>
                        <li><a href="<?= $router->generate('UserUpload'); ?>">Nouveaux utilisateurs</a></li>
                        <li><a href="<?= $router->generate('home'); ?>">Configuration</a></li>
                    </ul>
                </nav>

                <a class="btn" href="<?= $router->path('UserLogout'); ?>"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            <?php endif; ?>
        </header>

        <?= $content; ?>

        <footer class=" footer boxed">
            <p>&copy; 2021  Developped by Aufrère Guillian & Campillo Lucas for AFPA</p>
        </footer>
    </div>
</body>
</html>