<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Page</title>
    <link rel="stylesheet" href="css/add.css">
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

    if (isset($_GET["editid"])) {
        $editid = $_GET["editid"];
    } else {
        $editid = NULL;
    }

    $error = NULL;
    $success = NULL;
    if (isset($_POST["add"])) {
        $name = $_POST["empname"];
        $email = $_POST["empmail"];
        $salary = $_POST["salary"];
        $insert = $mysqli->query("INSERT INTO employee(name, email, salary) values('$name', '$email', '$salary')");
        if ($insert) {
            $success = "Employee added successfully!";
        } else {
            $error = "Email or name already exists, try another one!";
        }
    }

    if (isset($_POST["update"])) {
        $name = $_POST["empname"];
        $email = $_POST["empmail"];
        $salary = $_POST["salary"];
        $update = $mysqli->query("UPDATE employee SET name = '$name', email = '$email', salary = '$salary' WHERE emp_id = '$editid'");
        if ($update) {
            $success = "Employee updated successfully!";
            session_start();
            $_SESSION["success"] = $success;
            unset($editid);
        } else {
            $error = "Email or name already exists, try another one!";
        }
    }

    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <h4 class="mt-2">Employee Portal</h4>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add.php">Add Employee<span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

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

    <div class="container" id="radius">
        <?php if (isset($editid)) {
            $getemp = $mysqli->query("SELECT * FROM employee WHERE emp_id = '$editid'");
            $emp = $getemp->fetch_assoc();
        ?>
            <h2 class="text-dark ml-3 pt-3">Edit <span class="text-primary">Employee</span></h2>
        <?php } else { ?>
            <h2 class="text-dark ml-3 pt-3">Add <span class="text-primary">Employee</span></h2>
        <?php } ?>
        <form class="p-3" method="POST">
            <div class="form-group">
                <label for="empname">Employee Name:</label>
                <?php if (isset($editid)) { ?>
                    <input value="<?php echo $emp["name"] ?>" type="text" class="form-control" name="empname" placeholder="Enter name:" required autocomplete="off">
                <?php } else { ?>
                    <input type="text" class="form-control" name="empname" placeholder="Enter name:" required autocomplete="off">
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="empmail">Employee Email:</label>
                <?php if (isset($editid)) { ?>
                    <input value="<?php echo $emp["email"] ?>" type="email" class="form-control" name="empmail" placeholder="Enter Email:" required autocomplete="off">
                <?php } else { ?>
                    <input type="email" class="form-control" name="empmail" placeholder="Enter Email:" required autocomplete="off">
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="salary">Employee Salary:</label>
                <?php if (isset($editid)) { ?>
                    <input value="<?php echo $emp["salary"] ?>" type="number" class="form-control" name="salary" placeholder="Enter Salary:" required autocomplete="off">
                <?php } else { ?>
                    <input type="number" class="form-control" name="salary" placeholder="Enter Salary:" required autocomplete="off">
                <?php } ?>
            </div>
            <?php if (isset($editid)) { ?>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            <?php } else { ?>
                <button type="submit" name="add" class="btn btn-primary">Add</button>
            <?php } ?>
        </form>
    </div>

</body>

</html>