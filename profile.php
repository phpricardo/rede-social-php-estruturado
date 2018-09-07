<?php
    include("header.php");

    $id = $_GET['id'];
    $queryId = "SELECT * FROM users WHERE id='$id'";
    $queryRes = mysqli_query($connect, $queryId);
    $resId = mysqli_fetch_assoc($queryRes);
    $email = $resId['email'];

    if($email == $login_cookie) {
        header("Location: myprofile.php");
    }

    $querySelect = "SELECT * FROM pubs WHERE user='$email' ORDER BY id DESC";
    $pubs = mysqli_query($connect, $querySelect);

        if (isset($_POST['add'])) {
            add();
        }

        function add(){
            global $connect;

            $login_cookie = $_COOKIE['login'];
            if (!isset($login_cookie)) {
                header("Location: login.php");
            }

            $id = $_GET['id'];
            $queryId = "SELECT * FROM users WHERE `id`='$id'";
            $queryRes = mysqli_query($connect, $queryId);
            $resId = mysqli_fetch_assoc($queryRes);
            $email = $resId['email'];
            $date = date("Y/m/d");

            $insertQuery = "INSERT INTO amizades (`de`, `para`, `data`) VALUES ('$login_cookie', '$email', '$date')";
            $queryResInsert = mysqli_query($connect, $insertQuery);
            if ($queryResInsert) {
                header("Location: profile.php?id=".$id);
            } else {
                echo "<h3>Erro ao enviar pedido</h3>";
            }
        }
            if (isset($_POST['cancelar'])) {
                cancelar();
            }
    
            function cancelar(){
                global $connect;
                
                $login_cookie = $_COOKIE['login'];
                if (!isset($login_cookie)) {
                    header("Location: login.php");
                }

                $id = $_GET['id'];
                $queryId = "SELECT * FROM users WHERE id='$id'";
                $queryRes = mysqli_query($connect, $queryId);
                $resId = mysqli_fetch_assoc($queryRes);
                $email = $resId['email'];
        
                $cancelQuery = "DELETE FROM amizades WHERE de='$login_cookie' AND para='$email'";
                $queryResCancel = mysqli_query($connect, $cancelQuery);
                if ($queryResCancel) {
                    header("Location: profile.php?id=".$id);
                } else {
                    echo "<h3>Erro ao enviar pedido</h3>";
                }
            }

            if (isset($_POST['remover'])) {
                remover();
            }
        
            function remover(){
                global $connect;
                
                $login_cookie = $_COOKIE['login'];
                if (!isset($login_cookie)) {
                    header("Location: login.php");
                }
                $id = $_GET['id'];
                $queryId = "SELECT * FROM users WHERE id='$id'";
                $queryRes = mysqli_query($connect, $queryId);
                $resId = mysqli_fetch_assoc($queryRes);
                $email = $resId['email'];
        
                $deleteQuery = "DELETE FROM amizades WHERE `de`='$login_cookie' AND para='$email' OR `para`='$login_cookie' AND de='$email'";
                $queryResDelete = mysqli_query($connect, $deleteQuery);
                if ($queryResDelete) {
                    header("Location: profile.php?id=".$id);
                } else {
                    echo "<h3>Erro ao excluir amizade</h3>";
                }
            }

            if (isset($_POST['aceitar'])) {
                aceitar();
            }
        
            function aceitar(){
                global $connect;

                $login_cookie = $_COOKIE['login'];
                if (!isset($login_cookie)) {
                    header("Location: login.php");
                }
                $id = $_GET['id'];
                $queryId = "SELECT * FROM users WHERE id='$id'";
                $queryRes = mysqli_query($connect, $queryId);
                $resId = mysqli_fetch_assoc($queryRes);
                $email = $resId['email'];
        
                $deleteQuery = "UPDATE amizades SET `aceite`='sim' WHERE `de`='$email' AND para='$login_cookie'";
                $queryResDelete = mysqli_query($connect, $deleteQuery);
                if ($queryResDelete) {
                    header("Location: profile.php?id=".$id);
                } else {
                    echo "<h3>Erro ao excluir amizade</h3>";
                }
            }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<style type="text/css">
    h2 { text-align: center; padding-top: 30px; color: #FFF; }
    img#profile { width: 100px; height: 100px; display: block; margin: auto; margin-top: 30px; border: 5px solid #007FFF; background-color: #007FFF; border-radius: 10px; margin-bottom: -30px; }
    div#menu { width: 300px; height: 120px; display: block; margin: auto; border: none; border-radius: 5px; background-color: #007FFF; text-align: center; }
    div#menu input { height: 25px; border: none; border-radius: 3px; background-color: #FFF; cursor: pointer; }
    div#menu input[name="add"] { margin-right: 40px; }
    div#menu input[name="aceitar"] { margin-right: 40px; }
    div#menu input[name="remove"] { margin-right: 40px; }
    div#menu input[name="cancelar"] { margin-right: 40px; }
    div#menu input:hover { height: 25px; border: none; border-radius: 3px; background-color: transparent; cursor: pointer; color: #FFF; }
    div.pub { width: 400px; min-height: 70px; max-height: 1000px; display: block; margin: auto; border: none; border-radius: 5px; background-color: #FFF; box-shadow: 0 0 6px #A1A1A1; margin-top: 30px; }
    div.pub a { color: #666; text-decoration: none; }
    div.pub a:hover { color: #111; text-decoration: none; }
    div.pub p { margin-left: 10px; content: #666; padding-top: 10px; }
    div.pub span { display: block; margin: auto; width: 380px; margin-top: 10px; }
    div.pub img { display: block; margin: auto; width: 100%; margin-top: 10px; border-bottom-left-radius: 5px; border-bottom-rigth-radius: 5px; }
</style>
</head>
<body>
<?php
    if($resId['img']=="") {
        echo '<img src="img/user.png" id="profile">';
    } else {
        echo '<img src="upload/'.$resId["img"].'" id="profile">';
    }
?>
    <div id="menu">
        <form method="POST">
            <h2><?= $resId['nome'] . " " . $resId['apelido']; ?></h2><br/>
            <?php
                $queryAmigos = "SELECT * FROM amizades WHERE `de`='$login_cookie' AND para='$email' OR `para`='$login_cookie' AND de='$email'";
                $amigos = mysqli_query($connect, $queryAmigos);
                $amigosS = mysqli_fetch_assoc($amigos);
                if (mysqli_num_rows($amigos) >= 1 AND $amigosS["aceite"] == "sim") {
                    echo '<input type="submit" value="Remover Amigo" name="remover">&nbsp&nbsp&nbsp<input type="submit" name="denunciar" value="Denunciar">';
                } elseif (mysqli_num_rows($amigos) >= 1 AND $amigosS["aceite"] == "nao" AND $amigosS["para"] == $login_cookie ) {
                    echo '<input type="submit" value="Aceitar Pedido" name="aceitar"><input type="submit" name="denunciar" value="Denunciar">';
                } elseif (mysqli_num_rows($amigos) >= 1 AND $amigosS["aceite"] == "nao" AND $amigosS["de"] == $login_cookie ) {
                    echo '<input type="submit" value="Cancelar Pedido" name="cancelar"><input type="submit" name="denunciar" value="Denunciar">';
                } else {
                    echo '<input type="submit" value="Adicionar Amigo" name="add"><input type="submit" name="denunciar" value="Denunciar">';
                }
            ?>
        </form>
    </div>
<?php 
    // loop para trazer as publicações cadastradas
    while ($pub = mysqli_fetch_assoc($pubs)) {
        $email = $pub['user'];
        $sql = "SELECT * FROM users WHERE email='$email'";
        $querySql = mysqli_query($connect, $sql);
        $res = mysqli_fetch_assoc($querySql);

        $nome = $res['nome'] . " " . $res['apelido'];
        $id = $pub['id'];

        if ($pub['imagem'] == "") {
            echo '<div class="pub" id="'.$id.'">
                    <p><a href="profile.php?id='.$res['id'].'">'.$nome.'</a> - '.$pub['data'].'</p>
                    <span>'.$pub['texto'].'</span><br/>
                    </div>';
        } else {
            echo '<div class="pub" id="'.$id.'">
                    <p><a href="profile.php?id='.$res['id'].'">'.$nome.'</a> - '.$pub['data'].'</p>
                    <span>'.$pub['texto'].'</span>
                    <img src="upload/'.$pub['imagem'].'"/>
                    </div>';
        }
    }
?>
</body>
</html>