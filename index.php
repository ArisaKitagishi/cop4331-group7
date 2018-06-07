<?php
  session_start();
?>

<!DOCTYPE html>
<!-- COP 4331 Group 7 -->
<!-- John Balbuza, Fernando Bilbao, Arisa Kitagishi, Imahd Khan, Susan Long,
Sarah Thompson, Jonathan White -->
<html>
<head>
	<!-- External Libraries -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/Inputmask-4.x/css/inputmask.css" rel="stylesheet">
	<script type="text/javascript" src="js/code.js"></script>

	<style>
    .btn-format {
      margin-top: 10px;
    }

    .signup-tooltip {
      margin-top: 10px;
    }

    li {
      display: inline;
    }

	</style>
</head>
<body>
<header>
<!-- Navigation bar -->
<nav class="navbar navbar-default" id="loggedInNavBar">
  	<div class="navbar-header">
  		<a class="navbar-brand" href="#">Contact Manager</a>
  	</div>
  	<ul class="nav navbar-nav pull-right">	
		<!-- Get session variables (these will be used in the javascript) -->
		<?php if (isset($_SESSION['u_id']))
		{?>
			<script type="text/javascript">
				var userId = '<?php echo $_SESSION['u_id'];?>';
				var firstName = '<?php echo $_SESSION['u_first'];?>';
				var lastName = '<?php echo $_SESSION['u_last'];?>';
			</script>
			<span id="loggedInDiv">
    		<li>Logged in as
        <?php echo $_SESSION['u_last'];?> <?php echo $_SESSION['u_first'];?>
        </li>
    	<li>
    		<span>
    			<button type="button" id="logoutButton" class="btn navbar-btn nav-btn-format" onclick="doLogout();"> Log Out </button>
    		</span>
    	</li>
       </span>
			 <?php
		} ?>
  	</ul>
  </nav>
</header>

<!-- Login page (only displayed if the user is not logged in -->
<?php if (!isset($_SESSION['u_id']))
{?>
<div class="container-fluid" id="loginDiv">
	<h1 class="text-center">Contact Manager</h1>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<div class="well">
				<div class="form-group" id="loginForm">
					<label for="usr">Username:</label>
					<input type="text" class="form-control" id="usr"></input>
					<label for="pass">Password:</label>
					<input type="password" class="form-control" id="pass"></input>
					<button type="button" class="btn btn-format" id="loginButton" onclick="doLogin();" >Submit</button>
          <span id="loginResult"> </span>
					<div class="signup-tooltip">New user? <a href="signUp.php">Sign up here</a>.</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>
</div>
<?php
} ?>

<!-- UI for when the user is logged in -->
<?php if (isset($_SESSION['u_id']))
{?>
<div id="accessUIDiv">
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<div class="well">
				<!-- Displays user's contacts. This section also contains
				search and delete -->
				<h2>Your Contacts</h2>
				<input type="text" class="form-control" placeholder="Enter your search" id="contactSearch">
				<button type="button" id="seachContactButton" class="btn btn-format" onclick="searchContacts(0);"> Search </button>
				<span id="contactSearchResult"></span>
				<div class="table-responsive">
					<table class="table" id="contactTable" style="display:none; visibility:hidden;" data-last-search="">
						<thead>
							<tr>
								<th name="firstName">First</th>
								<th name="lastName">Last</th>
								<th name="workPhone">Work Phone</th>
								<th name="homePhone">Home Phone</th>
								<th name="mobilePhone">Mobile</th>
								<th name="address1">Address 1</th>
								<th name="address2">Address 2</th>
								<th name="zip">ZIP</th>
								<th name="email">Email</th>
								<th>Delete?</th>
							</tr>
						</thead>
					</table>
				</div>
				<button type="button" id="deleteContactButton" class="btn btn-format" onclick="deleteContact(&quot;contactTable&quot;);" style="display:none; visibility:hidden;"> Delete </button><span id="contactDeleteResult"></span>
				<hr>
				
				<!-- Form for adding a contact. First and last name fields are
				 required -->
				<h2>Add Contact</h2>
				<label for="nameForm">Name:</label>
				<form class="form-inline" id="nameForm">
					<div class="form-group">
						<label class="sr-only" for="addFirstName">First:</label>
						<input type="text" class="form-control" placeholder="First name" id="addFirstName">
					</div>
					<div class="form-group">
						<label class="sr-only" for="addLastName">Last:</label>
						<input type="text" class="form-control" placeholder="Last name" id="addLastName">
					</div>
				</form>
				<form id="contactForm">
					<div class="form-group">
						<label for="workPhone">Work Phone:</label>
						<input type="tel" data-inputmask="'alias': 'phone'" data-inputmask-removemaskonsubmit="true" class="form-control" id="workPhone" />
					</div>
					<div class="form-group">
						<label for="homePhone">Home Phone:</label>
						<input type="tel" data-inputmask="'alias': 'phone'" class="form-control" id="homePhone">
					</div>
					<div class="form-group">
						<label for="mobile">Mobile:</label>
						<input type="tel" data-inputmask="'alias': 'phone'" class="form-control" id="mobile">
					</div>
					<div class="form-group">
						<label for="address1">Address 1:</label>
						<input type="text" class="form-control" placeholder="i.e. 1234 Imaginary Ave" id="address1">
					</div>
					<div class="form-group">
						<label for="address2">Address 2:</label>
						<input type="text" class="form-control" placeholder="i.e. 1234 Imaginary Ave" id="address2">
					</div>
					<div class="form-group">
						<label for="zip">ZIP:</label>
						<input type="text" class="form-control" placeholder="5 characters (i.e. 98765)" id="zip">
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" placeholder="Email" id="email"> <br />
					</div>
					<button type="submit" id="addContactButton" class="btn btn-format" onclick="addContact();"> Add </button>
					<span id="contactAddResult"></span>
				</form>
			</div>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
<?php
} ?>

	<script src="js/jquery-1.12.4.min.js"></script>
	<script src="css/Inputmask-4.x/dist/jquery.inputmask.bundle.js"></script>
	<script src="css/Inputmask-4.x/dist/inputmask/phone-codes/phone.js"></script>
	<script language="javascript">
		$(document).ready(function(){
			$(":input").inputmask();
			$("#phone").inputmask({"removeMaskOnSubmit" : true});
			// Display all user's contacts on page load
			searchContacts(-1);
		});
	</script>

</body>
</html>
