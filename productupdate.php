<?php
// Include config file
require_once "config.php";
// Define variables and initialize with empty values
 
// Processing form data when form is submitted
// Check input errors before inserting in database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])){
    // Prepare an update statement
    try{
        $p_name = $_POST["product_name"];
        $p_desc = $_POST['product_desc'];
        $module = $_POST[ 'brand_name' ];
        $query = "SELECT brand_id from brands where b_name = '{$module}'";
        $result = mysqli_query($link, $query);
        $bid = mysqli_fetch_assoc($result);
        echo $bid['brand_id'];
        if(is_null($bid['brand_id']))
        {
            header("location: error.php");
        }
        $sql = "UPDATE products SET p_name = ?, p_desc = ?, price = ? ,stock = ?, `sc_id` = ?, brand_id = ? WHERE products_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiiiii", $p_name, $p_desc, $_POST["price"], $_POST["stock"], $_POST['category'],$bid['brand_id'], $_POST["product_id"]);
            
            // Set parameters
            // Attempt to execute the prepared statement
            //adding a comment to commit
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: productadmin.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
    }
    catch(Error $e){
        echo $e;
    }
        
    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the stadium record.</p>
                    <?php 
                    $product_id = $_GET["product_id"];
                    $sql = "SELECT products_id,p_name, p_desc, c_name, sc_name, b_name, b_desc, price,stock 
                    from products p 
                    inner join brands b on b.brand_id = p.brand_id 
                    left join subcategories s on s.sc_id = p.sc_id
                    left join categories c on s.category_id = c.category_id where p.products_id = $product_id;";
                    $values = mysqli_query($link,$sql);
                    $row1 = mysqli_fetch_array($values, MYSQLI_ASSOC)
                    ?>
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
                                value="<?php echo $row["sc_id"] ?>">
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
                            <input type="text" name="product_name" class="form-control"
                                value="<?php echo $row1['p_name']?>">
                        </div>
                        <div class="form-group">
                            <label>Product Description</label>
                            <input type="text" name="product_desc" class="form-control"
                                value="<?php echo $row1['p_desc']?>">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Brand Name</label>
                            <input type="text" name="brand_name" class="form-control"
                                value="<?php echo $row1["b_name"]?>">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $row1['price']?>">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="text" name="stock" class="form-control" value="<?php echo $row1['stock']?>">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <input type = "hidden" name = "product_id" value = "<?php echo $product_id ?>">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>