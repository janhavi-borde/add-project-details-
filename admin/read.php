<?php
$id=$_GET['id'];
if(!isset($_GET['id']))
{
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">View Data</h2>
                       
                    </div>
                    <?php
                    // Include config file
                    require_once "../config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM students WHERE id='$id'";
                    if($result = mysqli_query($db, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                            ?>
                            <table class='table table-bordered table-striped'>
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td><?php echo $row['id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td><?php echo $row['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Member 1 Name</th>
                                        <td><?php echo $row['m1name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Member 2 Name</th>
                                        <td><?php echo $row['m2name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Member 3 Name</th>
                                        <td><?php echo $row['m3name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td><?php echo $row['description']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo $row['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone No</th>
                                        <td><?php echo $row['phoneno']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Domain</th>
                                        <td><?php echo $row['domain']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Roll No</th>
                                        <td><?php echo $row['rollno']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Attached File</th>
                                        <td><a href="../files/<?php echo $row['file']; ?>" class="btn btn-primary">Download Atachment</a></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                            }
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
                    }
 
                    // Close connection
                    mysqli_close($db);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>