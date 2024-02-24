<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: ../index.php");
    // die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Register Page</title>
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["submit"])){
            $fullName = $_POST["fullName"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirm_password = $_POST["comfirm_password"];

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();

            if(empty($fullName) || empty($email) || empty($password) || empty($confirm_password)){
                array_push($errors, "All fields are required");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errors, "Email is not valid");
            }
            if(strlen($password) < 8){
                array_push($errors, "Password must be at least 8 characters long");
            }
            if($password !== $confirm_password){
                array_push($errors, "Password does not match");
            }

            require_once('../database.php');

            $query = "SELECT * FROM job_seekers WHERE email = :email";
            $stmt = $db_connection->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $rowCount = $stmt->rowCount();

            if ($rowCount > 0) {
                array_push($errors, "Email already exists");
            }
            if(count($errors) > 0 ){
                foreach($errors as $error){
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                // Process registration or connect to the database here
                require_once('../database.php');
                // sLbbBWq3?UcC%F9
                // sLbbBWq3?UcC%F
                // for 4th feb
                // sLbbBWq3?UcC%F


                try {
                    $query = "INSERT INTO job_seekers (fullName, email, password) VALUES(?,?,?)";
                    $stmt = $db_connection->prepare($query);
                    
                    if ($stmt) {
                        $stmt->bindParam(1, $fullName);
                        $stmt->bindParam(2, $email);
                        $stmt->bindParam(3, $password_hash); // Use hashed password
                        $stmt->execute();
                        echo "<div class='alert alert-success'>You have registered successfully.</div>";
                        header("Location: ../index.php");
                        die();
                    } else {
                        echo "<div class='alert alert-danger'>Error preparing statement</div>";
                    }
                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                }
            }
        }
        ?>
        
        <form action="" method="post">
            <div class="form-group">
                <input type="text" 
                    placeholder="FullName" 
                    name="fullName"
                    class="form-control"
                    >
            </div>
            <div class="form-group">
                <input type="email" 
                    placeholder="Email" 
                    class="form-control" 
                    name="email" 
                    >
            </div>
            <div class="form-group">
                <input type="password" 
                    placeholder="Password" 
                    name="password"
                    class="form-control" 
                    >
            </div>
            <div class="form-group">
                <input type="password" 
                    placeholder="Confirm Password" 
                    name="comfirm_password"
                    class="form-control" 
                    >
            </div>
            <div class="form-btn">
                <input type="submit" 
                    value="Register" 
                    class="btn btn-primary" 
                    name="submit" 
                    >
            </div>
            <div class="form-group">
                <a href="login.php" class="link">Already have an account? Log in here</a>
            </div>
        </form>
    </div>
</body>
</html>
