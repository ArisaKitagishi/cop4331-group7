<!DOCTYPE html>
<!-- COP 4331 Group 7 -->
<!-- John Balbuza, Fernando Bilbao, Arisa Kitagishi, Imahd Khan, Susan Long,
Sarah Thompson, Jonathan White -->
<html>
<head>
	<!-- External Libraries -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="js/code.js"></script>

	<style>

		.btn-format {
			margin-top: 10px;
		}

		.nav-btn-format {
			margin-right: 10px;
		}
	</style>
</head>
<body>

<nav class="navbar navbar-default" id="RegisterBar>
	<div class="navbar-header>
		<a class="navbar-brand" href="/">Contact Manager</a>
	</div>
	<br />
	<a href="index.php">Log in</a>
</nav>

<!-- Form to sign up a new user. All fields must be filled out -->
<div id="accessUIDiv">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<div class="well">
				<h3>Register User</h3>
				<label for="nameSignUpForm">Name:</label>
				<form class="form-inline" id="nameSignUpForm">
					<div class="form-group">
						<label class="sr-only" for="signUpFirstName">First:</label>
						<input type="text" class="form-control" placeholder="First name" id="signUpFirstName" required>
					</div>
					<div class="form-group">
						<label class="sr-only" for="signUpLastName">Last:</label>
						<input type="text" class="form-control" placeholder="Last name" id="signUpLastName" required>
					</div>
				</form>
				<div class="form-group">
					<label for="usr">Username:</label>
					<input type="text" class="form-control" id="usr" required>
				</div>
				<div class="form-group">
					<label for="pass">Password:</label>
					<input type="password" class="form-control" id="pass" required>
					<button type="submit" id="registerUserButton" class="btn btn-format" onclick="registerUser();"> Register </button><br />
					<span id="registerUser"> </span>
				</div>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>
</div>

</body>
</html>
