<?php
    require_once 'string.php';
    require_once 'conn.php';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增資料</title>
    <link rel="stylesheet" href="reset.css">
</head>
<body>
    <?php switch ($_GET['m']) {
        case 'e': ?>
            <div class="titlebar">
            <?php switch ($_GET['r']) {
                case 0:
                    echo '記錄';
                    break;
                case 1:
                    echo '計畫';
                    break;
                case 2:
                    echo '開始';
            } ?>
            </div>
            <form action="newp.php?r=<?php echo $_GET['r'] ?>" method="post">
                <?php if ($_GET['r'] != 2 ) { ?>
                <div class="item">
                    <label for="start" class="title">開始時間</label>
                    <input type="datetime-local" name="start" id="start" value="<?php echo date('Y-m-d H:i:s') ?>">
                </div>
                <div class="item">
                    <label for="end" class="title">結束時間</label>
                    <input type="datetime-local" name="end" id="end" value="<?php echo date('Y-m-d H:i:s') ?>">
                </div>
                <?php } ?>
                <div class="item">
                    <div class="title">分類</div>
                    <div class="btn">清除</div>
                    <?php while ($row = $category -> fetch_assoc()) { ?>
                        <input type="radio" name="category" id="category_<?php echo $row['category_id']; ?>" value="<?php echo $row['category_id']; ?>"> <!--php-->
                        <label for="category_<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></label>
                    <?php } ?>
                </div>
                <div class="item">
                    <div class="title">任務</div>
                    <div class="btn">清除</div>
                    <?php while ($row = $task -> fetch_assoc()) { ?>
                        <input type="radio" name="task" id="task_<?php echo $row['task_id']; ?>" value="<?php echo $row['task_id']; ?>"> <!--php-->
                        <label for="task_<?php echo $row['task_id']; ?>"><?php echo $row['task_name']; ?></label>
                    <?php } ?>
                </div>
                <div class="item">
                    <div class="title">標籤</div>
                    <?php while ($row = $label -> fetch_assoc()) { ?>
                        <input type="checkbox" name="label[]" id="label_<?php echo $row['label_id']; ?>" value="<?php echo $row['label_id']; ?>"> <!--php-->
                        <label for="label_<?php echo $row['label_id']; ?>"><?php echo $row['label_name']; ?></label>
                    <?php } ?>
                </div>
                <div class="item">
                    <label for="note" class="title">備註</label>
                    <textarea name="note" id="note" cols="30" rows="10"></textarea>
                </div>
                <input type="submit" value="送出">
            </form>
            <?php break;





        case 'c': ?>
            <div class="block">
                <div class="title1">新增分類</div>
                <form action="new_category.php" method="post">
                    <div class="item">
                        <label for="name">分類名稱</label>
                        <input type="text" id="name">
                    </div>
                    <div class="title2">子分類</div>
                    <div class="btn">清除</div>
                    <div class="item">
                        <?php while ($row = $category->fetch_assoc()) {
                            echo '<input type="radio" name="sub" id="' . $row['category_id'] . '">';
                            echo '<label for="' . $row['category_id'] . '">' . $row['category_name'] . '</label>';
                        }
                        ?>
                    </div>
                    <input type="submit" value="送出">
                </form>
            </div>


            <?php break;
        case 't': ?>
            <div class="block">
                <div class="title1">新增任務</div>
                <form action="new_category.php" method="post">
                    <div class="item">
                        <label for="name">任務名稱</label>
                        <input type="text" id="name">
                    </div>
                    <div class="title2">子任務</div>
                    <div class="item">
                        <?php while ($row = $task->fetch_assoc()) {
                            echo '<input type="radio" name="sub" id="' . $row['task_id'] . '">';
                            echo '<label for="' . $row['task_id'] . '">' . $row['task_name'] . '</label>';
                        }
                        ?>
                    </div>
                    <div class="title2">分類</div>
                    <div class="item">
                        <?php while ($row = $category->fetch_assoc()) {
                            echo '<input type="radio" name="sub" id="' . $row['category_id'] . '">';
                            echo '<label for="' . $row['category_id'] . '">' . $row['category_name'] . '</label>';
                        }
                        ?>
                    </div>
                    <input type="submit" value="送出">
                </form>
            </div>


    <?php } ?>
</body>
</html>