<?php
    require_once 'string.php';
    require_once 'conn.php';  





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/attr.css">
</head>
<body>
    <?php switch ($_GET['m']){
        case 'c': ?>
            <div class="container">
                <a href="setattr.php?m=c" class="item">新增分類</a>
                <?php getCategory(); ?>
            </div>
            <?php break;
        case 't': ?>

            <div class="container">
                <a href="setattr.php?m=t" class="item">新增任務</a>
                <?php getTask(); ?>
            </div>
            <?php break;
        case 'l': ?>
            <div class="container">
                <a href="setattr.php?m=t" class="item">新增標籤</a>
                <?php getLabelTree(); ?>
            </div>
    <?php } ?>
</body>
</html>

<?php

function getCategory() {
    global $category_sorted;
    foreach($category_sorted as $row){ ?>
        <div class="item">
            <div class="wrap-line">
                <?php echo str_repeat('<div class="space"></div>', $row['level']-1); ?>
                <div class="line"><?php echo $row['row']['category_name']; ?></div>
            </div>
            <div class="wrap-line">
                <a class="link" href="setattr.php?m=c&a=<?php echo $row['row']['category_id']; ?>">修改</a>
                <div class="del">刪除</div>
            </div>
        </div>
    <?php }
    unset($row);
} 

function getTask() {
    global $task_sorted;
    foreach ($task_sorted as $row) {
     ?>
        <div class="item">
            <div class="wrap-line">
                <?php echo str_repeat('<div class="space"></div>', $row['level']-1); ?>
                <div class="line"><?php echo $row['row']['task_name']; ?></div>
            </div>
            <div class="wrap-line">
                <a class="link" href="setattr.php?m=t&a=<?php echo $row['row']['task_id']; ?>">修改</a>
                <div class="del">刪除</div>
            </div>
        </div>
    <?php } 
    unset($row);
            
}

function getLabelTree(){
    global $conn;

    $result = $conn->query("SELECT * FROM label");

    while ($row = $result->fetch_assoc()) { ?>
        <div class="item">
            <div class="wrap-line">
                <div class="line"><?php echo $row['label_name']; ?></div>
            </div>
            <div class="wrap-line">
                <a href="setattr.php?m=l&a=<?php echo $row['label_id']; ?>">修改</a>
                <div class="link">刪除</div>
            </div>
        </div>
    <?php }
}

?>