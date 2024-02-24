<?php
session_start();

if(isset($_SESSION["user"])){
    header("Location: ../index.php");
    die();
}

if(isset($_POST["login"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    require_once('../database.php');

    $query = "SELECT * FROM job_seekers WHERE email = :email";
    $stmt = $db_connection->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        if(password_verify($password, $user["password"])){
            $_SESSION["user"] = "yes";
            header("Location: ..index.php");
            die();
        } else {
            echo "<div class='alert alert-danger'>Password does not match</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Email does not match</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">

    <title>Login form</title>
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <div class="form-group">
                <input 
                    type="email" 
                    placeholder="Enter email:" 
                    name="email" class="form-control"
                >
            </div>
            <div class="form-group">
                <input 
                    type="password" 
                    placeholder="Enter password:" 
                    name="password" 
                    class="form-control"
                >
            </div>
            <div class="form-btn">
                <input 
                    type="submit" 
                    value="Login" 
                    name="login" 
                    class="btn btn-primary"
                >
            </div>
        </form>
        <div>
            <a href="registration.php" class="link">Not registered yet? Register Here</a>
        </div>
    </div>
</body>
</html>
