<?php 
session_start();
?>
<!doctype html>
<html>
<link rel="stylesheet" href="cscript.css">
<?php include('common.php'); ?>
<body>
<center>
<h1>Upcoming Events!</h1>
<div class="eventsdiv">
<?php
   if (!$dbc) {
	       die("Connection failed: " .mysqli_connect_error());
	    }


	    $query = "SELECT * FROM events where Public = '1' order by ID desc";
	    $result = mysqli_query($dbc, $query);
	

	    if (mysqli_num_rows($result) > 0) {
	       while($row = mysqli_fetch_assoc($result)) {
                  echo "<div class='div'>
		           <table class = 'ev'>
		              <tr>
		              <th class ='ev-events'><b>".$row["Event_Name"]."</b></th>
		              </tr>
		           
                              <tr>
		              <td class = 'ev-events2'><center>".$row["Event_Message"]."</center></td>
		              </tr>
		     
                              <tr>
		              <td class ='ev-events3'><center><img src='".$row["Flier"]."' style='max-height:100%; max-width:100%'; class='fill'></center></td>
		              </tr>
		          </table>
	               </div>";
	       }
	    mysqli_close($dbc);
	    }
?>
 
</div>
</center>
</body>
</html>
