<?php
require_once 'string.php';
require_once 'conn.php';



$qry = "UPDATE ExecutionTime SET `start_time`=\"{$_POST['start']}\", 
`end_time`=\"{$_POST['end']}\", 
`executiontime_category_id`=\"{$_POST['category']}\", 
`executiontime_note`=\"{$_POST['note']}\", 
`executiontime_task_id`=\"{$_POST['task']}\"
WHERE `executiontime_id` = \"{$_GET['a']}\";";

try {
    $conn -> query($qry);
    echo "Success<br></br>";


    if(isset($_POST['label'])) {

        $conn -> query("DELETE FROM tasklabel WHERE `tasklabel_id` = \"{$_GET['a']}\";");
    
    
        foreach($_POST['label'] as $label_item) {
    
            $qry = "INSERT IGNORE INTO Tasklabel (tasklabel_id, tasklabel_label_id) VALUES (\"{$_GET['a']}\", \"{$label_item}\");";
            $conn -> query($qry);
            echo 'Success insert: ' . $label_item . '<br/>';
    
        }
    }


} catch (Exception $e) {
    echo "Error: " . $conn -> error;
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