<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Connect to MySQL</title>
</head>
<body>
<?php
if ($dbc = mysqli_connect('localhost','ccc','Binary_Elite')) {
	print '<p>Sucessfully connected!</p>';
	mysqli_close($dbc);
} else {
	print '<p>Connection Failed!</p>';
}
?>
</body>
</html>
