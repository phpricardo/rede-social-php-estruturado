<?php
    include("db.php");

    if (isset($_POST['criar'])) {
        $nome = $_POST['nome'];
        $apelido = $_POST['apelido'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $data = date("Y-m-j");

        // valida email
        $sqlEmail = "SELECT email FROM users WHERE email = '$email'";
        $email_check = mysqli_query($connect, $sqlEmail);
        if($email_check) {
          $do_email_check = mysqli_num_rows($email_check);
        }
        if ($do_email_check >= 1) {
            echo "<h3>Este e-mail já está cadastrado. Faça o login <a href=\"login.php\">aqui</a></h3>";
        } elseif ($nome == '' or strlen($nome) < 3) {
            echo "<h3>Nome inválido!</h3>";
        } elseif ($email == '' or strlen($email) < 10) {
            echo "<h3>Email inválido!</h3>";
        } elseif ($pass == '' or strlen($pass) < 8) {
            echo "<h3>Senha inválida! * Deve conter mais de 8 caracteres. </h3>";
        } else {
            $sqlInsert = "INSERT INTO users (`nome`, `apelido`, `email`, `password`, `data`)
                    VALUES ('$nome', '$apelido', '$email', '$pass', '$data')";
            $result = mysqli_query($connect, $sqlInsert) or die(mysqli_error($connect));
            if($result) {
                setcookie("login", $email);
                header("Location: ./");
            } else {
                echo "<h3>Desculpe, houve um erro ao registrar.</h3>";
            }
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
    <img src="img/logo.png"><br/>
    <h2>Entre com sua conta</h2>
    <form method="POST" autocomplete="off">
        <input type="text" placeholder="Nome" name="nome"><br/>
        <input type="text" placeholder="Apelido" name="apelido"><br/>
        <input type="email" placeholder="E-mail" name="email"><br/>
        <input type="password" placeholder="Senha" name="pass"><br/>
        <input type="submit" value="Cadastrar" name="criar">
    </form>
    <h3>Já é cadastro? <a href="login.php">Entre por aqui!</a></h3>
</body>
</html>