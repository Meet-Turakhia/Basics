<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="icon" href="images/empicon.png">
</head>

<body>
    <?php
    require("backend.php");
    session_start();
    $error = NULL;
    $success = NULL;
    if (isset($_GET["deleteid"])) {
        $deleteid = $_GET["deleteid"];
        $delete = $mysqli->query("DELETE FROM employee WHERE emp_id = '$deleteid'");
        if ($delete) {
            $success = "Employee deleted successfully!";
            header("Location: index.php");
        } else {
            $error = "Some error occurred, try again!";
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
            <form class="dropdown form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2 border border-primary" type="text" name="search_text" id="search_text" placeholder="Search Employee" aria-label="Search">
                <div class="dropdown-content" id="result"></div>
            </form>
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

    <div class="container mb-5">
        <h1 class="text-primary">Employee <span class="text-dark">Details</span><span style="float: right;"><a href="add.php" title="Add Employee"><i class="fas fa-plus-circle mr-2"></i></a></span></h1>
        <table class="table table-responsive-sm bg-light">
            <thead>
                <tr class="bg-primary">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getemp = $mysqli->query("SELECT * FROM employee");
                while ($emparray = $getemp->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $emparray["emp_id"] ?></td>
                        <td><?php echo $emparray["name"] ?></td>
                        <td><?php echo $emparray["email"] ?></td>
                        <td><?php echo $emparray["salary"] ?></td>
                        <td><a href="view.php?viewid=<?php echo $emparray["emp_id"] ?>" title="view"><i class="fas fa-eye ml-3"></i></a>
                            <a href="add.php?editid=<?php echo $emparray["emp_id"] ?>" title="edit"><span class="ml-3"><i class="fas fa-edit"></i></span></a>
                            <a onclick="return confirm('Are you sure, you want to delete the record?')" href="index.php?deleteid=<?php echo $emparray["emp_id"] ?>" title="delete"><span class="ml-3"><i class="fas fa-trash"></i></span></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="javascript/ajax.js" type="text/javascript"></script>
</body>

</html>