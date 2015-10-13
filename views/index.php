<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="microcms.css" rel="stylesheet" />
    <title>Test1</title>
</head>
<body>
    <header>
        <h1>TEST</h1>
    </header>
    <?php
    $bdd = new PDO('mysql:host=localhost;dbname=agenda;charset=utf8', 'root', '');
    $entrees = $bdd->query('select * from role');
    foreach ($entrees as $entree): ?>
    <article>
        <h2><?php echo $entree['RoleLibelle'].' : '.$entree['RoleDescription'] ?></h2>
        
    </article>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">MicroCMS</a> is a minimalistic CMS built as a showcase for modern PHP development.
    </footer>
</body>
</html>
