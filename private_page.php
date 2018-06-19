<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/5/2018
 * Time: 11:17 PM
 */
session_start();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}
?>

<html>
<head>
    <title>Private page</title>
    <script type="text/javascript" src="validate.js"></script>
    <link rel="stylesheet" type="text/css" href="validate.css">
</head>
<body>
    <p>This is a private page</p>
    <p> We want to protect it</p>
    <p><a href="logout.php"></a></p>
</body>
</html>
