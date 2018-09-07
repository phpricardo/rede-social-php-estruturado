<?php
    include("header.php");

    $querySelect = "SELECT * FROM pubs ORDER BY id DESC";
    $pubs = mysqli_query($connect, $querySelect);

    if (isset($_POST['publish'])) {
        if ($_FILES["file"]["error"] > 0) {
            $texto = $_POST['texto'];
            $hoje = date('Y-m-d');

            if ($texto == "") {
                echo "<h3>É necessário um texto para publicação.</h3>";
            } else {
                $queryInsert = "INSERT INTO pubs (user, texto, data) VALUES ('$login_cookie', '$texto', '$hoje')";
                $query = mysqli_query($connect, $queryInsert) or die();
                if ($query) {
                    header("Location: ./");
                } else {
                    echo "<h3>Desculpe, ocorreu algum erro.</h3>";
                }
            }
        } else {
            $n = rand(0, 1000000);
            $img = $n.$_FILES["file"]["name"];

            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$img);

            $texto = $_POST['texto'];
            $hoje = date('Y-m-d');

            if ($texto == "") {
                echo "<h3>É necessário um texto para publicação.</h3>";
            } else {
                $queryInsert = "INSERT INTO pubs (user, texto, imagem, data) VALUES ('$login_cookie', '$texto', '$img', '$hoje')";
                $query = mysqli_query($connect, $queryInsert) or die();
                if ($query) {
                    header("Location: ./");
                } else {
                    echo "<h3>Desculpe, ocorreu algum erro.</h3>";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style type="text/css">
    div#publish {width: 400px; height: 220px; display: block; margin: auto; border: none; border-radius: 5px; background: #FFF; box-shadow: 0 0 6px #A1A1A1; margin-top: 30px ;}
    div#publish textarea {width: 365px; height: 150px; display: block; margin: auto; border-radius: 5px; padding-left: 5px; padding-top: 5px; border-width: 1px; border-color: #A1A1A1;}
    div#publish img {margin-top: 0px; margin-left: 10px; width: 40px; cursor: pointer}
    div#publish input[type="submit"]{width: 70px; height: 25px; border-radius: 3px; float: right; margin-right: 15px; border: none; margin-top: 5px; background: #4169E1; color: #FFF; cursor: pointer;}
    div#publish input[type="submit"]:hover{background: #001F3F; }

    div.pub { width: 400px; min-height: 70px; max-height: 1000px; display: block; margin: auto; border: none; border-radius: 5px; background-color: #FFF; box-shadow: 0 0 6px #A1A1A1; margin-top: 30px; }
    div.pub a { color: #666; text-decoration: none; }
    div.pub a:hover { color: #111; text-decoration: none; }
    div.pub p { margin-left: 10px; content: #666; padding-top: 10px; }
    div.pub span { display: block; margin: auto; width: 380px; margin-top: 10px; }
    div.pub img { display: block; margin: auto; width: 100%; margin-top: 10px; border-bottom-left-radius: 5px; border-bottom-rigth-radius: 5px; }

    div#footer {  width: 300px; min-height: 70px; max-height: 1000px; display: block; margin: auto; text-align: center;  }
    </style>
</head>
<body>
    <div id="publish">
        <form method="POST" enctype="multipart/form-data">
            <br/>
            <textarea name="texto" placeholder="Escreva sua publicação..."></textarea>
            <label for="file-input">
                <img src="img/imagegrey.png" title="Adicionar um Foto"/>
            </label>
            <input type="submit" value="Publicar" name="publish"/>
            <input type="file" id="file-input" name="file" hidden />
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
    <br/>
    <div id="footer">&copy; Meet New Friends, 2018 - Todos os Direitos Reservados</div>
</body>
</html>