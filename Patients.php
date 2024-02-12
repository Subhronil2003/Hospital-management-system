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
    <?php
        $db=$con;
        $table3="Doctors";
        $table2="Department";
        $table1="Patients";
        $columns1=['Patient_id', 'Patient_name', 'Patient_email', 'Patient_password', 'DeptId'];
        $columns3=['Deptid', 'dept_name', 'Doc_id', 'Patient_Id'];
        $fetchdata=fetch_data($db, $table1, $columns1);
        function fetch_data($db, $table1, $columns1){
            if (empty($db)){
                $msg="Database Connection Error.";
            }
            else if (empty($columns1)||!is_array($columns1)){
                $msg="Column names must be defined in an indexed array.";
            }
            else if(empty($table1)){
                $msg="Table name is empty.";
            }
            else{
                $columnName=implode(",", $columns1);
                $query = "SELECT ".$columnName." FROM $table1";
                $result = $db->query($query);
                if($result== true){ 
                    if ($result->num_rows > 0) {
                        $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
                        $msg= $row;
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
            <th>Patient's Department ID</th>
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

    </body>
</html>