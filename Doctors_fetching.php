<?php
    include("Connection.php");
    // if ($input1==NULL && $input2==NULL){
        // $input1=$_POST['email'];
        error_reporting(E_ALL ^ E_WARNING);
        $input1=$_POST['input1'];
        $input2=$_POST['input2'];
    // }
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
    <form action="Doctors_Fetching.php" method="post">
        <fieldset style="border:1px black">
            <legend>Input the Doctor details to get all the Patient details:</legend>
            Enter your name: 
            <?php
            echo "<input type='text' name='input1' value='NULL'><br><br>";
            ?>
            Enter your ID: 
            <?php
            echo "<input type='text' name='input2' value='NULL'><br><br>";
            ?>
            <button type="submit">Submit Details</button>
        </fieldset>
    </form>
    <hr>
    <?php
        $db=$con;
        $table3="Department";
        $table2="Doctors";
        $table1="Patients";
        $columns1=['Patient_id', 'Patient_name', 'Patient_email', 'Patient_password', 'DeptId'];
        $columns2=['Doc_id', 'Doc_Name', 'Doc_mobile', 'Doc_email', 'Doc_password', 'DeptId'];
        $columns3=['DeptId', 'dept_name', 'Doc_id', 'Patient_Id'];
        echo "Doctor Name: $input1<br>";
        echo "Doctor ID: $input2<br><br>";
        $fetchdata=fetch_data($db, $table3, $columns2, $table1, $table2, $columns3, $columns1, $input1, $input2);
        function fetch_data($db, $table3, $columns2, $table1, $table2, $columns3, $columns1, $input1, $input2){
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
                $query1 = "SELECT $table1.Patient_name, $table1.Patient_email from $table3 inner join $table1 where $table1.DeptId=(SELECT DeptId from $table2 where Doc_Name='$input1' and Doc_id='$input2') AND $table3.Patient_id=$table1.Patient_id";
                // $query1="select Patient_Name from `department` inner join `Patients` where `Patients`.DeptId=(select `DeptID` from doctors where Doc_Name='Lauren Kim') and `department`.Patient_id=`Patients`.Patient_id;"
                $result1 = $db->query($query1);
                // $result2 = $db->query($query2);
                if($result1==true){ 
                    if ($result1->num_rows > 0) {
                        $row1= mysqli_fetch_all($result1, MYSQLI_ASSOC);
                        $msg= $row1;
                        // $row2=mysqli_fetch_all($result2, MYSQLI_ASSOC);
                        // $msg2=$row2;
                        // if(is_array($msg2)){      
                        //     foreach($msg2 as $data){
                        //         echo "Name Of Department: ".$data['dept_name']."<br><br>";
                        //     }
                        // }
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
            <th>Patient's Name</th>
            <th>Patient's Email ID</th>
            <!-- <th>Doctor's Password</th> -->
        </tr>
        <?php
        if(is_array($fetchdata)){      
        $sn=1;
        foreach($fetchdata as $data){
            ?>
      <tr>
      <td><?php echo $sn; ?></td>
      <td><?php echo $data['Patient_name']??''; ?></td>
      <td><?php echo $data['Patient_email']??''; ?></td>
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