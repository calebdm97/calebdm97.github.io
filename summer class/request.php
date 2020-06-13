<?php 
session_start();
?>
<!doctype html>
<html>
<link rel="stylesheet" href="cscript.css">
<?php include('common.php'); ?>
<body bgcolor="orange">
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   //$org = $_POST['org'];
     $org='Binary_Elite';
   //$_SESSION["org"] = $org; 
  
   //sign up was submitted
   if ($_POST['response'] == "SIGNUP") {
      //show options at the top
      echo "
      <div class = 'signup'>
      <div class ='formarea'>
      <form action='request.php' method='post' class='form--inline'>
      <table>
        <tr>
         <th align='block'><input type='submit' style='width:200px;margin:0; height:50px' name='response'   value='SIGNUP' required></th>
	 </tr>
	 <tr>
         <th align='block'><input type='submit' style='width:200px;margin:0; height:50px' name='response' value='EXPLORE'></th> 
 	 </tr>   
	 <tr>     
	 <th align='block'><input type='submit' style='width:200px;margin:0; height:50px' name='response' value='CONTACT LIST'></th>
         </tr>
      </table>
      </form>
      </div>
      <br>
      <br>
      ";

      echo "
      <div class='rightside'>
      <center>
      <form action='request.php' method='post' class='form--inline'>
         <p><label for='first_name'><h3>First Name:</h3></label></p>
	 <p><input type='text' name='first_name' size='20' value='"; if(isset($_POST['first_name'])) { print htmlspecialchars($_POST['first_name']); } echo "' required></p>

	 <p><label for='last_name'><h3>Last Name:</h3></label></p>
	 <p><input type='text' name='last_name' size='20' value='"; if(isset($_POST['last_name'])) { print htmlspecialchars($_POST['last_name']); } echo "' required></p>

         <p><label for='email'><h3>Email Address:</h3></label></p>
	 <p><input type='email' name='email' size='20' value='"; if(isset($_POST['email'])) { print htmlspecialchars($_POST['email']); } echo "' required></p>

         <p><input type='submit' name='sign' value='Sign Up!' class='button'></p>
         <input type='hidden' name='response' value='false'>
      </form>
      </center>
      </div>
      </div>
      ";
     //submitted sign-up form
   } else if (isset($_POST['sign'])) {
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $email = $_POST['email'];
      $name = $first_name.' '.$last_name;
     
      //see if email is already registered to the organization
      $query = "SELECT * FROM org_followers WHERE Org ='".$org."' AND Email ='".$email."'";
      $result = mysqli_query($dbc, $query);
	
      //let user know that they are already in organization
      if (mysqli_num_rows($result) > 0) {
         print '<p class="text--error">You have already signed up with this email!</p>';
         while($row = mysqli_fetch_assoc($result)) {
            echo "Organization: " . $row["Org"]. " - Email: " . $row["Email"]. "<br>";
	 }
      //add user to followers table
      } else {
         $sql = "INSERT INTO org_followers (Org, First_Name, Last_Name, Email, Status) VALUES ('".$org."','".$first_name."','".$last_name."','".$email."','1')";                                
	 if (mysqli_query($dbc, $sql)) {
            $to = "millardepley@rocketmail.com";
	    $subject = "Signed Up";
            $body = "{$name} you have sucessfully signed up to receive notifications from the {$org} organization from East Central University.";
            send_email($to, $subject, $body);
         } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
         }
      }
     //explore selected
   } else if ($_POST['response'] == "EXPLORE") {
      echo "
      <div class='formarea'>
      <form action='request.php' method='post' class='form--inline'>
      <table>
        <tr>
         <th align='block'><input type='submit' style='width:200px;margin:0; height:50px' name='response'   value='SIGNUP' required></th>
	 </tr>
	 <tr>
         <th align='block'><input type='submit' style='width:200px;margin:0; height:50px' name='response' value='EXPLORE'></th> 
 	 </tr>   
	 <tr>     
	 <th align='block'><input type='submit'style='width:200px;margin:0; height:50px' name='response' value='CONTACT LIST'></th>
         </tr>
      </table>
      </form>
      </div>
      <br>
      <br>
      
      ";

         //create query of users in selected organization
         $query = "SELECT * FROM org_users where Org = '".$org."'";
	 $result = mysqli_query($dbc, $query);
	
	 //build the table of users
	 if (mysqli_num_rows($result) > 0) {
            echo "
               <center>
               <form action='admin.php' method='post' class='form--inline'>
               <table width='75%' id='explore'>
	          <tr>
	          <th align='center'><label for='org'><b>Organization</b></label></th>
	          <th align='center'><label for='first_name'><b>First Name</b></label></th>
	          <th align='center'><label for='last_name'><b>Last Name</b></label></th>
                  <th align='center'><label for='email'><b>Email Address</b></label></th>
		  <th align='center'><label for='major'><b>Major</b></label></th>
	          </tr>
            ";
	    while($row = mysqli_fetch_assoc($result)) {
               echo "<tr>
                     <td align='center'><label>".$row["Org"]."</label></td>
                     <td align='center'><label>".$row["First_Name"]."</label></td>
                     <td align='center'><label>".$row["Last_Name"]."</label></td>
                     <td align='center'><label>".$row["Email"]."</label></td>
		     <td align='center'><label>".$row["Major"]."</label></td>
                     </tr>
               ";
               
	    }
            echo "
               </table>
	       </form>
               </center>
            ";
	 } else {
            echo "No Current Members";
         }	
      
   } else if ($_POST['response'] == "CONTACT LIST") {
      echo "
      <div class='formarea'>
      <form action='request.php' method='post' class='form--inline'>
      <table>
        <tr>
         <th align='block'><input type='submit' style='width:200px;margin:0; height:50px' name='response'   value='SIGNUP' required></th>
	 </tr>
	 <tr>
         <th align='block'><input type='submit' style='width:200px;margin:0; height:50px' name='response' value='EXPLORE'></th> 
 	 </tr>   
	 <tr>     
	 <th align='block'><input type='submit'style='width:200px;margin:0; height:50px' name='response' value='CONTACT LIST'></th>
         </tr>
      </table>
      </form>
      </div>
      <br>
      <br>
     
      ";

         //create query to pull organization contact for selected organization
         $query = "SELECT * FROM orgs where Org = '".$org."'";
	 $result = mysqli_query($dbc, $query);
	
	 //build the table of users
	 if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "
               <center>
               <form action='admin.php' method='post' class='form--inline'>
               <table width='75%' id='explore'>
	          <tr>
	          <th align='center'><label for='org'><b>Organization</b></label></th>
	          <th align='center'><label for='contact'><b>Administrator</b></label></th>
                  <th align='center'><label for='email'><b>Email Address</b></label></th>
	          </tr>

                  <tr>
                  <td align='center'><label>".$row["Org"]."</label></td>
                  <td align='center'><label>".$row["Contact"]."</label></td>
                  <td align='center'><label>".$row["Email"]."</label></td>
                  </tr>
               </table>
	       </form>
               
            ";
	 } else {
            echo "No Current Members";
         }	
   
   }
} else {
   //What you see when you first open page
   echo "
      <div class='formarea'>
      <form action='request.php' method='post' class='form--inline'>
      <table>
      </center>
        <tr>
         <th align='block'><input type='submit' style='width:200px;margin:0; height:50px' name='response'   value='SIGNUP' required></th>
	 </tr>
	 <tr>
         <th align='block'><input type='submit' style='width:200px;margin:0; height:50px' name='response' value='EXPLORE'></th> 
 	 </tr>   
	 <tr>     
	 <th align='block'><input type='submit'style='width:200px;margin:0; height:50px' name='response' value='CONTACT LIST'></th>
         </tr>
      </table>
      </form>
      </div>
      <center>
      <iframe width='1000' height='550' src='https://www.youtube.com/embed/vO8g1wXykhc' frameborder='0' style='padding-top:40px' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>

      </center>
   ";
}

?>

</body>
</html>
