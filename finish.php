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