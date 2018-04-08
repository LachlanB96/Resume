<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<title>My Bookings</title>
</head>
<body>

	<?
	session_start();

	$conn = mysqli_connect("localhost","root","mysql", "resume");


	if(isset($_GET['name'])){
		$sql = "INSERT INTO `data`(`name`, `location`, `content`, `gg`) VALUES ('".$_GET['name']."','aaa','ccc','sdc')";
		$conn->query($sql);
	}


	$sql = "SELECT * FROM data WHERE 1";
	$rs=$conn->query($sql);

	$arr = $rs->fetch_all(MYSQLI_ASSOC);
	
	foreach($arr as $row) {
		echo $row['name'] . '<br />';
	}

	?>


	<form method="get">
		Name: <input type="text" name="name"><br>
		E-mail: <input type="text" name="email"><br>
		<input type="submit">
	</form>


</body>
</html>	



