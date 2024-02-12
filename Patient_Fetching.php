<?php
    include("Connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        *{
            padding: 5pt;
            margin: 0;
        }
        .bcgrnd{
            display:flex;
            flex-direction: row;
            justify-content:space-between;
            width:100%;
            /* align-items:center; */
        }
        .first{
            border:1px black;
            width:50%;
        }
        .second{
            border:1px black;
            width:50%;
        }
    </style>
</head>
<body>
    <div class="bcgrnd">
    <div class="first">
    <form action="Patient_Fetching.php" method="post">
        <fieldset>
            <legend>Input the Patient details to get the Doctor details:</legend>
            Enter the name of Patient: 
            <input type="text" name="input1" value="NULL"><br><br>
            Enter the Email ID: 
            <input type="text" name="input2" value="NULL"><br><br>
            Enter the Password: 
            <input type="password" name="input3" value="NULL"><br><br>
            <button type="submit">Submit Details</button>
        </fieldset>
    </form>
    </div>
        <div class="second">
            <form action="Patient_Fetching.php" method="post">
                <fieldset>
                <legend>For more details of doctors of various departments in case of emergency:</legend>
                    Enter the Department to get Details of More Doctors from the Department:<br><br>
                    <input type="text" name="input5" value="NULL"><br><br>
                    <button type="submit1">Get Details</button>
                </fieldset>
            </form>
        </div>
    </div>
    <?php
        error_reporting(E_ALL ^ E_WARNING); 
        $db=$con;
        $table3="Doctors";
        $table2="Department";
        $table1="Patients";
        $columns1=['Patient_id', 'Patient_name', 'Patient_email', 'Patient_password', 'DeptId'];
        $columns2=['Doc_id', 'Doc_Name', 'Doc_mobile', 'Doc_email', 'Doc_password', 'DeptId'];
        $columns3=['Deptid', 'dept_name', 'Doc_id', 'Patient_Id'];
        $input1=$_POST['input1'];
        $input2=$_POST['input2'];
        $input3=$_POST['input3'];
        $input5=$_POST['input5'];
        $fetchdata=fetch_data($db, $table3, $columns2, $table1, $table2, $columns3, $input1, $input2, $input3, $input5);
        function fetch_data($db, $table3, $columns2, $table1, $table2, $columns3, $input1, $input2, $input3, $input5){
            if (empty($db)){
                $msg="Database Connection Error.";
            }
            else if (empty($columns2)||!is_array($columns2)){
                $msg="Column names must be defined in an indexed array.";
            }
            else if(empty($table3)){
                $msg="Table name is empty.";
            }
            else{
                
                // $columnName=implode(",", $columns1);
                // $query = "(SELECT $columnName FROM $table1 where $table1.Patient_name='$input1' and Patient_email='$input2' and Patient_password='$input3')";
                $columnName2=implode(",", $columns2);
                $columnName3=implode(",", $columns3);
                if ($input5=="Radiology"){
                    $deptid=10001;
                }
                else if ($input5=="Cardiology"){
                    $deptid=10002;
                }
                else if ($input5=="Neurology"){ 
                    $deptid=10003;
                }
                else if ($input5=="Dentist"){
                    $deptid=10004;
                }
                else{
                    $deptid=10005;
                }
                $query1 = "SELECT $columnName2 from $table3 where Doc_id=(SELECT Doc_id from $table2 where $table2.Patient_id=(SELECT Patient_id from $table1 where Patient_name='$input1' and Patient_email='$input2' and Patient_password='$input3'))";
                $query2="SELECT dept_name from $table2 where $table2.Patient_id=(SELECT Patient_id from $table1 where Patient_name='$input1' and Patient_email='$input2' and Patient_password='$input3')";
                $query3="SELECT $columnName2 from $table3 where DeptId=$deptid;";
                $result1 = $db->query($query1);
                $result2 = $db->query($query2);
                $result3 = $db->query($query3);
                if($result1== true && $result2==true && isset($_POST['input1'])){ 
                    $input5="NULL";
                    if ($result1->num_rows > 0 && $result2->num_rows>0) {
                        $row1= mysqli_fetch_all($result1, MYSQLI_ASSOC);
                        $msg= $row1;
                        $row2=mysqli_fetch_all($result2, MYSQLI_ASSOC);
                        $msg2=$row2;
                        if(is_array($msg2)){      
                            foreach($msg2 as $data){
                                echo "Name Of Department: ".$data['dept_name']."<br><br>";
                            }
                        }   
                    }
                    else {
                        $msg= "No Data Found"; 
                    }
                }
                else if($result3==true && isset($_POST['input5'])){
                    $input1="hello";
                    $input2="NULL";
                    $input3="NULL";
                    if ($result3->num_rows > 0) {
                        $row3=mysqli_fetch_all($result3, MYSQLI_ASSOC);
                        $msg=$row3;
                    }
                    else {
                        $msg= "No Data Found"; 
                    }
                }
                else{
                    $msg= mysqli_error($db);
                }
            }
            return $msg;
        }
    ?>
    
<hr>
    <div class=table_output>
    <table class="table table-bordered">
        <thead><tr><th>S.N</th>
            <th>Doctor's Name</th>
            <th>Doctor's Mobile No.</th>
            <th>Doctor's Email ID</th>
            <!-- <th>Doctor's Password</th> -->
            <th>Doctor's Department ID</th>
        </tr>
        <?php
        if(is_array($fetchdata)){      
        $sn=1;
        foreach($fetchdata as $data){
            ?>
      <tr>
      <td><?php echo $sn; ?></td>
      <td><?php echo $data['Doc_Name']??''; ?></td>
      <td><?php echo $data['Doc_mobile']??''; ?></td>
      <td><?php echo $data['Doc_email']??''; ?></td>
      <td><?php echo $data['DeptId']??''; ?></td>
     </tr>
     <?php
      $sn++;}}else{ ?>
      <tr>
        <td colspan="8">
    <?php echo $fetchdata; ?>
  </td>
    <tr>
    <?php
    }?>
     </table>
    </div>
    
    </body>
</html>