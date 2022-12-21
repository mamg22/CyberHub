<html lang="es">
<head>
    <meta charset="utf-8">
    <title>AAAA</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<ul>
<?php
    function isdotdir(string $dir)
    {
        if ($dir == "." || $dir == "..") {
            return true;
        }
        return false;
    }

    $dirs = scandir('.');
    foreach ($dirs as &$dir) {
        if (isdotdir($dir)) {
            continue;
        }
        else if (! (str_ends_with($dir, ".php") or str_ends_with($dir, ".html"))) {
            continue;
        }
?>
        <li><a href="<?= $dir ?>"><?= $dir ?></a></li>
<?php
    }
?>
</ul>
</body>
</html>
