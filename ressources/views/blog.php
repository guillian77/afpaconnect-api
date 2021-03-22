<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog test</title>
</head>
<body>
    <h1>Liste des articles</h1>
    <ul>
        <?php foreach($posts as $post): ?>
            <li><?= $post['subject_tickets']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>