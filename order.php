<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
    <h1 id='dashboard' class="text-inverse-secondary bg-secondary">Admin Dashboard</h1>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Categories</h2>
                        <a href="ordercreate.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Order</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    $sql = "SELECT * from orders o inner join clients c on o.client_id = c.client_id
                    inner join products p on p.products_id = o.product_id";
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
                                <td>
                                    ";
                        echo '<a href="orderdelete.php?order_id=' . $row['order_id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        
    </div>
</body>

</html>