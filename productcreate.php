<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name

    try {
        $input_product = array($_POST['product_name'], $_POST['product_desc'], $_POST['category'],$_POST['price'], $_POST['stock']);
        $module = $_POST[ 'brand_name' ];
        $query = "SELECT brand_id from brands where b_name = '{$module}'";
        $result = mysqli_query($link, $query);
        $bid = mysqli_fetch_assoc($result);
        echo $bid['brand_id'];
        if(is_null($bid['brand_id']))
        {
            header("location: error.php");
        }
        $sql = "INSERT INTO `project`.`products` (`p_name`,`p_desc`, `sc_id` ,`brand_id`,`price`,`stock`) VALUES (?,?,?,?,?,?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiiii", $input_product[0], $input_product[1], $input_product[2],$bid['brand_id'] , $input_product[3], $input_product[4]);
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: productadmin.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    } catch (Error $e) {
        echo $e;
    }
    header('location:index.php');
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
                    <p>Please fill this form and submit to add product to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <h2>Sub Categories </h2>
                        <?php
                        $sql = "SELECT sc_id, sc_name FROM subcategories;";
                        if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                $i = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                    $i++;
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" id="flexRadioDefault1"
                                value="<?php echo $row['sc_id'] ?>" required = "required">
                            <label class="form-check-label" for="flexRadioDefault1">
                                <?php echo $row['sc_name']; ?>
                            </label>
                        </div>
                        <?php }

                            }
                        }
                        ?>
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="product_name"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Product Description</label>
                            <input type="text" name="product_desc"
                                class="form-control">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Brand Name</label>
                            <input type="text" name="brand_name" class="form-control">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="text" name="stock" class="form-control">
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