<?php require_once 'controllers/authController.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>TEAM IBM Home</title>
	<!--BS 4 CSS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-4 offset-md-4 form-div login">
				<?php if(isset($_SESSION['message'])): ?>
				<div class="alert <?php echo $_SESSION['alert-class']; ?>">
					<?php
						echo $_SESSION['message'];
						unset($_SESSION['message']);
						unset($_SESSION['alert-class']);
						?>
				</div>
			<?php endif; ?>

				<h3>Welcome, <?php echo $_SESSION['username']; ?> </h3>
				<a href="signup.php" class="logout">logout</a>

				<!-- <div class="alert alert-warning">
					You need to verify your account 
				</div> -->
				
				
			</div>
		</div>
	</div>
</body>
</html>