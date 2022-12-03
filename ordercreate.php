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
        $myfile = fopen("nonce.txt", "a");
        $nonce = $nonce = file_get_contents("nonce.txt");
        $sql = "INSERT INTO `project`.`orders` (`client_id`,`product_id` ,`quantity`,`amount`,`nonce` ) VALUES (?,?,?,?,?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiiis", $input_product[0], $input_product[1], $input_product[2], $amount, $nonce);
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page  
                if (isset($_POST['checkout'])) {
                    header("location: checkout.php");
                }
                if (isset($_POST['add'])) {
                    header("location: ordercreate.php");
                }
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
    <title>Add Order</title>
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
                    <h2 class="mt-5">Add Order</h2>
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
                        <input type="submit" class="btn btn-primary" name="add" value="Add another order">
                        <input type="submit" class="btn btn-primary" name="checkout" value="Checkout">
                        <!-- <a href="checkout.php" class="btn btn-primary ml-2">Checkout</a> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>