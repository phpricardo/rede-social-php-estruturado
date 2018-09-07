<?php
    include("header.php");

    $querySelect = "SELECT * FROM amizades WHERE para='$login_cookie' AND aceite='nao' ORDER BY id DESC";
    $pubs = mysqli_query($connect, $querySelect);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $queryId = "SELECT * FROM users WHERE id='$id'";
        $queryRes = mysqli_query($connect, $queryId);
        $resId = mysqli_fetch_assoc($queryRes);
        $email = $resId['email'];

        $deleteQuery = "UPDATE amizades SET aceite='sim' WHERE de='$email' AND para='$login_cookie'";
        $queryResDelete = mysqli_query($connect, $deleteQuery);
        if ($queryResDelete) {
            header("Location: pedidos.php");
        } else {
            echo "<h3>Erro ao aceitar amizade</h3>";
        }

        if (isset($_GET['remover'])) {
            $id = $_GET['remover'];
            echo $id;
            $queryId = "SELECT * FROM users WHERE id='$id'";
            $queryRes = mysqli_query($connect, $queryId);
            $resId = mysqli_fetch_assoc($queryRes);
            $email = $resId['email'];
    
            $deleteQuery = "DELETE FROM amizades WHERE de='$login_cookie' AND para='$email' OR para='$login_cookie' AND de='$email'";
            echo $deleteQuery;
            $queryResDelete = mysqli_query($connect, $deleteQuery);
            var_dump($queryResDelete);
            if ($queryResDelete) {
                header("Location: profile.php");
            } else {
                echo "<h3>Erro ao excluir amizade</h3>";
            }
        }
    }


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style type="text/css">
    h3 { text-align: center; color: 007FFF; }
    div.pub { width: 400px; min-height: 70px; max-height: 1000px; display: block; margin: auto; border: none; border-radius: 5px; background-color: #FFF; box-shadow: 0 0 6px #A1A1A1; margin-top: 30px; }
    div.pub a { color: #666; text-decoration: none; text-align: center; }
    div.pub a:hover { color: #111; text-decoration: none; }
    div.pub p { content: #666; text-align: center; }
    div.pub span { display: block; margin: auto; padding-top: 20px; text-align: center; }
    div.pub input { cursor: pointer; height: 25px; padding-right: 10px; padding-left: 10px; border-radius: 3px; background-color: #007FFF; border: none; color: #FFF; }
    div.pub input:houver { background-color: #FFF; color: #007FFF; }
    
    div#footer {  width: 300px; min-height: 70px; max-height: 1000px; display: block; margin: auto; text-align: center;  }
    </style>
</head>
<body>
    <?php 
        // loop para trazer as publicações cadastradas
        while ($pub = mysqli_fetch_assoc($pubs)) {
            $email = $pub['de'];
            $sql = "SELECT * FROM users WHERE email='$email'";
            $querySql = mysqli_query($connect, $sql);
            $res = mysqli_fetch_assoc($querySql);

            $nome = $res['nome'] . " " . $res['apelido'];
            $id = $pub['id'];

            echo '
                <div class="pub" id="'.$id.'">
                    <span>'.$nome.' quer ser seu/sua amigo(a)!</span><br/>
                    <p><a href="profile.php?id='.$res['id'].'"> ver perfil de '.$nome.'</a></p><br/>
                    <a href="pedidos.php?id='.$res['id'].'"><input type="submit" value="Aceitar" name="add"></a>&nbsp&nbsp
                    <a href="pedidos.php?remover='.$res['id'].'"><input type="submit" value="Recusar" name="remover"></a>
                    <br/><br/>
                </div>';
        }
    ?>
    <br/>
    <br/>
    <h3>Não há solicitação de amizades pendentes.</h3>
    <br/>
    <div id="footer">&copy; Meet New Friends, 2018 - Todos os Direitos Reservados</div>
</body>
</html>