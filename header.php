<?php
    include("db.php");

    $login_cookie = $_COOKIE['login'];
    if (!isset($login_cookie)) {
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat" type="text/css">
    <style type="text/css">
        * { font-family: 'Montserrat', cursive; margin: 0px; }
        body { background: #F6F6F6; }
        div#topo { width: 100%; top: 0; background: #FFF; box-shadow: 0 0 7px #000; height: 90px; }
        div#topo img[name="logo"] { float: left; margin-left: 20px; margin-top: 10px; }
        div#topo img[name="menu"] { float: right; margin-left: 25px; margin-top: -22px; }
        div#topo input[type="text"] { display: block; margin: auto; width: 300px; border: none; border-radius: 3px; background: #F6F6F6; height: 25px; padding-left: 10px; box-shadow: inset 0 0 6px #666; }
        div#topo form { width: 300px; display: block; margin: auto; padding-top: 22px; }
    </style>
</head>
<body>
    <div id="topo">
        <a href="index.php"><img src="img/logo.png" width="100" name="logo"></a>
        <form method="GET">
            <input type="text" placeholder="Pesquisar alguém..." name="query" autocomplete="off"><input type="submit" hidden>
        </form>
        <a href="#"><img src="img/chat.png" width="30" name="menu"></a>
        <a href="pedidos.php"><img src="img/pedidos.png" width="30" name="menu"></a>
        <a href="myprofile.php"><img src="img/perfil.png" width="30" name="menu"></a>
    </div>
</body>
</html>
