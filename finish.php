<?php
    require_once 'string.php';
    require_once 'conn.php';


    $qry = "UPDATE executiontime SET `end_time` = CURRENT_TIMESTAMP, `executiontime_record` = 0 WHERE executiontime_id = {$_GET['a']};";
    if($conn->query($qry)) {
        echo 'Success';
    } else {
        echo $conn->error;
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
        <a href="index.php">返回首頁</a>
    </body>
    </html>