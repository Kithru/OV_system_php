<?php
	require_once "includes/conn.php";
	session_start();

	if(isset($_SESSION['voter'])){
		$conn = DBConnect::getConnection();
		$sql = "SELECT * FROM voters WHERE id = '".$_SESSION['voter']."'";
		$result = mysql_query($sql,$conn);
                if ($result) {
                    $voter = mysql_fetch_assoc($result);
                } else {
                    echo "Error: " . mysql_error($conn);
                }
	}
	else{
		header('location: index.php');
		exit();
	}

?>



