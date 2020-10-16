<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login || Register</title>
    <link rel="stylesheet" href="assets/css/changepwd.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>

    <?php

    session_start();
    if (!isset($_SESSION["changepermission"])) {
        header("Location: login.php");
    }
    require("backend.php");
    $error = NULL;
    $success = NULL;

    if(isset($_POST["change"])){
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        if($password == $cpassword){
            $user_mail = $_SESSION["email"];
            $password = sha1($password);
            $changepwd = $mysqli->query("UPDATE userdetails SET password = '$password' WHERE email = '$user_mail'");
            if($changepwd){
                $success = "password changed successfully!";
                unset($_SESSION["changepermission"]);
            }
        }else{
            $error = "passwords dont match, try again!";
        }
    }

    ?>

    <?php if ($success) { ?>
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <?php echo $success ?>
            <a href="login.php">Go to login page</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } elseif ($error) { ?>
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <?php echo $error ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

    <div class="container-fluid">

        <h1 class="text-primary ml-3 pt-3">Change <span class="text-dark">Password</span></h1>
        <form class="p-3" method="POST">
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Enter new password:" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required autocomplete="off" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" class="form-control" name="cpassword" placeholder="Confirm new password:" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required autocomplete="off">
            </div>
            <button type="submit" name="change" class="btn btn-primary">Change</button><br><br>
            <h6>got to<span><a href="login.php"> login page</a></span></h6>
        </form>

    </div>

    <script language="javascript" type="text/javascript" src="assets/js/login.js"></script>
</body>

</html>