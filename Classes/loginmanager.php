<?php
session_start();
require_once "includes/conn.php";

class loginManager {
    public function userlogin($voter,$password) {
        $conn = DBConnect::getConnection();
        $sql = "SELECT * FROM voters WHERE voters_id = '$voter' AND password = '$password'";
        $result = mysql_query($sql, $conn);
        $row = mysql_fetch_array($result, MYSQL_BOTH);

        if($row > 0){
                if($password == $row['password']){
                        $_SESSION['voter'] = $row['id'];
                        // echo "AB";
                        // exit ();
                        header('Location: home.php');   
                        exit();  
                }

        } else {
                if($password != $row['password']){
                $_SESSION['error'] = 'Cannot find voter with the ID';
                echo $row['password'];

                }else{
                        $_SESSION['error'] = 'Incorrect password';
                }
        }
    }

}

?>