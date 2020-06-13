<?php 
session_start();
?>
<!doctype html>
<html>
<link rel="stylesheet" href="cscript.css">
<?php include('common.php'); ?>
<body>
<center>
<h1>Notifications!</h1>

<div class="eventsdiv">
<?php
   $query = "SELECT * FROM notifications where Public = '1' order by ID desc";
   $result = mysqli_query($dbc, $query);
	

   if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
         echo "<div>
	          <table class = 'ev'>
	          <tr>
	          <th class ='ev-events'><b>".$row["Notification_Subject"]."</b></th>
	          </tr>
		           
                  <tr>
	          <td class = 'ev-events2' align='left'>".$row["Notification_Message"]."</td>
                  </tr>
                  </table>
	       </div>";
      }
      mysqli_close($dbc);
   } else {
      echo "<div>".$org." Has not sent out any notifications!</div>";
   }
?>
 
</div>
</center>
</body>
</html>
