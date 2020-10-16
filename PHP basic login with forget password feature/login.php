<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login || Register</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="icon" href="images/empicon.png">
</head>

<body>

    <?php

    require("backend.php");
    $error = NULL;
    $success = NULL;
    if (isset($_POST["register"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $favfood = $_POST["favfood"];
        if ($password == $cpassword) {
            $usernamecheck = $mysqli->query("SELECT username FROM userdetails WHERE username = '$username'");
            $user_row = $usernamecheck->fetch_assoc();
            $emailcheck = $mysqli->query("SELECT email FROM userdetails WHERE email = '$email'");
            $email_row = $emailcheck->fetch_assoc();
            if ($user_row) {
                $error = "Username exists, try another one!";
            } elseif ($email_row) {
                $error = "email already exists, try another one!";
            } else {
                $password = sha1($password);
                $favfood = sha1($favfood);
                $userinsert = $mysqli->query("INSERT INTO userdetails(username, email, password, favfood) VALUES('$username', '$email', '$password', '$favfood')");
                if ($userinsert) {
                    $success = "user registered successfully!";
                } else {
                    $error = "some error occured try again!";
                }
            }
        } else {
            $error = "passwords dont match, try again!";
        }
    }

    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password = sha1($password);
        $result = $mysqli->query("SELECT email, password FROM userdetails WHERE email = '$email' AND password = '$password'");
        if ($row = $result->fetch_assoc()) {
            session_start();
            $result = $mysqli->query("SELECT * FROM userdetails WHERE email = '$email' AND password = '$password'");
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row["username"];
            $_SESSION['user_id'] = $row["user_id"];
            header("Location:index.php");
        } else {
            $error =  "Invalid email or password!";
        }
    }

    if (isset($_POST["enter"])) {
        $email = $_POST["email"];
        $favfood = $_POST["favfood"];
        $favfood = sha1($favfood);
        $check = $mysqli->query("SELECT * FROM userdetails WHERE email = '$email' AND favfood = '$favfood'");
        $checkrow = $check->fetch_assoc();
        if ($checkrow) {
            session_start();
            $_SESSION["changepermission"] = TRUE;
            $_SESSION["email"] = $email;
            header("Location: changepwd.php");
        } else {
            $error = "Invalid email or favorite food, try again!";
        }
    }

    ?>

    <?php if ($success) { ?>
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <?php echo $success ?>
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

    <div id="loginform" class="container-fluid">

        <h1 class="text-primary ml-3 pt-3">Login <span class="text-dark">Form</span></h1>
        <form class="p-3" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" name="email" placeholder="Enter Email:" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Enter Password:" required autocomplete="off">
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button><br><br>
            <h6>Dont have an account? <span><a id="registerbtn"> Register</a></span></h6>
            <h6><a id="forgotbtn">Forgot Password?</a></h6>
        </form>

    </div>

    <div id="registerform" class="container-fluid" style="display: none;">

        <h1 class="text-primary ml-3 pt-3">Register <span class="text-dark">Form</span></h1>
        <form class="p-3" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" placeholder="Enter Username:" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="email" placeholder="Enter Email:" required autocomplete="off">
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="username">What is your favorite food?</label>
                    <input type="password" class="form-control" name="favfood" placeholder="Enter favorite food:" required autocomplete="off">
                </div>
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Enter Password:" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password:</label>
                <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password:" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required autocomplete="off">
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button><br><br>
            <h6>Have an account? <span><a id="loginbtn"> Login</a></span></h6>
        </form>

    </div>

    <div id="forgotform" class="container-fluid" style="display: none;">

        <h1 class="text-primary ml-3 pt-3">Reset <span class="text-dark">Password</span></h1>
        <form class="p-3" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" name="email" placeholder="Enter Email:" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="favfood">What is you favorite food?</label>
                <input type="password" class="form-control" name="favfood" placeholder="Enter favorite food:" required autocomplete="off">
            </div>
            <button type="submit" name="enter" class="btn btn-primary">Enter</button><br><br>
            <h6>got to<span><a href="login.php"> login page</a></span></h6>
        </form>

    </div>

    <script language="javascript" type="text/javascript" src="assets/js/login.js"></script>
</body>

</html>