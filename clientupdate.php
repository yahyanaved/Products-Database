<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
 
// Processing form data when form is submitted
// Check input errors before inserting in database
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // Prepare an update statement
        $client_name = $_POST["client_name"];
        $address = $_POST['address'];
        $phone_no = $_POST['phone_no'];
        $sql = "UPDATE clients as c SET c.client_name = ?, c.address = ? , c.phone_no = ? WHERE client_id= ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $client_name, $address, $phone_no,$client_id);
            // Set parameters
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: client.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
    }  
    // Close statement
    //mysqli_stmt_close($stmt);
// Close connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Client Record</title>
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
                    <h2 class="mt-5">Update Client Record</h2>
                    <p>Please edit the input values and submit to update the client record.</p>
                    <?php 
                    $client_id = $_GET["client_id"];
                    $sql = "SELECT client_id,client_name,address,phone_no from clients where client_id = $client_id;";
                    $values = mysqli_query($link,$sql);
                    $row1 = mysqli_fetch_array($values, MYSQLI_ASSOC)
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Client Name</label>
                            <input type="text" name="client_name" class="form-control"
                                value="<?php echo $row1['client_name']?>">
                        </div>
                        <div class="form-group">
                            <label>Client Address</label>
                            <input type="text" name="address" class="form-control"
                                value="<?php echo $row1['address']?>">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Phone Number (eg: 03....)</label>
                            <input type="text" name="phone_no" class="form-control"
                                value="<?php echo $row1["phone_no"]?>">
                            <span class="invalid-feedback">
                            </span>
                        </div>
                        <label>Client ID</label>
                        <input type = "text" name = "client_id" class = "form-control" value = "<?php echo $client_id ?>" disabled>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="client.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>