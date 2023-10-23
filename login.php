<?php 


require 'classes/loginclass.php';
$login_users = new login_users();
$response = '';

if (isset($_POST['submit'] )) {

  if (isset($_REQUEST['nic'])) {
    $nic = $_REQUEST['nic'];
  }
  if (isset($_REQUEST['password'])) {
    $password = $_REQUEST['password'];
  }

    $response = $login_users->login($_POST['nic'], $_POST['password']);
} 


?>

<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Voting</title>

</head>
<body>
<!-- partial:index.partial.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Glassmorphism login Form Tutorial in html css</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    
  <script>
      $(document).ready(function () {
          
            var status = $('#status').val();
            if (status == '1') {
            alert('Successfully login as an Administrator.');
            
            window.location.href = "managedetails.php";
            return false;
             } 
            if (status == '2') {
            alert('Successfully login as a candidate.');
            window.location.href = "candidatedetails.php";
            return false;
            }
            if (status == '3') {
            alert('Successfully login as a voter.');
            window.location.href = "voter.php";
            return false;
             }
            if (status == 'Error') {
            alert('Invalid login, Please try again.');
            return false;
             } 
            
      }); 

      function login_onsubmit() { 
            if (document.Login.nic.value == "") {
                window.alert("Please insert NIC number");
                document.Login.nic.focus();
                event.preventDefault();
                return false;
            }
            var nicInput = document.Login.nic.value;
                 if(nicInput.length!=10 && nicInput.length!=12){
                        window.alert("Invalid NIC Number "+"\n"+"please provide nic number 10 or 12 character format");
                        document.Login.nic.focus();
                        event.preventDefault();
                        return false;
                    }else if(nicInput.length==10){
                        var value='';

                        if(nicInput.charAt(9)=='V'){
                            value = nicInput.substring(0,9);
                        }else if(nicInput.charAt(9)=='X'){
                            value = nicInput.substring(0,9);
                        }else{
                            window.alert("Invalid NIC Number"+"\n"+"Please enter X or V character end of the number");
                            document.Login.nic.focus();
                            event.preventDefault();
                            return false;
                        }

                        if(isNaN(value)){
                            window.alert("First nine characters should be numbers");
                            document.Login.nic.focus();
                            event.preventDefault();
                            return false;
                        }

                        if(nicInput.charAt(9)!='V' && nicInput.charAt(9)!='X'){
                            window.alert("Invalid NIC Number"+"\n"+"Please enter X or V character end of the number");
                            document.Login.nic.focus();
                            event.preventDefault();
                            return false;
                        } 
                        
                    }else if(nicInput.length==12){
                        if (isNaN(nicInput)){
                            window.alert("Invalid NIC Number"+"\n"+"Please enter numbers for 12 digits NIC");
                            document.Login.nic.focus();
                            event.preventDefault();
                            return false;
                        }
                        
                    } 
            if (document.Login.password.value == "") {
                window.alert("Please insert a password");
                document.Login.password.focus();
                event.preventDefault();
                return false;
            }
      }
        
    </script>

    <style media="screen">
      *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    background-color: #080710;
}
.background{
    width: 430px;
    height: 520px;
    position: absolute;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 50%;
}
.background .shape{
    height: 200px;
    width: 200px;
    position: absolute;
    border-radius: 50%;
}
.shape:first-child{
    background: linear-gradient(
        #1845ad,
        #23a2f6
    );
    left: -80px;
    top: -80px;
}
.shape:last-child{
    background: linear-gradient(
        to right,
        #ff512f,
        #f09819
    );
    right: -30px;
    bottom: -80px;
}
form{
    height: 520px;
    width: 400px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 30px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
button{
    margin-top: 50px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}


    </style>
</head>
<body>
  <input type="hidden" name="status" id="status" value="<?php echo $response; ?>">
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form name="Login" method="post" action="login.php">
        <h3>Login</h3>

        <label for="nic">NIC</label>
        <input type="text" placeholder="Please enter NIC" id="nic" name="nic">

        <label for="password">Password</label>
        <input type="password" placeholder="Please enter password" id="password" name="password">

        <label></label>
        <input type="submit" name="submit" value="Login" onclick="login_onsubmit();" />
        
    </form>
</body>
</html>

  
</body>
</html>