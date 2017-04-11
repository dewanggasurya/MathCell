<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	include 'config.php';
	
	$mysqli = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	$stmt = $mysqli->prepare("INSERT INTO highscore(name, score, level, date, ip) VALUES(?,?,?,NOW(),?)");
	$stmt->bind_param('ssds', $_POST['n'], $_POST['s'], $_POST['l'], $_SERVER['REMOTE_ADDR']);
	$stmt->execute();
	$stmt->close();
	
	$query = "SELECT MAX(`score`) AS score FROM `highscore`";
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