<?php
require_once 'string.php';
require_once 'conn.php';



if($_GET['r']==2){
    $qry = "INSERT INTO ExecutionTime (start_time, executiontime_category_id, executiontime_note, executiontime_task_id, executiontime_record) 
    VALUES (current_timestamp(), \"{$_POST['category']}\", \"{$_POST['note']}\", \"{$task_item}\", 2);";
} else {
    $qry = "INSERT INTO ExecutionTime (start_time, end_time, executiontime_category_id, executiontime_note, executiontime_task_id, executiontime_record) 
    VALUES (\"{$_POST['start']}\", \"{$_POST['end']}\", \"{$_POST['category']}\", \"{$_POST['note']}\", \"{$task_item}\", \"{$_GET['r']}\");";
}

try {
    $conn -> query($qry);
    echo 'Success inserting executiontime';


    $ExecutionTimeId = $conn->insert_id;
    if(isset($_Post['label'])) {
        foreach($_Post['label'] as $item) {
            $qry = "INSERT INTO Tasklabel (tasklabel_id, tasklabel_label_id) VALUES (\"{$ExecutionTimeId}\", \"{$item}\");";
    
            try {
                $conn -> query($qry);
                echo 'Success inserting tasklabel' . $item;
            } catch (Exception $e) {
                echo $conn->error;
            }
    
        }
    }
} catch(Exception $e) {
    echo 'Failed inserting executiontime: ' .$conn->error;
} finally {
    sleep(5);
    header('Location:index.php');
}





?>