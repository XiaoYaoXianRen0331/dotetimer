<?php
require_once 'string.php';
require_once 'conn.php';

if (isset($_GET['a'])) {
    $result = $conn->query("SELECT * FROM $table_executiontime WHERE executiontime_id = {$_GET['a']}")->fetch_assoc();
    $result_tasklabel = $conn->query("SELECT * FROM $table_tasklabel WHERE tasklabel_id = {$_GET['a']}");
    $item_label = [];
    while ($row = $result_tasklabel->fetch_assoc()) {
        $item_label[] = $row['tasklabel_label_id'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/color.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/event.css">
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


    <div class="titlebar">
        <?php if (isset($_GET['a'])){
            echo '#事件' . $_GET['a'];
        } else {
            switch ($_GET['r']) {
                case 0:
                    echo '記錄事件';
                    break;
                case 1:
                    echo '規劃行程';
                    break;
                case 2:
                    echo '開始記錄';
            }
        } ?>
    </div>

    <div class="container">

        <!-- 新增資料 -->
        <?php if (isset($_GET['r'])) { ?>
            <form action="new.php?r=<?php echo $_GET['r'] ?>" method="post">
                <?php if ($_GET['r'] != 2) {?>
                <div class="item">
                    <label for="start" class="title">開始時間</label>
                    <input type="datetime-local" name="start" id="start" value="<?php echo date('Y-m-d H:i:s') ?>">
                </div>
                <div class="item">
                    <label for="end" class="title">結束時間</label>
                    <input type="datetime-local" name="end" id="end" value="<?php echo date('Y-m-d H:i:s') ?>">
                </div>
                <?php }?>
                <div class="item">
                    <div class="title">分類</div>
                    <div class="wrap-options">
                        <?php $select = select('category');
                        while ($row = $select->fetch_assoc()) { 
                            if ($row['category_id'] !=20){ ?>
                                <div class="option">
                                    <input type="radio" name="category" id="category_<?php echo $row['category_id']; ?>" value="<?php echo $row['category_id']; ?>" 
                                    <?php echo ($row['category_id'] == 19) ? 'checked' : ''; ?>
                                    >
                                    <label for="category_<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></label>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
                <div class="item">
                    <div class="title">任務</div>
                    <div class="wrap-options">
                        <?php $select = select('task');
                        while ($row = $select->fetch_assoc()) {?>
                            <div class="option">
                                <input type="radio" name="task" id="task_<?php echo $row['task_id']; ?>" value="<?php echo $row['task_id']; ?>" 
                                <?php echo ($row['task_id'] == 1) ? 'checked' : ''; ?>
                                >
                                <label for="task_<?php echo $row['task_id']; ?>"><?php echo $row['task_name']; ?></label>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <div class="item">
                    <div class="title">標籤</div>
                    <div class="wrap-options">
                        <?php $select = select('label');
                        while ($row = $select->fetch_assoc()) {?>
                            <div class="option">
                                <input type="checkbox" name="label[]" id="label_<?php echo $row['label_id']; ?>" value="<?php echo $row['label_id']; ?>"> <!--php-->
                                <label for="label_<?php echo $row['label_id']; ?>"><?php echo $row['label_name']; ?></label>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <div class="item">
                    <label for="note" class="title">備註</label>
                    <textarea name="note" id="note" cols="30" rows="10"></textarea>
                </div>
                <div class="item">
                    <button class="btn">新增</button>
                </div>
            </form>

        <?php } else { ?>

            <!-- 修改資料 -->
            <form action="edit.php?a=<?php echo $_GET['a']; ?>" method="post">
                <div class="item">
                    <label for="start" class="title">開始時間</label>
                    <input type="datetime-local" name="start" id="start" value="<?php echo $result['start_time']; ?>">
                </div>
                <div class="item" <?php if ($result['executiontime_record'] == 2) { echo 'style="display: none;"'; }?>>
                        <label for="end" class="title">結束時間</label>
                        <input type="datetime-local" name="end" id="end" value="<?php echo $result['end_time']; ?>">
                </div>
                <div class="item">
                    <div class="title">分類</div>
                    <div class="wrap-options">
                    <?php $select = select('category');
                    while ($row = $select->fetch_assoc()) {
                        if ($row['category_id'] !=20){ ?>
                            <div class="option">
                                <input type="radio" name="category" id="category_<?php echo $row['category_id']; ?>" value="<?php echo $row['category_id']; ?>" <?php echo ($result['executiontime_category_id'] == $row['category_id']) ? 'checked' : ''; ?>> <!--php-->
                                <label for="category_<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></label>
                            </div>
                        <?php }
                    } ?>
                    </div>
                </div>
                <div class="item">
                    <div class="title">任務</div>
                    <div class="wrap-options">
                    <?php $select = select('task');
                    while ($row = $select->fetch_assoc()) {?>
                        <div class="option">
                            <input type="radio" name="task" id="task_<?php echo $row['task_id']; ?>" value="<?php echo $row['task_id']; ?>" <?php echo ($result['executiontime_task_id'] == $row['task_id']) ? 'checked' : ''; ?>> <!--php-->
                            <label for="task_<?php echo $row['task_id']; ?>"><?php echo $row['task_name']; ?></label>
                        </div>
                    <?php }?>
                    </div>
                </div>
                <div class="item">
                    <div class="title">標籤</div>
                    <div class="wrap-options">
                    <?php $select = select('label');
                    while ($row = $select->fetch_assoc()) {?>
                        <div class="option">
                            <input type="checkbox" name="label[]" id="label_<?php echo $row['label_id']; ?>" value="<?php echo $row['label_id']; ?>"
                                <?php echo in_array($row['label_id'], $item_label) ? "checked" : "";
        ?>> <!--php-->
                            <label for="label_<?php echo $row['label_id']; ?>"><?php echo $row['label_name']; ?></label>
                        </div>
                    <?php }?>
                    </div>
                </div>
                <div class="item">
                    <label for="note" class="title">備註</label>
                    <textarea name="note" id="note" cols="30" rows="10"></textarea>
                </div>
                <div class="item">
                    <div class="title"></div>
                    <button class="btn">修改</button>
                    <?php if ($result['executiontime_record'] == 2) {?>
                        <a class="btn" href="finish.php?a=<?php echo $_GET['a']; ?>">完成</a>
                    <?php }?>
                    <a href="del.php?a=<?php echo $_GET['a']; ?>" class="btn">刪除</a>
                </div>
            </form>
        <?php } ?>
    </div>
</body>
</html>