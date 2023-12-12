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
    <link rel="stylesheet" href="assets/css/color.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/attr.css">
</head>
<body>
    <div class="wrap-header">
        <!-- 徽號 -->
        <div class="logo">
            <img src="assets/images/dotetimer.png" alt="Dotetimer" title="Dotetimer" height="60px" />
        </div>
        <!-- 連結 -->
        <ul>
            <li>
                <div class="header-item switch" id="switch-category">
                    <div>分類</div>
                </div>
            </li>
            <li>
                <div class="header-item" id="switch-task">
                    <div>任務</div>
                </div>
            </li>
            <li>
                <div class="header-item" id="switch-label">
                    <div>標籤</div>
                </div>
            </li>
            <li>
                <div class="header-item">
                    <a href="index.php">返回首頁</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="container active" id="container-category">
        <div class="new">
            <a href="setattr.php?m=c">新增分類</a>
        </div>
        <div class="wrap-item">
            <?php getCategory(); ?>
        </div>
    </div>
    <div class="container" id="container-task">
        <div class="new">
            <a href="setattr.php?m=t">新增任務</a>
        </div>
        <div class="wrap-item">
            <?php getTask(); ?>
        </div>
    </div>
    <div class="container" id="container-label">
        <div class="new">
            <a href="setattr.php?m=l">新增標籤</a>
        </div>
        <div class="wrap-item">
            <?php getLabel(); ?>
        </div>
    </div>

</body>
<script>
    category = document.getElementById('container-category')
    task = document.getElementById('container-task');
    label = document.getElementById('container-label');
    switch1 = document.getElementById('switch-category');
    switch2 = document.getElementById('switch-task');
    switch3 = document.getElementById('switch-label');
    switch1.addEventListener('click', (e) => {
        category.classList.add('active');
        task.classList.remove('active');
        label.classList.remove('active');
        switch1.classList.add('switch');
        switch2.classList.remove('switch');
        switch3.classList.remove('switch');
    });
    switch2.addEventListener('click', (e) => {
        category.classList.remove('active');
        task.classList.add('active');
        label.classList.remove('active');
        switch1.classList.remove('switch');
        switch2.classList.add('switch');
        switch3.classList.remove('switch');
    });
    switch3.addEventListener('click', (e) => {
        category.classList.remove('active');
        task.classList.remove('active');
        label.classList.add('active');
        switch1.classList.remove('switch');
        switch2.classList.remove('switch');
        switch3.classList.add('switch');
    });
</script>
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
                <a href="del.php?m=c&a=<?php echo $row['row']['category_id']; ?>">刪除</a>
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
                <a href="del.php?m=t&a=<?php echo $row['row']['task_id']; ?>">刪除</a>
            </div>
        </div>
    <?php } 
    unset($row);
            
}

function getLabel(){
    global $conn;

    $result = $conn->query("SELECT * FROM label");

    while ($row = $result->fetch_assoc()) { ?>
        <div class="item">
            <div class="wrap-line">
                <div class="line"><?php echo $row['label_name']; ?></div>
            </div>
            <div class="wrap-line">
                <a href="setattr.php?m=l&a=<?php echo $row['label_id']; ?>">修改</a>
                <a href="del.php?m=l&a=<?php echo $row['label_id']; ?>">刪除</a>
            </div>
        </div>
    <?php }
}

?>