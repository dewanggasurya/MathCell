<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	include 'config.php';
	
	$mysqli = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	
	$query = "SELECT * FROM `highscore`";
	$result = $mysqli->query($query);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$data['highscore'] = 0;
	if(intval($_POST['s'])>= intval($row['score']))
		$data['highscore'] = 1;	
	$mysqli->close();
		
	$data['result'] = 1;	
	echo json_encode($data);
}else{
	echo "You may not access this file";
}
?>