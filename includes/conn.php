<?php
	class DBConnect {
    
		   public static function getConnection() {
				$host = "localhost";
				$user = "root";
				$pass = "";
				$database = "votesystem";
		
				@$connection = mysql_connect($host, $user, $pass) or die("couldn't connect to the server");
				mysql_select_db($database, $connection) or die("Couldn't select the db");
				return $connection;
			}
    }


	
?>