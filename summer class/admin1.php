<?php 
session_start();
$org = $_SESSION["org"];
?>
<!doctype html>
<html lang="en">
<link rel="stylesheet" href="cscript.css">
<?php include('common.php'); ?>
<head>
<meta charset="utf-8">
</head>

<body>
<?php
      if(empty($_POST['update']) && empty($_POST['event']) && empty($_POST['notifications'])) {
         $_SESSION['response'] = $_GET['response'];
      }
      //update selected
      if ($_SESSION['response'] == "update") {
	 //create query of users needing to be approved
         $query = "SELECT * FROM org_users where Org = '".$org."'";
	 $result = mysqli_query($dbc, $query);
	
	 //build the table of users
	 if (mysqli_num_rows($result) > 0) {
            echo "
               <center>
               <br><br>
               <form action='admin.php' method='post' class='form--inline'>
               <table width='75%' id='update'>
	          <tr>
		  <th align='center'><label for='select'><b>Update</b></label</th>
		  <th align='center'><label for='activate'><b>Activate</b></label</th>
		  <th align='center'><label for='admin'><b>Admin</b></label</th>
		  <th align='center'><label for='id'><b>ID</b></label></th>
	          <th align='center'><label for='org'><b>Organization</b></label></th>
	          <th align='center'><label for='email'><b>Email Address</b></label></th>
	          <th align='center'><label for='status'><b>Status</b></label></th>
		  <th align='center'><label for='admin'><b>Admin</b></label></th>
	          </tr>
            ";
	    while($row = mysqli_fetch_assoc($result)) {
               if ($row['Status'] == '1') {
                  $status = "Active";
               } else {
                  $status = "Inactive";
               }
               if ($row['Admin'] == '1') {
                  $admin = "Active";
               } else {
                  $admin = "Inactive";
               }
               echo "<tr>
		     <td align='center'><input type='checkbox' name='updbox[]' value =".$row["ID"]."></td>
		     <td align='center'><input type='checkbox' name='actbox[]' value =".$row["Status"]."></td>
		     <td align='center'><input type='checkbox' name='admbox[]' value =".$row["Admin"]."></td>
		     <td align='center'><label>".$row["ID"]."</label></td>
                     <td align='center'><label>".$row["Org"]."</label></td>
                     <td align='center'><label>".$row["Email"]."</label></td>
                     <td align='center'><label>".$status."</label></td>
		     <td align='center'><label>".$admin."</label></td>
                     </tr>
               ";
               
	    }
            $_SESSION['response'] = 'false';
            echo "
	       
               </table>
               <br>
	       <input type='submit' name='update' value='UPDATE'>
               </form>
               </center>
            ";
	 } else {
            echo "No Current Members";
         }
      //events selected
      } else if ($_SESSION['response'] == "events") {
           $_SESSION['response'] = 'false';
         echo "
               <center>
               <form action='admin.php' method='post' class='form--inline'>
               <table width='30%'>
	          <tr>
	          <th align='center'><label for='public'><b>Public</b></label></th>
	          <th align='center'><label for='private'><b>Private</b></label></th>
		  <th align='center'><label for='social'><b>Social Media</b></label></th>
	          </tr>
                  <tr>
		     <td align='center'><input type='checkbox' name='public' value ='1'></td>
                     <td align='center'><input type='checkbox' name='private' value ='1'></td>
                     <td align='center'><input type='checkbox' name='social' value ='1'></td>
                  </tr>
               </table>

               <p><label for='event_name'>Event Name:</label></p>
	       <p><input type='text' name='event_name' size='20' value='' required></p>

               <p><label for='flier'>Flier Name:</label></p>
	       <p><input type='text' name='flier' size='20' value='' required></p>

	       <p><label for='event_message'>Event Message:</label></p>
	       <p><textarea name='event_message' cols='50' rows='10' style='text-align:left' required></textarea></p>

               <p><input type='submit' name='event' value='Create Event!' class='button'></p>
               <input type='hidden' name='update' value='false'>
               </form>
               </center>
         ";
      //notifications selected
      } else if ($_SESSION['response'] == "notifications") {
         $_SESSION['response'] = 'false';
         echo "
               <center>
               <form action='admin.php' method='post' class='form--inline'>
               <table width='30%'>
	          <tr>
	          <th align='center'><label for='public'><b>Public</b></label></th>
	          <th align='center'><label for='private'><b>Private</b></label></th>
		  <th align='center'><label for='email'><b>Email</b></label></th>
	          </tr>
                  <tr>
		     <td align='center'><input type='checkbox' name='public' value ='1'></td>
                     <td align='center'><input type='checkbox' name='private' value ='1'></td>
                     <td align='center'><input type='checkbox' name='email' value ='1'></td>
                  </tr>
               </table>

               <p><label for='subject'>Subject:</label></p>
	       <p><input type='text' name='subject' size='20' value='' required></p>

	       <p><label for='notification_message'>Message:</label></p>
	       <p><textarea name='notification_message' cols='50' rows='10' style='text-align:left' required></textarea></p>

               <p><input type='submit' name='notifications' value='Send Notification!' class='button'></p>
               <input type='hidden' name='update' value='false'>
               </form>
               </center>
         ";
      //processing updates
      } else if ($_POST['update'] == "UPDATE") {
         if (isset($_POST['updbox'])) {
            $upd = $_POST['updbox'];
            $status = $_POST['actbox'];
            $admin = $_POST['admbox'];
            $subject = "Status Update";
            $count = count($upd);
            for($i = 0; $i < $count; $i++) {
	       $query = "SELECT Email FROM org_users where Org = '".$org."' and ID = '".$upd[$i]."'";
	       $result = mysqli_query($dbc, $query);
	       while($row = mysqli_fetch_assoc($result)) {
                  $em = $row["Email"];
               }
               if (isset($status[$i])) {
                  if ($status[$i] > '0') {
                     $body = "You have been inactivated.";
                     $sql = "UPDATE org_users SET Status = '0' WHERE id = '".$upd[$i]."'";
                     mysqli_query($dbc, $sql);
                     echo "$em is now inactive<br>";
                  } else {
                     $body = "You have been activated.";
	             $sql = "UPDATE org_users SET Status = '1' WHERE id = '".$upd[$i]."'";
                     mysqli_query($dbc, $sql);
                     echo "$em is now active<br>";
                  }
               }
               if (isset($admin[$i])) {
                  if ($admin[$i] > '0') {
                     $body = "You are no longer an admin.";
                     $sql = "UPDATE org_users SET Admin = '0' WHERE id = '".$upd[$i]."'";
                     mysqli_query($dbc, $sql);
                     echo "$em no longer is an admin<br>";
                  } else {
                     $body = "You are now an admin.";
	             $sql = "UPDATE org_users SET Admin = '1' WHERE id = '".$upd[$i]."'";
                     mysqli_query($dbc, $sql);
                     echo "$em is now an admin<br>";
                  }
               }
               send_email($em, $subject, $body);
            }
         }
      //process events
      } else if (isset($_POST['event'])) {
         if (isset($_POST['public']) || isset($_POST['private']) || isset($_POST['social'])) {
            $event = $_POST['event_name'];
            $flier = $_POST['flier'];
            $message = $_POST['event_message'];
            if (isset($_POST['public'])) {
               $public = '1';
            } else {
               $public = '0';
            }
            if (isset($_POST['private'])) {
               $private = '1';
            } else {
               $private = '0';
            }
            if (isset($_POST['social'])) {
               $social = '1';
            } else {
               $social = '0';
            }

            $sql = "INSERT INTO events (Org, Event_Name, Event_Message, Flier, Public, Private, Social_Media) VALUES ('".$org."','".$event."','".$message."','".$flier."','".$public."','".$private."','".$social."')";                                
	    if (mysqli_query($dbc, $sql)) {
               echo "Your Event was added!";
            } else {
               echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
            }

         } else {
            echo "You forgot to select where you wanted to post to";
         }
      // process notifications
      } else if (isset($_POST['notifications'])) {
         if (isset($_POST['public']) || isset($_POST['private']) || isset($_POST['email'])) {
            $subject = $_POST['subject'];
            $message = $_POST['notification_message'];
            if (isset($_POST['public'])) {
               $public = '1';
            } else {
               $public = '0';
            }
            if (isset($_POST['private'])) {
               $private = '1';
            } else {
               $private = '0';
            }
            if (isset($_POST['email'])) {
               $email = '1';
               $query = "SELECT Email FROM org_users where Org = '".$org."'";
	       $result = mysqli_query($dbc, $query);
	       while($row = mysqli_fetch_assoc($result)) {
                  $em = $row["Email"];
                  send_email($em, $subject, $message);
               }
            } else {
               $email = '0';
            }

            $sql = "INSERT INTO notifications (Org, Notification_Subject, Notification_Message, Public, Private, Email) VALUES ('".$org."', '".$subject."', '".$message."', '".$public."', '".$private."', '".$email."') ";                                
	    if (mysqli_query($dbc, $sql)) {
               echo "Your notification was sent!";
            } else {
               echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
            }

         } else {
            echo "You forgot to select where you wanted to send your notification";
         }
      } 
?>
</body>
</html>
