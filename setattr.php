<?php
    require_once 'string.php';
    require_once 'conn.php';
    $a = (isset($_GET['a'])) ? true : false;
    if ($a) {
        switch ($_GET['m']) {
            case 'c':
                $result = $conn->query("SELECT * FROM category WHERE category_id = {$_GET['a']};")->fetch_assoc();
                break;
            case 't':
                $result = $conn->query("SELECT * FROM task WHERE task_id = {$_GET['a']};")->fetch_assoc();
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增資料</title>
    <link rel="stylesheet" href="assets/css/color.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/setattr.css">
</head>
<body>
    <div class="wrap-header">
        <div class="logo">
            <img src="assets/images/dotetimer.png" alt="Dotetimer" title="Dotetimer" height="60px" />
        </div>
        <ul>
            <li>
                <div class="header-item">
                    <a href="">登出</a>
                </div>
            </li>
            <li>
                <div class="header-item">
                    <a href="">帳號管理</a>
                </div>
            </li>
        </ul>
    </div>

    <?php switch ($_GET['m']) {
        case 'c': ?>
            <div class="titlebar">
                <?php echo (isset($_GET['a']))?'修改分類':'新增分類' ?>
            </div>
            <div class="container">
                <form action="newattr.php?m=c" method="post">
                    <div class="item">
                        <div class="title">分類名稱</div>
                        <input type="text" name="name" value="<?php echo ($a)?$result['category_name']:'' ?>">
                    </div>
                    <div class="item">
                        <div class="title">子分類</div>
                        <div class="wrap-options">
                            <?php while ($row = $category->fetch_assoc()) { ?>
                                <div class="option">
                                    <input type="radio" name="sub" id="sub_category_<?php echo $row['category_id']; ?>" <?php if($a){echo ($row['category_id'] == $result['parent_id'])?'checked':'';} ?>>
                                    <label for="sub_category_<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="item">
                        <div class="title"></div>
                        <button class="btn">確定</button>
                    </div>
                </form>
            </div>


            <?php break;
        case 't': ?>
            <div class="titlebar">
                <?php echo (isset($_GET['a']))?'修改任務':'新增任務' ?>
            </div>
            <div class="container">
                <form action="newattr.php?m=t" method="post">
                    <div class="item">
                        <div class="title">任務名稱</div>
                        <input type="text" name="name" value="<?php echo ($a)?$result['task_name']:'' ?>">
                    </div>
                    <div class="item">
                        <div class="title">子任務</div>
                        <div class="wrap-options">
                            <?php while ($row = $task->fetch_assoc()) { ?>
                                <div class="option">
                                    <input type="radio" name="sub" id="sub_task_<?php echo $row['task_id']; ?>" <?php if($a){echo ($row['task_id'] == $result['task_parent_id'])?'checked':'';} ?> />
                                    <label for="sub_task_<?php echo $row['task_id']; ?>"><?php echo $row['task_name']; ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="item">
                        <div class="title">分類</div>
                        <div class="wrap-options">
                            <?php while ($row = $category->fetch_assoc()) { ?>
                                <div class="option">
                                    <input type="radio" name="category" id="category_belong_<?php echo $row['category_id']; ?>" <?php if($a){echo ($row['category_id'] == $result['task_category_id'])?'checked':'';} ?>>
                                    <label for="category_belong_<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="item">
                        <label for="deadline" class="title">完成期限</label>
                        <input type="datetime-local" name="deadline" id="deadline" value="<?php echo ($a) ? $result['deadline'] : date('Y-m-d H:i:s') ?>">
                    </div>
                    <div class="item">
                        <label for="estimate" class="title">規劃時長(hrs.)</label>
                        <input type="number" name="estimate" id="estimate" max="800" min="1" value="<?php echo ($a) ? $result['estimate'] : 1 ;?>">
                    </div>
                    <div class="item">
                        <div class="title"></div>
                        <button class="btn">確定</button>
                    </div>
                </form>
            </div>
            <?php break; 
        case 'l': ?>
            <div class="titlebar">
                <?php echo (isset($_GET['a']))?'修改分類':'新增分類' ?>
            </div>
            <div class="container">
                <form action="new_category.php" method="post">
                    <div class="item">
                        <div class="title">分類名稱</div>
                        <input type="text" name="name" value="<?php echo ($a)?$result['category_name']:'' ?>">
                    </div>
                    <div class="item">
                        <div class="title">子分類</div>
                        <div class="wrap-options">
                            <?php while ($row = $category->fetch_assoc()) { ?>
                                <div class="option">
                                    <input type="radio" name="sub" id="sub_category_<?php echo $row['category_id']; ?>" <?php if($a){echo ($row['category_id'] == $result['parent_id'])?'checked':'';} ?>>
                                    <label for="sub_category_<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="item">
                        <div class="title"></div>
                        <button class="btn">確定</button>
                    </div>
                </form>
            </div>
        <?php


    } ?>
</body>
</html>


<?php



?>