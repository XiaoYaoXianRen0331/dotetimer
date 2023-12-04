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
                <?php getCategoryTree(); ?>
            </div>
            <?php break;
        case 't': ?>

            <div class="container">
                <a href="setattr.php?m=t" class="item">新增任務</a>
                <?php getTaskTree(); ?>
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

function getCategoryTree($parentId = 20, $level = 1) {
    global $conn; // 假設你有一個全域的資料庫連接變數

    $result = $conn->query("SELECT category_id, category_name, parent_id FROM category WHERE parent_id = \"{$parentId}\";");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
            <div class="item">
                <div class="wrap-line">
                    <?php echo str_repeat('<div class="space"></div>', $level-1); ?>
                    <div class="line"><?php echo $row['category_name']; ?></div>
                </div>
                <div class="wrap-line">
                    <a class="link" href="setattr.php?m=c&a=<?php echo $row['category_id']; ?>">修改</a>
                    <div class="del">刪除</div>
                </div>
            </div>
            <?php
            getCategoryTree($row['category_id'], $level + 1);
        }
    }
}

function getTaskTree($parentId = 1, $level = 1) {
    global $conn; // 假設你有一個全域的資料庫連接變數

    $result = $conn->query("SELECT task_id, task_name, task_parent_id FROM task WHERE task_parent_id = \"{$parentId}\";");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
            <div class="item">
                <div class="wrap-line">
                    <?php echo str_repeat('<div class="space"></div>', $level-1); ?>
                    <div class="line"><?php echo $row['task_name']; ?></div>
                </div>
                <div class="wrap-line">
                    <a class="link" href="setattr.php?m=t&a=<?php echo $row['task_id']; ?>">修改</a>
                    <div class="del">刪除</div>
                </div>
            </div>
            <?php
            getTaskTree($row['task_id'], $level + 1);
        }
    }
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