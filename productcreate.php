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
        $input_product = array($_POST['product_name'], $_POST['product_desc'], $temp[1],1, $_POST['price'], $_POST['stock'] | '1');
        $input_brand = array($_POST['brand_name'], $_POST['brand_desc']);
        $sql = "SELECT * from brands where b_name = '$input_brand[0]'";
        $result = mysqli_query($link, $sql);
        
        $sql = "INSERT INTO `project`.`products` (`p_name`,`p_desc`, " . $stringquery ." ,`brand_id`,`price`,`stock`) VALUES (?,?,?,?,?,?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiiii", $input_product[0], $input_product[1], $input_product[2], $input_product[3], $input_product[4], $input_product[5]);
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
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
                        <?php
                        $sql = "SELECT category_id, c_name FROM categories;";
                        if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                $i = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                    $i++;
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" id="flexRadioDefault1"
                                value="<?php echo "c.". $row['category_id'] ?>">
                            <label class="form-check-label" for="flexRadioDefault1">
                                <?php echo $row['c_name']; ?>
                            </label>
                        </div>
                        <?php }

                            }
                        }
                        ?>
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
                                value="<?php echo "sc.".$row['sc_id'] ?>">
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
                            <label>Brand Description</label>
                            <input type="text" name="brand_desc" class="form-control">
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