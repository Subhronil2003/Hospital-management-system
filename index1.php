<?php
    // if (isset($_POST['email']) && isset($_POST['pass'])){
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
        $name = $_POST['name1'];
        $mobile= $_POST['mobile'];
        $newpass = $_POST['pass'];
        $dept = $_POST['dept'];
        $opt=$_POST['person'];
        // echo $dept;
        $sqla="INSERT INTO `firstattempt`.`doctors` (`Doc_Name`, `Doc_mobile`, `Doc_email`, `Doc_password`, `DeptId`) VALUES ('$name', '$mobile', '$email_id', '$newpass', '$dept');";
        $sqlb="INSERT INTO `firstattempt`.`patients` (`Patient_Name`, `Patient_email`, `Patient_password`, `DeptId`) VALUES ('$name', '$email_id', '$newpass', '$dept');";
        // echo $count;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="login.css">
    <style>
        /* .divide{
            font-size:10pt;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:row;

        } */
        #doc, #pat{
            width:30%;
            height: 20px;
            padding: 0;
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
            <form action="index1.php" method="post">
                <div class="input" style="width: 98%;" >
                    <p style="padding-bottom: 10pt"><b>Name:</b></p>
                    <input type="text" name="name1" required>
                </div>
                <div class="input" style="width: 98%;" >
                    <p style="padding-bottom: 10pt"><b>Mobile No.</b>(This field is optional for patients):</p>
                    <input type="text" name="mobile" required>
                </div>
                <div class="input" style="width: 98%;" >
                    <p style="padding-bottom: 10pt"><b>Email ID:</b></p>
                    <input type="email" name="email" required>
                </div>
                <div class="input" style="width: 98%;" >
                    <p style="padding-bottom: 10pt"><b>Password:</b></p>
                    <input type="password" name="pass" required>
                </div>
                <div class="input" style="width: 98%;" >
                    <p style="padding-bottom: 10pt"><b>Department Name:</b></p>
                        <select name="dept">
                            <option value="" disabled selected>Select a department</option>
                            <option value="10001">Radiology</option>
                            <option value="10002">Cardiology</option>
                            <option value="10003">Neurology</option>
                            <option value="10004">Dentist</option>
                            <option value="10005">General Physician</option>
                        </select>
                </div>
                <div class="divide" style="width: 98%;" >
                    <input type="radio" name="person" value="1" id="doc">Doctor&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="person" value="2" id="pat" checked>Patient
                </div>
                <div class="input" style="width: 98%;" >
                <button class='button' type="Submit">Sign In</button>
                </div>
                <!-- <div class="input" style="width: 98%;" >
                    <button class="button" onclick="document.location='login.html'">If you already have an account - <u>Log In</u></button>
                </div> -->
            </form>
            <?php
            // echo "Option no.: $opt";
            if ($opt==1){
                $sql1=mysqli_query($con, "SELECT * FROM `firstattempt`.`doctors` where Doc_email='$email_id' and Doc_password='$newpass';");
                $count=mysqli_num_rows($sql1);
                if ($count==0){
                    if ($con->query($sqla) == true){
                        echo ("Successfully inserted");
                    }
                    else {
                        echo "Error: $sqla <br> $conn->error";
                    }
                    header('Location: Doctors_fetching.php');
                }
                else if ($count==1 && $email==NULL && $newpass==NULL){
                }
                else if ($count==1){
                    echo "<p class='filled'>The specified user already exists. Please try logging in to continue with the same username or enter using a new email id and password. Dept.: Doctors</p><br>";
                    // header('Location: index1.php');
                }
            }
            else if ($opt==2){
                $sql1=mysqli_query($con, "SELECT * FROM `firstattempt`.`patients` where Patient_email='$email_id' and Patient_password='$newpass';");
                $count=mysqli_num_rows($sql1);
                // echo $count;
                if ($count==0){
                    if ($con->query($sqlb)==true){
                        echo ("Successfully inserted");
                    }
                    else {
                        echo "Error: $sqlb <br> $conn->error";
                    }
                    header('Location: Patient_fetching.php');
                }
                else if ($count==1 && $email==NULL && $newpass==NULL){
                }
                else if ($count==1){
                    echo "<p class='filled'>The specified user already exists. Please try logging in to continue with the same username or enter using a new email id and password. Dept.: Patients</p><br>";
                    // header('Location: index1.php');
                }
            }
                $con->close();
            ?>
        <p>Already have an account? Click below to Log In.</p>
        <button class="button" onclick="document.location='index2.php'">Login</button><br><br>
        </div>
    </div>
</body>
</html>