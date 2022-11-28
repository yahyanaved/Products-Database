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
    <h1 id='dashboard' class="text-inverse-secondary bg-secondary">User Dashboard</h1>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Products</h2>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    $sql = "SELECT products_id,p_name, p_desc, c_name, sc_name, b_name, price,stock 
                    from products p 
                    inner join brands b on b.brand_id = p.brand_id 
                    left join subcategories s on s.sc_id = p.sc_id
                    left join categories c on c.category_id = p.category_id OR s.category_id = c.category_id";
                    $result = mysqli_query($link, $sql);
                    // Attempt select query execution
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
                                <th>Category Name</th>";
                    echo "
                                <th>Sub Category Name</th>";
                    echo "
                                <th>Brand Name </th>";
                    echo "
                                <th>Price</th>";
                    echo "
                                <th>Stock</th>";
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
                                <td>" . $row['c_name'] . "</td>";
                        echo "
                                <td>" . $row['sc_name'] . "</td>";
                        echo "
                                <td>" . $row['b_name'] . "</td>";
                        echo "
                                <td>" . $row['price'] . "</td>";
                        echo "
                                <td>" . $row['stock'] . "</td>";
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