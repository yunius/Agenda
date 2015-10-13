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
    foreach ($entrees as $entree): ?>
    <article>
        ----------------------------------------------------<br />
        <h2><?php echo $entree['collTitre'] ?></h2><br />
        <p>Description : <?php echo $entree['collObservations'] ?></p><br />
        <p>Nombre de participant maximum : <?php echo $entree['collNbparticipantMax'] ?></p><br />
        --------------------------------------------------------<br />
    </article>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">MicroCMS</a> is a minimalistic CMS built as a showcase for modern PHP development.
    </footer>
</body>
</html>
