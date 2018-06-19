<?php
include_once 'DBConnector.php';
include_once 'user.php';
$con = new DBConnector;

if (isset($_POST['btn-save'])){
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$city = $_POST['cityName'];	
	
	$user = new User($firstName, $lastName, $city, $username, $password);

//	checking whether the user has input data in all fields
    if(!$user->validateForm()){
        $user->createFormErrorSessions();
        header("Refresh:0");
        die();
    }else if (!$user->isUserExists()){
        echo "Username exists!!!";
    }else {
//    calls the save function once button is clicked
        $res = $user->save();

//    Save notification progress notification
        if($res){
            echo "Save operation successful";
        }else{
            echo "Save unsuccessful";
        }
        $con->closeDatabase();
    }
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			Internet Programming Lab
		</title>
		<script type="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">
	</head>
	<body>
		<form method="POST" name="user_details"	id="user_details 
		"onsubmit="return validateForm()"
		action="register.php">
			<table align="centre">
                <tr>
                    <div id="form-errors">
                    <?php
                        session_start();
                        if(!empty($_SESSION['form_errors'])){
                            echo " ".$_SESSION['form_errors'];
                            unset($_SESSION['form_errors']);
                        }
                    ?>
                    </div>
                </tr>
				<tr>
					<td><input type="text" name="firstName" id="firstName" required placeholder="First Name" /></td>
				</tr>
				<tr>
					<td><input type="text" name="lastName" id="lastName" placeholder="Last Name" /></td>
				</tr>
				<tr>
					<td><input type="text" name="cityName" id="cityName" placeholder="City" /></td>
				</tr>
                <tr>
                    <td><input type="text" name="username" id="username" placeholder="Username" /></td>
                </tr>
                <tr>
                    <td><input type="password" name="password" id="password" placeholder="Password" /></td>
                </tr>
				<tr>
					<td><input type="submit" name="btn-save" value="Save"/></td>
				</tr>
                <tr>
                    <td><a href="login.php">Login</a></td>
                </tr>
			</table>
		</form>
	</body
</html>