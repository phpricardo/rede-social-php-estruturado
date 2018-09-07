<?php
    include("header.php");

    if (isset($_POST['save'])) {
        if ($_POST['file']['error'] > 0) {
            echo "<script>alert('Escolha ma foto');</script>";
        } else {
            $n = rand(0, 10000000);
            $img = $n.$_FILES['file']['name'];

            move_uploaded_file($_FILES['file']['tmp_name'], "upload/".$img);

            echo "A imagem já existe.";

            $queryUpdateImg = "UPDATE users SET `img`='$img' WHERE `email`='$login_cookie'";
            $queryExecImg = mysqli_query($connect, $queryUpdateImg);

            if ($queryExecImg) {
                header("Location: myprofile.php");
            } else {
                echo "<script>alert('Ocorreu um erro!');</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar imagem do perfil</title>
    <style type="text/css">
        body { background-color: #007FFF; }
        h2 { margin-top: 10px; text-align: center; color: #FFF; font-size: 49px; }
        form#perfil { display: block; margin: auto; text-align: center; width: 350px; margin-top: 20px; background-color: #FFF; box-shadow: 0 0 10px #666; border-radius: 5px; }
        input[type="submit"] { width: 100px; height: 25px; border: none; border-radius: 3px; background-color: #007fff; cursor: pointer; color: #FFF; }
        p { color: #FFF; text-align: center; }
        div#footer {  width: 300px; min-height: 70px; max-height: 1000px; display: block; margin: auto; text-align: center;  }
    </style>
</head>
<body>
    <h2>Alterar imagem do perfil</h2>
    <form method="POST" enctype="multipart/form-data" id="perfil">
        <br/>
        <h3>Imagem de Perfil</h3> <br/><br/>
        <input type="file" name="file"/> <br/><br/>
        <input type="submit" value="Salvar" name="save"/><br/><br/>
    </form>
    <br/><br/><br/>
    <div id="footer">&copy; Meet New Friends, 2018 - Todos os Direitos Reservados</div>
</body>
</html>