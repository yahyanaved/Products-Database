<<?php
require_once "config.php";
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['someAction']))
{
    $sql = "COMMIT";
    if($stmt = mysqli_prepare($link, $sql))
    {
        if(mysqli_stmt_execute($stmt))
        {
            header("location: order.php");
            exit();
        } 
        else
        {
            header("location: error.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Summary</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 800px;
            margin: 0 auto;
            overflow-y: scroll;
        }

        #dashboard {
            padding-left: 80px;
            padding-top: 50px;
        }

        table tr td:last-child {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Order Summary</h2>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    $nonce = file_get_contents("nonce.txt");
                    $sql = "SELECT * from orders o inner join clients c on o.client_id = c.client_id
                    inner join products p on p.products_id = o.product_id where o.nonce = '$nonce'";
                    //$stmt = mysqli_prepare($link, $sql);
                    //mysqli_stmt_bind_param($stmt, "s", $nonce);
                    //$result = mysqli_stmt_execute($stmt);
                    $result = mysqli_query($link, $sql);
                    echo '<table class="table table-bordered table-striped">
                        ';
                    echo "
                        <thead>
                            ";
                    echo "
                            <tr>
                                ";
                    echo "
                                <th>Product Name</th>";
                    echo "
                                <th>Product Description</th>";
                    echo "
                                <th>Client Name</th>";
                    echo "
                                <th>Address</th>";
                    echo "
                                <th>Phone No.</th>";
                    echo "
                                <th>Amount</th>";
                    echo "
                                <th>Quantity</th>";
                    echo "
                            </tr>";
                    echo "
                        </thead>";
                    echo "
                        <tbody>
                            ";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "
                            <tr>
                                ";
                        echo "
                                <td>" . $row['p_name'] . "</td>";
                        echo "
                                <td>" . $row['p_desc'] . "</td>";
                        echo "
                                <td>" . $row['client_name'] . "</td>";
                        echo "
                                <td>" . $row['address'] . "</td>";
                        echo "
                                <td>" . $row['phone_no'] . "</td>";
                        echo "
                                <td>" . $row['amount'] . "</td>";
                        echo "
                                <td>" . $row['quantity'] . "</td>";
                
                        echo "
                                </td>";
                        echo "
                            </tr>";
                    }
                    echo "
                        </tbody>";
                    echo "
                    </table>";
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert">
                            <p>Are you sure you want to place order(s)?</p>
                            <p>
                                <input type="submit" value="Yes" name="someAction" class="btn btn-danger">
                                <a href="rollback.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>