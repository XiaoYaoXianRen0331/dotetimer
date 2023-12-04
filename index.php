<?php
require_once 'string.php';
require_once 'conn.php';

$result = $conn->query("SELECT * FROM executiontime WHERE executiontime_record != 1 ;");

$result_plan = $conn->query("SELECT * FROM executiontime WHERE executiontime_record = 1 ;");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/reset.css">
</head>
<body>
    <div class="toolbar">
        <div class="tbar">
            <a href="attr.php?m=c">查看分類</a>
        </div>
        <div class="tbar">
            <a href="attr.php?m=t">查看任務</a>
        </div>
        <div class="tbar">
            <a href="attr.php?m=l">查看標籤</a>
        </div>
        <div class="tbar">
            <a href="event.php?r=1">新增計畫</a>
        </div>
        <div class="tbar">
            <a href="event.php?r=0">新增記錄</a>
        </div>
        <div class="tbar">
            <a href="event.php?r=2">開始記錄</a>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="wrap-sbar">
                <div class="sbar">篩選</div>
                <div class="wrap-sbar-content">
                    <div class="wrap-sbar2">
                        <div class="sbar2">分類</div>
                        <div class="wrap-options">
                            <?php getCategoryTree(); ?>
                        </div>
                    </div>
                    <div class="wrap-sbar2">
                        <div class="sbar2">任務</div>
                        <div class="wrap-options">
                            <?php getTaskTree(); ?>
                        </div>
                    </div>
                    <div class="wrap-sbar2">
                        <div class="sbar2">標籤</div>
                        <div class="wrap-options">
                            <div class="andor">
                                <div class="option">
                                    <input type="radio" name="andor" id="labelor">
                                    <label for="labelor">或</label>
                                </div>
                                <div class="option">
                                    <input type="radio" name="andor" id="labeland">
                                    <label for="labelor">和</label>
                                </div>
                            </div>
                        
                            <?php getLabelTree(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-sbar">
                <div class="sbar">排序</div>
            </div>
        </div>
        <?php record($result_plan);?>
        <?php record($result);?>
    </div>



</body>

<script src="assets/js/index.js"></script>


</html>


<?php
function record($data)
{
    global $conn;?>
    <div class="block">
        <table>
            <thead>
                <tr>
                    <th>時間</th>
                    <th>持續</th>
                    <th>類別</th>
                    <th>任務</th>
                    <th>標籤</th>
                    <th>備註</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $data->fetch_assoc()) {
                $start_time = new DateTime($row['start_time']);
                $end_time = new DateTime($row['end_time']);

                $get_category_name = $conn->query("SELECT * FROM category WHERE category_id = {$row['executiontime_category_id']}")->fetch_assoc()['category_name'];
                $get_task_name = $conn->query("SELECT * FROM task WHERE task_id = {$row['executiontime_task_id']}")->fetch_assoc()['task_name'];

                $get_labels = $conn->query("
                        SELECT
                            l.label_name AS label
                        FROM
                            tasklabel tl
                        JOIN
                            label l ON l.label_id = tl.tasklabel_label_id
                        WHERE
                            tl.tasklabel_id = {$row['executiontime_id']}
                        ORDER BY 
                            l.label_id
                        ");


                ?>

                <tr class="tr">
                    <td>
                        <div class="time"><?php echo $start_time->format('n/j H:i'); ?></div>
                        <div class="time">
                        <?php if ($row['executiontime_record'] == 2) {
                            echo '執行中';
                        } else {
                            echo $end_time->format('n/j H:i');
                        }?>
                        </div>
                    </td>
                    <td>
                    <?php if ($row['executiontime_record'] == 2) {
                        echo timefmt($start_time->diff(new DateTime()));
                    } else {
                        echo timefmt($start_time->diff($end_time));
                    }?>
                    </td>
                    <td class="category"><?php echo str7($get_category_name); ?></td>
                    <td class="task"><?php echo str7($get_task_name); ?></td>
                    <td class="labels">
                        <?php foreach($get_labels as $label){
                            echo '<div class="label">' . str7($label) . '</div>';
                        } ?>
                    </td>
                    <td><?php echo str7($row['executiontime_note']); ?></td>
                    <td>
                        <a href="event.php?a=<?php echo $row['executiontime_id']; ?>">查看</a>
                        <?php if ($row['executiontime_record'] == 2) {
                            echo '<a href="finish.php?a=' . $row['executiontime_id'] . '">完成</a>';
                        }?>
                    </td>
                </tr>



            <?php
}?>

            </tbody>
        </table>
    </div>
<?php }

function str7($str)
{
    if (mb_strlen($str) > 7) {
        return mb_substr($str, 0, 7) . '...';
    } else {
        return $str;
    }
}

function timefmt($time){
    if ($time->format('%a')>1){
        return $time->format('%ad %hh %mm');
    } else if ($time->format('%h')>1){
        return $time->format('%hh %mm %ss');
    } else {
        return $time->format('%mm %ss');
    }
}


function getCategoryTree($parentId = 20, $level = 1) {
    global $conn;
    $result = $conn->query("SELECT * FROM category WHERE parent_id = \"{$parentId}\";");

    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) { 
            echo '<div class="level">';
                echo '<div class="option">';
                    echo '<input type="checkbox" class="side_category" name="category" id="category'.$row['category_id'].'">';
                    echo str_repeat('<span class="space"></span>', $level-1);
                    echo '<label for="category'.$row['category_id'].'">'.$row['category_name'].'</label>';
                echo '</div>';
                
                getCategoryTree($row['category_id'], $level + 1);
            echo '</div>';
        }
        
    }
}


function getTaskTree($parentId = 1, $level = 1) {
    global $conn;
    $result = $conn->query("SELECT * FROM task WHERE task_parent_id = \"{$parentId}\";");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="level">';
                echo '<div class="option">';
                    echo '<input type="checkbox" class="side_task" name="task" id="task'.$row['task_id'].'">';
                    echo str_repeat('<span class="space"></span>',$level-1);
                    echo '<label for="task'.$row['task_id'].'">'.$row['task_name'].'</label>';
                echo '</div>';
                getTaskTree($row['task_id'], $level + 1);
            echo '</div>';
        }
    }
}

function getLabelTree(){
    global $conn;
    $result = $conn->query("SELECT * FROM label");
    
    while ($row = $result->fetch_assoc()){
        echo '<div class="level">';
            echo '<div class="option">';
                echo '<input type="checkbox" class="side_label" name="label" id="label'.$row['label_id'].'">';
                echo '<label for="label'.$row['label_id'].'">'.$row['label_name'].'</label>';
            echo '</div>';
        echo '</div>';
    }
}









?>