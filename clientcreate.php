<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name

    try {
        $temp= explode(".",$_POST['category']);
        $stringquery = '';
        if($temp[0] = 'sc'){
            $stringquery = '`sc_id`';
        }
        else{
            $stringquery = '`category_id`';
        }
        $input_product = array($_POST['client_name'], $_POST['address'], $_POST['phone_no']); 
        $sql = "INSERT INTO `project`.`clients` (`client_name`,`address`,`phone_no`) VALUES (?,?,?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $input_product[0], $input_product[1], $input_product[2]);
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: client.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
        if (mysqli_query($link, $sql)) {
        } else {
            echo "INSERTION FAILED!";
        }
        // $sql = "INSERT INTO brand VALUES (";
        // for ($i = 0; $i < count($input_arr); $i++) {
        //     $sql = $sql . $input_brand[$i] . ",";
        // }
        // $sql = $sql . ");";
        // if (mysqli_query($link, $sql)) {

        // } else {
        //     echo "INSERTION FAILED";
        // }
    } catch (Error $e) {
        echo $e;
    }
    // Check input errors before inserting in database


    // Close connection
    //header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Client Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Client Record</h2>
                    <p>Please fill this form and submit to add client to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Client Name</label>
                            <input type="text" name="client_name"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Client Address</label>
                            <input type="text" name="address"
                                class="form-control">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Phone Number (eg: 03.....)</label>
                            <input type="text" name="phone_no" class="form-control">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="client.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>