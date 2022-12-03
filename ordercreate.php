<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name

    try {
        $input_product = array($_POST['product_id'], $_POST['client_id'], $_POST['quantity']);
        $sql = "SELECT price from products where products_id = $input_product[0]";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $amount = $row['price'] * $input_product[2];
        $sql = "INSERT INTO `project`.`orders` (`client_id`,`product_id` ,`quantity`,`amount` ) VALUES (?,?,?,?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiii", $input_product[0], $input_product[1], $input_product[2], $amount);
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: order.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
        if (mysqli_query($link, $sql)) {

        } else {
            echo "INSERTION FAILED";
        }
    } catch (Error $e) {
        echo $e;
    }

    //header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add order to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Product ID</label>
                            <input type="text" name="product_id"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Client ID</label>
                            <input type="text" name="client_id"
                                class="form-control">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" name="quantity" class="form-control">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>