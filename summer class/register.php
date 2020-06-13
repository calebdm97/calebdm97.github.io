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

<?php

   //Check to see if form has been posted
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $problem = false;

      //which form was submitted
      if (isset($_POST['register'])) {
         //see if all fields were entered
         if ($_POST['pass1'] != $_POST['pass2']) {
	    $problem = true;
	    print '<p class="text--error">Your password do not match!</p>';
	 }
	 //If there is no problem
	 if (!$problem) {
	    //set form variables
	    $org = $_POST['org'];
	    $first_name = $_POST['first_name'];
	    $last_name = $_POST['last_name'];
	    $num = $_POST['num'];
	    $carrier = $_POST['carrier'];
	    $email = $_POST['email'];
	    $pass = $_POST['pass1'];
	    $major = $_POST['major'];
	    $name = $first_name.' '.$last_name;

	    //Check dbc connection
	    if (!$dbc) {
	       die("Connection failed: " .mysqli_connect_error());
	    }

	    //see if email is already registered to the organization
	    $query = "SELECT * FROM org_users WHERE Org ='".$org."' AND Email ='".$email."'";
	    $result = mysqli_query($dbc, $query);
	
	    //let user know that they are already in organization
	    if (mysqli_num_rows($result) > 0) {

	       print '<p class="text--error">You have already registered with this email!</p>';
	       while($row = mysqli_fetch_assoc($result)) {
                  echo "Organization: " . $row["Org"]. " - Email: " . $row["Email"]. "<br>";
	       }
	    //add user to database
	    } else {
	    $sql = "INSERT INTO org_users (Org, First_Name, Last_Name, Phone_Number, Carrier, Email, Password, Major, Status, Admin) VALUES ('".$org."','".$first_name."','".$last_name."','".$num."','".$carrier."','".$email."','".$pass."','".$major."','0', '0')";                                
	    if (mysqli_query($dbc, $sql)) {
               $to = "millardepley@rocketmail.com";
	       $subject = "Registration Approval";
               $body = "{$name} has submitted to register to {$org} with the following email {$email}.";
               send_email($to, $subject, $body);
            } else {
               echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
            }                   
	 
	    $_POST = [];
	    }
         }
      } 
   }
?>
<div class="register">
<center>
<h2>Registration Form!</h2>
<form action="register.php" method="post" class="form--inline">
	<table>
	<tr>
	<th align="center"><label for="org"><h3>Organization</h3></label></th>
	<th align="center"><label for="major"><h3>Major</h3></label></th>
	<th align="center"><label for="carrier"><h3>Phone Carrier</h3></label></th>
	</tr>
	
	<tr>
	<td align="center" valign="top"><select name="org" required style='padding-right:42px'>
	<option value=""></option>
        <?php
        $query= "SELECT * from orgs"; 
        $result = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_assoc($result)){
	   echo "<option value=".$row["Org"]." name='org' >".$row["Org"]."</option>";
	}
        ?>
        </select></td>
 
	<td align="center" valign="top"><select name="major" required style='padding-right:42px'>
	<option value=""></option>
	<?php
        $query= "SELECT * from majors"; 
        $result = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_assoc($result)){
	   echo "<option value".$row["Major"]." name='major'>".$row["Major"]."</option>";
	}
        ?>
        </select></td>
	
	<td align="center" valign="top"><select name="carrier" required style='padding-right:42px'>
	<option value=""></option>
	<?php
        $query= "SELECT * from phone_carriers"; 
        $result = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_assoc($result)){
	   echo "<option value=".$row["Name"]." name='carrier'>".$row["Name"]."</option>";
	}
        ?>
        </select></td>
	</tr>
	</table>

	<p><label for="first_name"><h3>First Name:</h3></label></p>
	<p><input type="text" name="first_name" size="20" value="<?php if(isset($_POST['first_name'])) { print htmlspecialchars($_POST['first_name']); } ?>" required></p>

	<p><label for="last_name"><h3>Last Name:</h3></label></p>
	<p><input type="text" name="last_name" size="20" value="<?php if(isset($_POST['last_name'])) { print htmlspecialchars($_POST['last_name']); } ?>" required></p>

	<p><label for="num"><h3>Phone Number:</h3></label></p>
	<p><input type="text" name="num" size="20" value="<?php if(isset($_POST['num'])) { print htmlspecialchars($_POST['num']); } ?>" required></p>

	<p><label for="email"><h3>Email Address:</h3></label></p>
	<p><input type="email" name="email" size="20" value="<?php if(isset($_POST['email'])) { print htmlspecialchars($_POST['email']); } ?>" required></p>

	<p><label for="pass1"><h3>Password:</h3></label></p>
	<p><input type="password" name="pass1" size="20" value="" required></p>

	<p><label for="pass2"><h3>Confirm Password:</h3></label</p>
	<p><input type="password" name="pass2" size="20" value="" required></p>

	<p><input type="submit" name="register" value="Register!" class="button"></p>
</form>
</center>
</div>
</body>
</html>
