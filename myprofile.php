<?php
    include("header.php");

    $queryId = "SELECT * FROM users WHERE email='$login_cookie'";
    $queryRes = mysqli_query($connect, $queryId);
    $resId = mysqli_fetch_assoc($queryRes);
    $email = $resId['email'];

    $querySelect = "SELECT * FROM pubs WHERE user='$email' ORDER BY id DESC";
    $pubs = mysqli_query($connect, $querySelect);

    if  (isset($_POST['settings'])) {
        header("Location: settings.php");
    }
    
    if  (isset($_POST['amigos'])) {
        header("Location: pedidos.php");
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
    div#menu input[name="settings"] { margin-right: 40px; }
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
        echo '<a href="profilepic.php" style="width: 100px; display: block; margin: auto;"><img src="img/user.png" id="profile"></a>';
    } else {
        echo '<a href="profilepic.php" style="width: 100px; display: block; margin: auto;"><img src="upload/'.$resId["img"].'" id="profile"></a>';
    }
?>
    <div id="menu">
        <form method="POST">
            <h2><?= $resId['nome']; ?></h2><br/>
            <input type="submit" value="Alterar Info" name="settings">
            <input type="submit" name="amigos" value="Ver Amigos">            
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