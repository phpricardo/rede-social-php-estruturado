<?php
    include("db.php");

    if (isset($_POST['entrar'])) {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $sql = "SELECT * FROM users WHERE email = '$email' and password = '$pass'";
        $verifica = mysqli_query($connect, $sql);
        if (mysqli_num_rows($verifica) <= 0) {
            echo "<h3>Senha ou e-mail inválidos!</h3>";
        } else {
            setcookie("login", $email);
            header("location: ./");
        }
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
        img {
            display: block; 
            margin: auto; 
            margin-top: 20px; 
            width: 200px;
        }

        form {
            text-align: center;
            margin-top: 20px;
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
    <img src="img/logo.png"><br/>
    <h2>Entre com sua conta</h2>
    <form method="POST">
        <input type="email" placeholder="Endereço de E-mail" name="email"><br/>
        <input type="password" placeholder="Senha" name="pass"><br/>
        <input type="submit" value="Entrar" name="entrar">
    </form>
    <h3>Não é cadastrado? <a href="registrar.php">Cadastre-se!</a></h3>
</body>
</html>