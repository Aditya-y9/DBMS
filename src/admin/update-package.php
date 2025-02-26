<?php
// Connect to the database
define('DB_HOST', 'MSHOME:3304');
define('DB_USER', 'username');
define('DB_PASS', 'password');
define('DB_NAME', 'dbms');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the package_id is provided in the URL
$package_id = isset($_GET['pid']) ? $_GET['pid'] : null;

// Fetch the existing package details
$sql = "SELECT PackageName, PackageType, PackageLocation, PackagePrice, PackageFetures FROM tbltourpackages WHERE PackageId = '$package_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $package_name = $row["PackageName"];
    $package_type = $row["PackageType"];
    $package_location = $row["PackageLocation"];
    $package_price = $row["PackagePrice"];
    $package_features = $row["PackageFetures"];
} else {
    $package_name = "";
    $package_type = "";
    $package_location = "";
    $package_price = "";
    $package_features = "";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Get the input from the form
        $package_name = $_POST["package_name"];
        $package_type = $_POST["package_type"];
        $package_location = $_POST["package_location"];
        $package_price = $_POST["package_price"];
        $package_features = $_POST["package_features"];

        // Update the tbltourpackages table
        $sql = "UPDATE tbltourpackages SET PackageName = '$package_name', PackageType = '$package_type', PackageLocation = '$package_location', PackagePrice = '$package_price', PackageFetures = '$package_features' WHERE PackageId = '$package_id'";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Package updated successfully"); window.location.href = "manage-packages.php";</script>';
        } else {
            echo '<script>alert("Error updating package: ' . $conn->error . '");</script>';
        }
    } elseif (isset($_POST['delete'])) {
        // Delete the package
        $sql_delete = "DELETE FROM tbltourpackages WHERE PackageId = '$package_id'";
        if ($conn->query($sql_delete) === TRUE) {
            echo '<script>alert("Package deleted successfully"); window.location.href = "manage-packages.php";</script>';
            // Redirect to a page after deletion if needed
        } else {
            echo '<script>alert("Error deleting package: ' . $conn->error . '");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Tour Package</title>
    <!-- Add the CSS files used in other admin pages -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body style="margin-left : 270px;">
<img src="https://www.kstdc.co/wp-content/themes/kstdc/images/inbg.jpg" alt="" style="width: 1000px" height="150px">
    <div class="grid-form">
        <div class="grid-form1">
            <h3>Update Package</h3>
            <button>
                <a href="manage-packages.php">Back</a>
            </button>
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                    <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?pid=" . $package_id);?>">
                        <div class="form-group">
                            <label for="package_name" class="col-sm-2 control-label">Package Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="package_name" value="<?php echo $package_name; ?>" required>
                            </div>
                        </div>
                        <div>
                            <label for="package_type" class="col-sm-2 control-label">Package Type</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="package_type" value="<?php echo $package_type; ?>" required>
                            </div>
                        </div>
                        <div>
                            <label for="package_location" class="col-sm-2 control-label">Package Location</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="package_location" value="<?php echo $package_location; ?>" required>
                            </div>
                        </div>
                        <div>
                            <label for="package_price" class="col-sm-2 control-label">Package Price</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="package_price" value="<?php echo $package_price; ?>" required>
                            </div>
                        </div>
                        <div>
                            <label for="package_features" class="col-sm-2 control-label">Package Features</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="package_features" value="<?php echo $package_features; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" name="submit" value="Update Package" class="btn btn-primary">
                            </div>
                        </div>
                        <!-- delete package -->
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" name="delete" value="Delete Package" class="btn btn-danger">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!--/sidebar-menu-->
    <?php include('includes/sidebarmenu.php');?>
    <div class="clearfix"></div>
    </div>
    <script>
        var toggle = true;

        $(".sidebar-icon").click(function() {
            if (toggle) {
                $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                $("#menu span").css({"position":"absolute"});
            } else {
                $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                setTimeout(function() {
                    $("#menu span").css({"position":"relative"});
                }, 400);
            }

            toggle = !toggle;
        });
    </script>
    <!--js -->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- /Bootstrap Core JavaScript -->
</body>
</html>