<?php
require "classes/connection.php";

class login_users {
      
    function login ($NIC,$Password){
       $con = DBConnect::getConnection();
       
          $sql="SELECT * FROM userinfo where nic='$NIC' and password='$Password' and status = 1";
          $result = mysql_query($sql, $con) or die("check_login_details");
          $row = mysql_fetch_assoc($result);  
          return $row['usertype'] ;              
    }
}

?>


