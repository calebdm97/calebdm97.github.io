<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<?php include('common.php'); ?>
<link rel="stylesheet" href="cscript.css">

</head>
<body>
<?php 
if (isset($_SESSION["login"])) {
   echo "
       <center><div class='tiger'> <img src='tiger.jpg' style='max-height:auto; max-width:100%'; class='fill'></div></center>
       <center><div class='projectheader'><h1>Current Care Closet Crew Progress</h1></div></center>
       <div class='projectcontainer'>
          <div class='project' style='width: 64%'><h3>Pancake Sales!64%</h3></div>
       </div>
       ";
} else {

echo "
<div class='aboutus'>";
        $sql= "SELECT * from orgs where Org = 'Care Closet Crew'"; 
        $result = mysqli_query($dbc, $sql);
        while($row = mysqli_fetch_assoc($result)){
           $number = $row["Phone_Number"];
           $number = substr($number, 0, 3) .'-'. substr($number, 3, 3) .'-'. substr($number, 6);
	   echo "<div class='aboutmenu'><h3>Phone: <br>".$number."</h3></div>
	   <div class='aboutmenu'><h3>Email: <br>".$row["Email"]."</h3></div>
	   <div class='aboutmenu'><h3>Other: <br>Insert Here!</h3></div>
           ";
        }
echo "</div>

<div id='container'>
    <header class='photos'>
     <h1><b>Care Closet Crew</b></h1>
     <p style='font-size:60px'><center><h2><b>Mission Statement:</b></h2><br><b><i style='font-size:30px'> 'The purpose of The Care Closet Crew is to build a community of ECU students that participate in community service to benefit children in need in our community. The Care Closet Crew developes leadership skills, builds grit, and promotes character among members by working together to serve our community.'</b></i></center> </p><br><br>
    </header>
    
    <!-- Each image is 350px by 233px -->
    <div class='photobanner'>
    	<img class='first' style='height:1000px; width:auto' src='img1.jpg' alt='' />
    	<img class='logo' style='height:1000px; width:auto' src='img2.jpg' alt='' />
	<img style=height:1000px;  src='img3.jpg' alt='' />
		
    </div>
</div>





<center><table class='tg'>
  <tr>
    <th class='tg-baqh'><a href='https://www.facebook.com/careclosetcrew' target='_blank' ><img src='fblogo.png' height='70' style='padding-right:90px; padding-left:90px; height:100px; width:auto'><br> Facebook</th>
    <th class='tg-0lax'><img src='gfmlogo.png' height='70' style='padding-right:90px; padding-left:90px; height:100px; width:auto'><br><center> Donate </center></th>
  </tr>
</table>
</center>


";
}
?>
</body>
</html>
