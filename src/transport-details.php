<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['submit2']))
{
$pid=intval($_GET['id']);
$useremail=$_SESSION['login'];
$fromdate=$_POST['fromdate'];
$todate=$_POST['todate'];
$comment=$_POST['comment'];
$status=0;
$sql="INSERT INTO tblbooking(PackageId,UserEmail,FromDate,ToDate,Comment,status) VALUES(:pid,:useremail,:fromdate,:todate,:comment,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query->bindParam(':todate',$todate,PDO::PARAM_STR);
$query->bindParam(':comment',$comment,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Booked Successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Transport Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
		 new WOW().init();
	</script>
<script src="js/jquery-ui.js"></script>
					<script>
						$(function() {
						$( "#datepicker,#datepicker1" ).datepicker();
						});
					</script>
	  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>				
</head>
<body>
<!-- top-header -->
<?php include('includes/header.php');?>
<div class="banner-3">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> TMS -Package Details</h1>
	</div>
</div>
<!--- /banner ---->
<!--- selectroom ---->
<div class="selectroom">
	<div class="container">	
		  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
<?php 
$pid=$_GET['id'];
$sql = "SELECT * from transport_type where Transport_id=:pid";
$query = $dbh->prepare($sql);
$query -> bindParam(':pid', $pid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

<form name="book" method="post">
		<div class="selectroom_top">
			<div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
            <img class="img-responsive" src="images/transport/<?php echo htmlentities($result->Transport_Image) . '.jpg';?>" style="width: 250px; height: 200px;">
			</div>
			<div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
				<h2><?php echo htmlentities($result->NameOfProvider);?></h2>
				<p class="dow">#PKG-<?php echo htmlentities($result->Transport_id);?></p>
				<p><b>Vehicle Type :</b> <?php echo htmlentities($result->TypeOfVehicle);?></p>
				<p><b>Fare per Person :</b> <?php echo htmlentities($result->Fare);?></p>
					<div class="ban-bottom">
						<script>
							$(document).ready(function(){
								$(".dropdown").hover(            
									function() {
										$('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideDown("400");
										$(this).toggleClass('open');        
									},
									function() {
										$('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideUp("400");
										$(this).toggleClass('open');       
									}
								);
							});

							function validateDate() {
								var fromDate = document.getElementById("datepicker").value;
								var toDate = document.getElementById("datepicker1").value;
								if(fromDate > toDate) {
									alert("To date should be greater than From date");
									document.getElementById("datepicker1").value = "";
								}
							}
							
						</script>

						<style>
							.bnr-right {
								width: 50%;
								float: left;
							}
							.date {
								width: 100%;
								padding: 10px;
								margin: 10px 0;
								border: 1px solid #ccc;
								border-radius: 5px;
							}

							#datepicker, #datepicker1 {
								width: 100%;
								padding: 10px;
								margin: 10px 0;
								border: 1px solid #ccc;
								border-radius: 5px;
							}

							.grand {
								background: #f5f5f5;
								padding: 10px;
								margin: 10px 0;
								border: 1px solid #ccc;
								border-radius: 5px;
							}

							.grand h3 {
								color: #000;
								font-size: 24px;
								font-weight: 600;
							}

							.grand p {
								color: #000;
								font-size: 18px;
								font-weight: 400;
							}

							.inputLabel {
								font-size: 18px;
								font-weight: 400;
								color: #000;
							}

							.special {
								width: 100%;
								padding: 10px;
								margin: 10px 0;
								border: 1px solid #ccc;
								border-radius: 5px;
							}

							.sigi {
								width: 100%;
								padding: 10px;
								margin: 10px 0;
								border: 1px solid #ccc;
								border-radius: 5px;
							}

							.btn-primary {
								background: #337ab7;
								color: #fff;
								padding: 10px 20px;
								border: none;
								border-radius: 5px;
								font-size: 18px;
								font-weight: 600;
							}

							.btn-primary:hover {
								background: #286090;
							}

							.view {
								background: #337ab7;
								color: #fff;
								padding: 10px 20px;
								border: none;
								border-radius: 5px;
								font-size: 18px;
								font-weight: 600;
								text-decoration: none;
							}

							.view:hover {
								background: #286090;
							}
						</style>
				<div class="bnr-right">
					<label class="inputLabel">From</label>
					<input class="date" id="datepicker" type="text" placeholder="dd-mm-yyyy" name="fromdate" required="">
				</div>
				<div class="bnr-right">
					<label class="inputLabel">To</label>
					<input class="date" id="datepicker1" type="text" placeholder="dd-mm-yyyy" name="todate" required="" onchange="validateDate()">
				</div>
			</div>
						<div class="clearfix"></div>
				<div class="grand">
					<p>Grand Total</p>
					<h3>₹<?php echo htmlentities($result->Fare);?></h3>
				</div>
			</div>
		<h3>Vehicle Details</h3>
				<p style="padding-top: 1%"><?php echo htmlentities($result->TypeOfVehicle);?> </p>	
				<div class="clearfix"></div>
		</div>
		<div class="selectroom_top">
			<h2>Travels</h2>
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
				<ul>
					<div class="clearfix"></div>
				</ul>
			</div>
			
		</div>
		</form>
<?php }} ?>


	</div>
</div>
<!--- /selectroom ---->
<<!--- /footer-top ---->
<?php include('includes/footer.php');?>
<!-- signup -->
<?php include('includes/signup.php');?>			
<!-- //signu -->
<!-- signin -->
<?php include('includes/signin.php');?>			
<!-- //signin -->
<!-- write us -->
<?php include('includes/write-us.php');?>
</body>
</html>