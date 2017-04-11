<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	$page = ($_POST['p'])?intval($_POST['p']):1;
	$limit = 5;
	$offset = ($page-1)*$limit;
	include 'config.php';
	
	$mysqli = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	
	$query = "SELECT * FROM `highscore` ORDER BY score DESC, level DESC LIMIT ".$offset.",".$limit;
	$result = $mysqli->query($query) or die(mysql_error());
	$i=0;
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$data['response'][$i]['position'] = '#'.($i+1+$offset);
		$data['response'][$i]['name'] = $row['name'];
		$data['response'][$i]['score'] = $row['score'];
		$data['response'][$i]['level'] = $row['level'];
		$i++;
	}

	$mysqli->close();
	$data['count'] = $result->num_rows;
	echo json_encode($data);
}else{
	echo "You may not access this file";
}
?>