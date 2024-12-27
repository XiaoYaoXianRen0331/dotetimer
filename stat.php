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
    <link rel="stylesheet" href="assets/css/stat.css">
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
    <div class="titlebar">
        <div class="title">統計數據</div>
    </div>
    <div class="toolbar">
        <div class="toolbar-item">日常</div>
        <div class="toolbar-item">分析</div>
    </div>
    <div class="container active" id="routine">
        <!-- 照順序排 -->
        <div class="wrap-duration">
            <?php 
            $tag = 0;
            $data = [];
            $temp = [];
            $total_duration = [new DateTime('00:00')];
            $index = 0;
            $index_temp = [0];
            foreach($category_sorted as $item){
                $sub = $item['level'] - $tag;
                if($sub > 0) {
                    $index++;
                    array_push($index_temp, $index);
                    $total_duration[$index] = new DateTime('00:00');
                } else {
                    for($i = 0; $i <= abs($sub); $i++) {
                        array_pop($temp);
                    }
                    if($sub < 0) {
                        for($i = 0; $i < abs($sub); $i++) {
                            array_pop($index_temp);
                        }
                    }
                }
                $tag = $item['level'];


                $duration = new DateTime('00:00');
                $event = [];
                $select = select('executiontime', 'YEAR(start_time) = YEAR(CURDATE()) 
                AND MONTH(start_time) = MONTH(CURDATE()) 
                AND executiontime_record != 1 
                AND executiontime_category_id = ' . $item['row']['category_id']);

                while ($row = $select->fetch_assoc()) {
                    $start_time = new DateTime($row['start_time']);
                    $end_time = new DateTime($row['end_time']);
                    $duration->add($start_time->diff($end_time));
                    array_push($event, $row['executiontime_id']);
                }
                $data[$item['row']['category_name']] = ['duration' => $duration, 'level' => $tag, 'index' => end($index_temp)];
                foreach ($temp as $t) {
                    $data[$t]['duration']->add(toInterval($duration));
                }
                array_push($temp, $item['row']['category_name']);
                foreach ($index_temp as $t) {
                    $total_duration[$t]->add(toInterval($duration));
                }
            }
            foreach($data as $key => $item){ //echo percentage($item['duration']);?>
            <div class="wrap-duration-item">
                <?php echo str_repeat('<div class="space"></div>', $item['level']); ?>
                <div class="duration-name"><?php echo $key; ?></div>
                <div class="duration"><div class="duration-after"></div></div>
                <div class="duration-time"><?php echo timefmt(toInterval($item['duration'])); ?></div>
                <div class="duration-percentage"><?php echo percentage($item['duration'], $total_duration[$item['index']]) . '%'; ?></div>
            </div>
            <?php } ?>
        </div>
        <div class="wrap-freq">
            <div class="freq"></div>
            <div class="freq"></div>
            <div class="freq"></div>
        </div>
    </div>
    <div class="container" id="analyze">
        <div class="wrap-duration">
            <div class="duration"></div>
            <div class="duration"></div>
            <div class="duration"></div>
        </div>
        <div class="wrap-freq">
            <div class="freq"></div>
            <div class="freq"></div>
            <div class="freq"></div>
        </div>
    </div>
</body>
<script src="assets/js/stat.js"></script>
</html>

<?php
function percentage($time, $total) {
    $total = toSecond(toInterval($total));
    $time = toSecond(toInterval($time));
    $percent = ($total == 0) ? 0 : ($time / $total) * 100;
    if($percent != 0) {
        $percent = number_format($percent, 2, '.', '');
    }
    return $percent;
}

function toInterval($time) {
    $newDate = new DateTime('00:00');
    $interval = $newDate->diff($time);
    return $interval;
}

function toSecond($time) {
    $second = $time->format('%a') * 86400 + $time->format('%h') * 3600 + $time->format('%i') * 60 + $time->format('%s');
    return $second;
}


?>