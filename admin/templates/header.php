<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/peraroja" ?>

    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="<?php echo $url; ?>/admin/inicio.php">Administrador <span class="sr-only"></span></a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/content/platosdb.php">Platos</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>">Sitio web</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/content/exit.php">Salir</a>
        </div>
    </nav>
    <div class="container">
        <br />
        <div class="row">