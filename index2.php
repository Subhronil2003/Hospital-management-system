<?php
        $server="localhost";
        $username="root";
        $password="";
        $con=mysqli_connect($server, $username, $password);
        if (!$con){
            die("Connection to this database failed due to" . mysqli_connect_error());
        }
        // echo "Successful database connection.<br>";
        error_reporting(E_ALL ^ E_WARNING);
        $email_id = $_POST['email'];
        $newpass = $_POST['password'];
        $opt=$_POST['person'];
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="login.css">
    <style>
        #doc, #pat{
            width:30%;
            height: 20px;
            padding: 0;
        }
        .exists{
            color:green;
            font-size: 13px;
        }
        .filled{
            color:red;
            font-size: 13px;
        }
        select{
            position:relative;
            width:100%;
            height: 40pt;
            text-align:center;
            /* background-color: royalblue; */
            /* color: white; */
            border-radius: 10px;
        }
        .bcgrnd>.box{
            position:relative;
            width: 350pt;
            padding-left:15pt;
            padding-right:15pt;
            margin-top:40px;
            margin-bottom:20pt;
            border: 2px solid black;
            border-radius: 10px;
        }
        .bcgrnd{
            display: flex;
            flex-direction: row;
            justify-content:center;
            align-items:center;
            height: auto;
            width: auto;
        }
    </style>
</head>
<body>
    <div class="nav_bar">
        <a href="index2.php">Login</a>
        <a href="index1.php">Sign In</a>
    </div>
    <div class="bcgrnd">
        <div class="box" >  
            <form action="index2.php" method="post">
            <div class="input">
                    <p style="padding-bottom: 10pt"><b>Username/Email ID:</b></p>
                    <input type="text" name="email" style="width: 98%;" size="1" value="" required>
                </div>
                <div class="input">
                    <p style="padding-bottom: 10pt"><b>Password:</b></p>
                    <input type="password" name="password" size="1" style="width: 98%;" value="" required>
                </div>
                <div class="divide" style="width: 98%;" >
                    <input type="radio" name="person" value="1" id="doc">Doctor&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="person" value="2" id="pat" checked>Patient
                </div>
                <div class='input' style='width: 98%;'>
                <button class="button" type="Submit">Log In</button>
                </div>
                <?php
                if ($opt==1){
                    $sql1=mysqli_query($con, "SELECT * FROM `firstattempt`.`doctors` where Doc_email='$email_id' and Doc_password='$newpass';");
                    $count=mysqli_num_rows($sql1);
                    // echo $count;
                    if ($count==1  && $email_id!=NULL && $newpass!=NULL){
                        echo "<p class='exists'>Data entry exists</p><br>";
                        header('Location: Doctors_fetching.php');
                    }
                    else if ($count==0 && $email_id==NULL && $newpass==NULL){}
                    else if ($count==0){
                        echo "<p class='filled'>The specified user does not exist. To access other features, sign in to continue.</p><br>";      
                    }
                }
                else if ($opt==2){
                    $sql1=mysqli_query($con, "SELECT * FROM `firstattempt`.`patients` where Patient_email='$email_id' and Patient_password='$newpass';");
                    $count=mysqli_num_rows($sql1);
                    // echo $count;
                    if ($count==1  && $email_id!=NULL && $newpass!=NULL){
                        echo "<p class='exists'>Data entry exists</p><br>";
                        header('Location: Patient_fetching.php');
                    }
                    else if ($count==0 && $email_id==NULL && $newpass==NULL){}
                    else if ($count==0){
                        echo "<p class='filled'>The specified user does not exist. To access other features, sign in to continue.</p><br>";      
                    }
                }
                $con->close();
        ?>
        </form>
        <p>New to the Website? Sign Up to access more details of the system.</p>
        <button class="button" onclick="document.location='index1.php'">Sign In</button><br><br>
        </div>
    </div>
</body>
</html>