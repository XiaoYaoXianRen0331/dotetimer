<?php
require_once 'string.php';
require_once 'conn.php';

// 取得記錄資料

    // $result = $conn->query("SELECT * FROM executiontime WHERE executiontime_record != 1 AND DATE(start_time) = CURDATE() ORDER BY end_time DESC;");
    $result = $conn->query("SELECT * FROM executiontime WHERE executiontime_record != 1;");

// 取得計畫資料

    // $result_plan = $conn->query("SELECT * FROM executiontime WHERE executiontime_record = 1 AND DATE(start_time) = CURDATE() ORDER BY end_time DESC;");
    $result_plan = $conn->query("SELECT * FROM executiontime WHERE executiontime_record = 1;");


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/color.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/index.css">
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
    <!-- 頂部欄 -->
    <div class="toolbar">
        <ul>
            <li>
                <div class="toolbar-item">
                    <a href="stat.php">統計分析</a>
                </div>
            </li>
            <li>
                <div class="toolbar-item">
                    <a href="attr.php">我的任務</a>
                </div>
            </li>
            <li>
                <div class="toolbar-item">
                    <a href="attr.php">選項管理</a>
                </div>
            </li>
            <li>
                <div class="toolbar-item">
                    <a href="event.php?r=1">新增計畫</a>
                </div>
            </li>
            <li>
                <div class="toolbar-item">
                    <a href="event.php?r=0">新增記錄</a>
                </div>
            </li>
            <li>
                <div class="toolbar-item">
                    <a href="event.php?r=2">開始記錄</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="container">
        <!-- 側邊欄 -->
        <div class="sidebar">
            <div class="wrap-sbar">
                <div class="select-date">
                    <input type="date" name="date" id="date" value="<?php echo (new Datetime())->format('Y-m-d'); ?>">
                </div>
            </div>
            <div class="wrap-sbar">
                <div class="sbar">
                    <div class="hover">篩選</div>
                </div>
                <div class="wrap-sbar-content">
                    <div class="wrap-sbar2">
                        <div class="sbar2">分類</div>
                        <div class="wrap-options">
                            <?php getCategory(); ?>
                        </div>
                    </div>
                    <div class="wrap-sbar2">
                        <div class="sbar2">任務</div>
                        <div class="wrap-options">
                            <?php getTask(); ?>
                        </div>
                    </div>
                    <div class="wrap-sbar2">
                        <div class="sbar2">標籤</div>
                        <div class="wrap-options">
                            <div class="andor">
                                <div class="option">
                                    <input type="radio" name="andor" id="labelor" checked>
                                    <label for="labelor">或</label>
                                </div>
                                <div class="option">
                                    <input type="radio" name="andor" id="labeland">
                                    <label for="labeland">和</label>
                                </div>
                            </div>
                        
                            <?php getLabelTree(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-sbar">
                <div class="sbar">
                    <div class="hover">排序</div>
                </div>
                <div class="wrap-sbar-content">
                    <div class="wrap-sbar2">
                        <div class="sort" id="start-time">開始時間</div>
                    </div>
                    <div class="wrap-sbar2">
                        <div class="sort" id="end-time">結束時間</div>
                    </div>
                    <div class="wrap-sbar2">
                        <div class="sort" id="time-lasting">持續時間</div>
                    </div>
                    <div class="wrap-sbar2">
                        <div class="sort" id="category">分類</div>
                    </div>
                    <div class="wrap-sbar2">
                        <div class="sort" id="task">任務</div>
                    </div>

                </div>
            </div>
            <div class="wrap-sbar">
                <div class="sbar">
                    <div class="hover">搜尋</div>
                </div>
                <div class="wrap-sbar-content">

                </div>
            </div>
        </div>
        <div class="block" id="plan-block">
            <div class="go" id="go-record">前往記錄</div>
            <table>
                <thead>
                    <tr>
                        <th class="th-time">時間</th>
                        <th class="th-last">持續</th>
                        <th class="th-category">類別</th>
                        <th class="th-task">任務</th>
                        <th>標籤</th>
                        <th>備註</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="plan-tbody">
                
                    <?php record($result_plan);?>
                </tbody>
            </table>
        </div>
        
        <div class="block" id="record-block">
            <div class="go" id="go-plan">前往計畫</div>
            <table>
                <thead>
                    <tr>
                        <th class="th-time">時間</th>
                        <th class="th-last">持續</th>
                        <th class="th-category">類別</th>
                        <th class=""th-task>任務</th>
                        <th>標籤</th>
                        <th>備註</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="record-tbody">
                    <?php record($result);?>
                </tbody>
            </table>
        </div>
    </div>



</body>

<script src="assets/js/index.js"></script>
<script src="assets/js/reset.js"></script>

<script>

    
</script>

</html>


<?php
// 顯示資料表格
function record($data)
{
    global $conn;
    
    while ($row = $data->fetch_assoc()) {
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
                    tl.tasklabel_executiontime_id = {$row['executiontime_id']}
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
                <?php if($get_labels->num_rows > 0) {
                    while($get_label = $get_labels->fetch_assoc()) {
                        echo '<div class="label">' . str7($get_label['label']) . '</div>';
                    }
                } ?>
            </td>
            <td><?php echo str7($row['executiontime_note'], 14); ?></td>
            <td>
                <a href="event.php?a=<?php echo $row['executiontime_id']; ?>">查看</a>
                <?php if ($row['executiontime_record'] == 2) {
                    echo '<a href="finish.php?a=' . $row['executiontime_id'] . '">完成</a>';
                }?>
            </td>
        </tr>



    
    <?php }

}




// 側邊欄篩選
function getCategory() {
    global $category_sorted;
    $tag = 0;

    foreach ($category_sorted as $key => $row) { ?>
        <div class="level">
            <div class="option">
                <input type="checkbox" class="side_category" name="category" id="category<?php echo $row['row']['category_id']; ?>">
                <?php echo str_repeat('<span class="space"></span>', $row['level']); ?>
                <label for="category<?php echo $row['row']['category_id'] ?>"><?php echo $row['row']['category_name'] ?></label>
            </div>
        <?php
        if($key+1 < count($category_sorted)){
            $sub = $category_sorted[$key+1]['level'] - $tag;
            if($sub == 0) {
                echo '</div>';
            } else{ 
                $tag += $sub;
                if($sub < 0) {
                    echo str_repeat('</div>', abs($sub) + 1);
                }
            }
        }
    }            
    echo str_repeat('</div>', $tag + 1);

    unset($key);
    unset($row);
        
} 

function getTask() {
    global $task_sorted;
    $tag = 0;

    foreach ($task_sorted as $key => $row) { ?>
        <div class="level">
            <div class="option">
                <input type="checkbox" class="side_task" name="task" id="task<?php echo $row['row']['task_id']; ?>">
                <?php echo str_repeat('<span class="space"></span>',$row['level']); ?>
                <label for="task<?php echo $row['row']['task_id']; ?>"><?php echo $row['row']['task_name']; ?></label>
            </div>
        <?php
        if($key+1 < count($task_sorted)){
            $sub = $task_sorted[$key+1]['level'] - $tag;
            if($sub == 0) {
                echo '</div>';
            } else{ 
                $tag += $sub;
                if($sub < 0) {
                    echo str_repeat('</div>', abs($sub) + 1);
                }
            }
        }
    }            
    echo str_repeat('</div>', $tag + 1);

    unset($key);
    unset($row);
            
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