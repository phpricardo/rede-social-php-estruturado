<?php
    include("header.php");

    $queryLogin = "SELECT * FROM users WHERE email='$login_cookie'";
    $queryExec = mysqli_query($connect, $queryLogin);
    $result = mysqli_fetch_assoc($queryExec);


    if (isset($_POST['atualizar'])) {
        $nome = $_POST['nome'];
        $apelido = $_POST['apelido'];
        $pass = $_POST['pass'];

        if($nome == "") {
            echo "<h2>Defina um nome.</h2>";
        } elseif ($apelido == "") {
            echo "<h2>Defina um apelido.</h2>";
        } elseif ($pass == "") {
            echo "<h2>Defina uma senha.</h2>";
        } else {
            $queryUpdate = "UPDATE users SET `nome`='$nome', `apelido`='$apelido', `password`='$pass' WHERE email='$login_cookie'";
            $dataRes = mysqli_query($connect, $queryUpdate);
            if ($dataRes) {
                header("Location: myprofile.php");
            } else {
                echo "Algo ocorreu de errado.";
            }
        }
    }

    if (isset($_POST['cancelar'])) {
        header("Location: myprofile.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meet new Friends!</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat" type="text/css">
    <style type="text/css">
        * { font-family: 'Montserrat', cursive; }
        img[name="header"] {
            display: block; 
            margin: auto; 
            margin-top: 20px; 
            width: 200px;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="text"] {
            border: 1px solid #CCC;
            width: 250px;
            height: 25px;
            padding-left: 10px;
            border-radius: 3px;
        }

        input[type="email"] {
            border: 1px solid #CCC;
            width: 250px;
            height: 25px;
            padding-left: 10px;
            border-radius: 3px;
        }

        input[type="password"] {
            border: 1px solid #CCC;
            width: 250px;
            height: 25px;
            padding-left: 10px;
            margin-top: 10px
            border-radius: 3px;
        }

        input[type="submit"] {
            border: none;
            width: 80px;
            height: 30px;
            margin-top: 20px;
            border-radius: 3px;
        }

        input[type="submit"]:hover {
            background-color: #1E90FF;
            color: #FFF;
            cursor: pointer;    
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }
        
        h3 {
            text-align: center;
            color: #1E90FF;
            margin-top: 15px;
        }

        a {
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <img name="header" src="img/logo.png"><br/>
    <h2>Alterar Configurações</h2>
    <form method="POST" autocomplete="off">
        <input type="text" placeholder="Nome" value="<?= $result['nome'] ?>" name="nome"><br/>
        <input type="text" placeholder="Apelido" value="<?= $result['apelido'] ?>" name="apelido"><br/>
        <input type="password" placeholder="Senha" value="<?= $result['password'] ?>" name="pass"><br/>
        <input type="submit" value="Atualizar" name="atualizar">&nbsp;&nbsp;&nbsp;
        <input type="submit" value="Cancelar" name="cancelar">
    </form>
</body>
</html>