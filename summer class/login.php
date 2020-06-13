<?php 
session_start();
?>
<!doctype html>
<html lang="en">
<link rel="stylesheet" href="cscript.css">
<?php include('common.php'); ?>
<head>
<meta charset="utf-8">
</head>

<body bgcolor="orange">
<div class="header">
   <a href='ccc.php'><img id='logo' src='CCC_2019.PNG' height='70px' align='left' style='padding-top:5px;padding-left:40px;'></a>
   <div class="h">   
      <h1><b>Login to go to the login portal!</b></h1>
   </div>
</div>

<?php

   //Check to see if form has been posted
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $problem = false;
      if (isset($_POST['login'])) {
	    $org = $_POST['logorg'];
	    $email = $_POST['logemail'];
	    $password = $_POST['logpass'];

	    $query = "select * from org_users where Org ='".$org."' and Email ='".$email."' and Password ='".$password."' and Status = '1' and Admin = '1'";
	    $result = mysqli_query($dbc, $query);

	    if (mysqli_num_rows($result) > 0) {
	       $_SESSION["org"] = $org;
	       $_SESSION["email"] = $email;
	       $_SESSION["login"] = "true";
	       $_SESSION["admin"] = "1";
	       header("Location: ccc.php");
	       exit;
	    } else {			
	       $query = "select * from org_users where Org ='".$org."' and Email ='".$email."' and Password ='".$password."' and Status = '1'";
	       $result = mysqli_query($dbc, $query);
	       if (mysqli_num_rows($result) > 0) {
	          $_SESSION["org"] = $org;
		  $_SESSION["email"] = $email;
		  $_SESSION["login"] = "true";
		  $_SESSION["admin"] = "0";
		  header("Location: ccc.php");
		  exit;
	       }
	    }
	    echo "You need to register or be approved!";
      }
   }
?>

<div class="login">
<center>
<form action="login.php" method="post" class="form--inline">
	<table>
	
	<tr>
	<td align="center" valign="top" style='padding-right:50px'><p><label for="logorg"><h3>Organization:</h3></label></td>
	<td align="center" valign="bottom"><select name="logorg" required>
	<option value=""></option>
	<?php
        $query= "SELECT * from orgs"; 
        $result = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_assoc($result)){
	   echo "<option value=".$row["Org"]." name='logorg'>".$row["Org"]."</option>";
	}
        ?>
        </select></p></td>
	</tr>
	</table>

	<p><label for="logemail"><h3>Email Address:</h3></label></p>
	<p><input type="email" name="logemail" size="20" value="<?php if(isset($_POST['logemail'])) { print htmlspecialchars($_POST['logemail']); } ?>" required></p>
	
	<p><label for="logpass"><h3>Password:</h3></label></p>
	<p><input type="password" name="logpass" size="20" value="" required></p>

	<p><input type="submit" name="login" value="Login!" class="button"></p>
</form>
</center>
</div>
</body>
</html>
