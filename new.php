<?php
require_once 'string.php';
require_once 'conn.php';



if($_GET['r']==2){
    $qry = "INSERT INTO ExecutionTime (start_time, executiontime_category_id, executiontime_note, executiontime_task_id, executiontime_record) 
    VALUES (current_timestamp(), \"{$_POST['category']}\", \"{$_POST['note']}\", \"{$_POST['task']}\", 2);";
} else {
    $qry = "INSERT INTO ExecutionTime (start_time, end_time, executiontime_category_id, executiontime_note, executiontime_task_id, executiontime_record) 
    VALUES (\"{$_POST['start']}\", \"{$_POST['end']}\", \"{$_POST['category']}\", \"{$_POST['note']}\", \"{$_POST['task']}\", \"{$_GET['r']}\");";
}

try {
    $conn -> query($qry);
    $ExecutionTimeId = $conn->insert_id;
    echo 'Success inserting executiontime.<br></br>';


    if(isset($_POST['label'])) {
        foreach($_POST['label'] as $item) {
            $qry = "INSERT INTO Tasklabel (tasklabel_id, tasklabel_label_id) VALUES (\"{$ExecutionTimeId}\", \"{$item}\");";
    
            try {
                $conn -> query($qry);
                echo 'Success inserting label' . $item . '<br/>';
            } catch (Exception $e) {
                echo $conn->error;
            }
    
        }
    }
} catch(Exception $e) {
    echo 'Failed inserting executiontime: ' .$conn->error;
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>wait for 3 sec(s).</div>
    <span>or click </span>
    <a href="index.php">here</a>
</body>
<script>
    t = 2;
    div = document.querySelector('div');
    setInterval(() => {
        div.innerHTML = `wait for ${t} sec(s).`;
        t -= 1;
    }, 1000);
    setInterval(() => {
        window.location.href='index.php';
    }, 3000);
</script>
</html>