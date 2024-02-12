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
</head>
<body>
<h3>Details of Number of Doctors for Various Specializations:</h3>
The Departments with maximum number of Doctors: <br><br>
    <?php
        $db=$con;
        $table3="Doctors";
        $table2="Department";
        $table1="Patients";
        $columns1=['Patient_id', 'Patient_name', 'Patient_email', 'Patient_password', 'DeptId'];
        $columns2=['Doc_id', 'Doc_Name', 'Doc_mobile', 'Doc_email', 'Doc_password', 'DeptId'];
        $columns3=['Deptid', 'dept_name', 'Doc_id', 'Patient_Id'];
        $fetchdata=fetch_data($db, $table3, $columns2, $table1, $table2, $columns3, $columns1);
        function fetch_data($db, $table3, $columns2, $table1, $table2, $columns3, $columns1){
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
                $columnName1=implode(",", $columns1);
                // $query = "(SELECT $columnName FROM $table1 where $table1.Patient_name='$input1' and Patient_email='$input2' and Patient_password='$input3')";
                $columnName2=implode(",", $columns2);
                $columnName3=implode(",", $columns3);
                $query1 = "SELECT DeptId, (SELECT distinct Dept_name from $table2 where Deptid=$table3.Deptid) as Dept_Name, count(DeptId) as Number_of_Doctors from $table3 group by DeptId";
                $query2 = "SELECT DeptId, COUNT(*) AS CountOfDoctors FROM $table3 GROUP BY DeptId HAVING COUNT(*) = (SELECT MAX(CountOfDoctors) FROM (SELECT DeptId, COUNT(*) AS CountOfDoctors FROM $table3 GROUP BY DeptId) AS CountOfDoctorsTable);";
                $result1 = $db->query($query1);
                $result2 = $db->query($query2);
                if($result1== true){ 
                    if ($result1->num_rows > 0) {
                        $row1= mysqli_fetch_all($result1, MYSQLI_ASSOC);
                        $msg= $row1;
                        $row2=mysqli_fetch_all($result2, MYSQLI_ASSOC);
                        $msg2=$row2;
                        if(is_array($msg2)){   
                            $a=1;   
                            foreach($msg2 as $data){
                                if ($data['DeptId']==10001){
                                    $deptid="Radiology";
                                }
                                else if ($data['DeptId']==10002){
                                    $deptid="Cardiology";
                                }
                                else if ($data['DeptId']==10003){
                                    $deptid="Neurology";
                                }
                                else if ($data['DeptId']==10004){
                                    $deptid="Dentist";
                                }
                                else{
                                    $deptid="General Physician";
                                }
                                echo "$a) $deptid<br><br>";
                                $a++;
                            }
                        }
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
    
    <table class="table table-bordered">
        <thead><tr><th>S.N</th>
            <th>Department ID</th>
            <th>Department Name</th>
            <th>Number of Doctors</th>
            <!-- <th>Doctor's Password</th> -->
            <!-- <th>Doctor's Department ID</th> -->
        </tr>
        <?php
        if(is_array($fetchdata)){      
        $sn=1;
        foreach($fetchdata as $data){
            ?>
      <tr>
      <td><?php echo $sn; ?></td>
      <td><?php echo $data['DeptId']??''; ?></td>
      <td><?php echo $data['Dept_Name']??''; ?></td>
      <td><?php echo $data['Number_of_Doctors']??''; ?></td>
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
    
    <!-- <ol type="1">
        <li>
        
        </li>
    </ol> -->
    <br>
    <hr>
    <h3>Details of Number of Patients for Various Specializations:</h3>
    The Departments with maximum number of Doctors: <br><br>
    <?php
        $db=$con;
        $table3="Doctors";
        $table2="Department";
        $table1="Patients";
        $columns1=['Patient_id', 'Patient_name', 'Patient_email', 'Patient_password', 'DeptId'];
        $columns2=['Doc_id', 'Doc_Name', 'Doc_mobile', 'Doc_email', 'Doc_password', 'DeptId'];
        $columns3=['Deptid', 'dept_name', 'Doc_id', 'Patient_Id'];
        $fetchdata=fetch_data1($db, $table3, $columns2, $table1, $table2, $columns3, $columns1);
        function fetch_data1($db, $table3, $columns2, $table1, $table2, $columns3, $columns1){
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
                $columnName1=implode(",", $columns1);
                $columnName2=implode(",", $columns2);
                $columnName3=implode(",", $columns3);
                $query1 = "SELECT DeptId, (SELECT distinct Dept_name from $table2 where Deptid=$table1.Deptid) as Dept_Name, count(DeptId) as Number_of_Patients from $table1 group by DeptId";
                $query2="SELECT DeptId, COUNT(*) AS CountOfDoctors FROM $table1 GROUP BY DeptId HAVING COUNT(*) = (SELECT MAX(CountOfDoctors) FROM (SELECT DeptId, COUNT(*) AS CountOfDoctors FROM $table1 GROUP BY DeptId) AS CountOfDoctorsTable);";
                $result1 = $db->query($query1);
                $result2 = $db->query($query2);
                if($result1== true){ 
                    if ($result1->num_rows > 0) {
                        $a=1;
                        $row1= mysqli_fetch_all($result1, MYSQLI_ASSOC);
                        $msg= $row1;
                        $row2=mysqli_fetch_all($result2, MYSQLI_ASSOC);
                        $msg2=$row2;
                        if(is_array($msg2)){      
                            foreach($msg2 as $data){
                                if ($data['DeptId']==10001){
                                    $deptid="Radiology";
                                }
                                else if ($data['DeptId']==10002){
                                    $deptid="Cardiology";
                                }
                                else if ($data['DeptId']==10003){
                                    $deptid="Neurology";
                                }
                                else if ($data['DeptId']==10004){
                                    $deptid="Dentist";
                                }
                                else{
                                    $deptid="General Physician";
                                }
                                echo "$a) $deptid<br><br>";
                                $a++;
                            }
                        }
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
    <table class="table table-bordered">
        <thead><tr><th>S.N</th>
            <th>Department ID</th>
            <th>Department Name</th>
            <th>Number of Patients</th>
        </tr>
        <?php
        if(is_array($fetchdata)){      
        $sn=1;
        foreach($fetchdata as $data){
            ?>
      <tr>
      <td><?php echo $sn; ?></td>
      <td><?php echo $data['DeptId']??''; ?></td>
      <td><?php echo $data['Dept_Name']??''; ?></td>
      <td><?php echo $data['Number_of_Patients']??''; ?></td>
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
    
    </body>
</html>