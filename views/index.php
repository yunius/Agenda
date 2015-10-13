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
    foreach ($collectives as $collective): ?>
    <article>
        ----------------------------------------------------<br />
        <h2><?php echo $collective->getCollTitre() ?></h2><br />
        <p>Description : <?php echo $collective->getCollObservations() ?></p><br />
        <p>Nombre de participant maximum : <?php echo $collective->getCollNbparticipantMax() ?></p><br />
        --------------------------------------------------------<br />
    </article>
    <?php endforeach ?>
    <footer class="footer">
        <a href="https://github.com/bpesquet/OC-MicroCMS">MicroCMS</a> is a minimalistic CMS built as a showcase for modern PHP development.
    </footer>
</body>
</html>
