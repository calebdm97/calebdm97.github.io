<?php
session_start();
?>
<html>
<head>
<link rel="stylesheet" href="cscript.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title> Care Closet </title>
</head>
<body>
<div class="header">
<?php
   if (isset($_SESSION["login"])) {
      $org = $_SESSION["org"];
      echo "<a href='ccc.php'><img id='logo' src='CCC_2019.PNG' height='50px'  align='left' style='padding-top:5px; padding-right:9px; padding-left:20px; width:auto; height:60px' ></a>
         <h1><b>Welcome to the " . $org . " Portal</b></h1>
      ";
   } else {
       echo "<a href='ccc.php'><img id='logo' src='CCC_2019.PNG' height='50px'  align='left' style='padding-top:5px; padding-right:9px; padding-left:20px; width:auto; height:60px' ></a>
	<!--<img src='logo2.png' height='70'  align='left'>
	<img src='logo3.png' height='70' align='right' style='padding-right:90px' >
	<img src='logo4.png' height='70'  align='right' style='padding-right:90px'>-->
        <h1><b>Thank You for Visiting the Care Closet Website</b></h1>
        ";
   }
?>

</div>	

<?php 
  if (isset($_SESSION["login"])) {
     if ($_SESSION["login"] == true) {
        echo "<div class='logtopnav'>";
	echo "<a href='login_events.php' target='display'>Events</a>";
	echo "<a href='login_notifications.php' target='display'>Notifications</a>";
	if($_SESSION["admin"] == "1") {
	   echo "<div class='dropdown'>
              <button class='dropbtn'>Administration</button>
              <div class='dropdown-content'>
                 <a href='admin.php?response=update' target='display'>Update</a>
                 <a href='admin.php?response=events' target='display'>Events</a>
                 <a href='admin.php?response=notifications' target='display'>Notifications</a>
              </div>
           </div>";
	}	
	echo "<a class='anch_right' href='logout.php'>Logout</a>";
        echo "</div>";
     }
  } else {
        echo "<div class='topnav'>";
        echo "<a href ='iframea.php' target='display'><i class='fa fa-home' style='font-size:34px'></i></a>";
  	echo "<a href='events.php' target='display'>Upcoming Events</a>";
  	echo "<a href='notifications.php' target='display'>Notifications</a>";
        echo "<a href='request.php' target ='display'>Request Info</a>";
        echo "<a href='register.php' target ='display'>Register</a>";
        echo "<a href='login.php'>Login</a>";
        echo "</div>";
        if (isset($_SESSION["logout"])) {
          session_unset();
          echo "
          <center>
          <div class='alert'>
             <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span> 
             You have sucessfully logged out!
          </div>
          <center>
          ";
       }
  }
  ?>

<iframe class= "display" src="iframea.php" name = "display"></iframe>

</body>
</html>
