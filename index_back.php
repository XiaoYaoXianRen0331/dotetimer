<?php
require_once 'conn.php';

$result = $conn->query("
    SELECT * FROM executiontime 
    WHERE executiontime_record != 1 
    ORDER BY {$_POST['order']};
");

$result_plan = $conn->query("
    SELECT * FROM executiontime 
    WHERE executiontime_record = 1 
    ORDER BY {$_POST['order']};
");

$plan_innerHTML = '';
$record_innerHTML = '';

while ($row = $result_plan->fetch_assoc()) {
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



    $plan_item='
    <tr class="tr">
        <td>
            <div class="time">' . $start_time->format('n/j H:i') . '</div>
            <div class="time">' .
            (($row['executiontime_record'] == 2) ? '執行中' : $end_time->format('n/j H:i')) .
            '</div>
        </td>
        <td>' .
        (($row['executiontime_record'] == 2) ? timefmt($start_time->diff(new DateTime())) : timefmt($start_time->diff($end_time))) .
        '</td>
        <td class="category">' . str7($get_category_name) . '</td>
        <td class="task">' .str7($get_task_name) . '</td>
        <td class="labels">';
            if($get_labels->num_rows > 0) {
                while($get_label = $get_labels->fetch_assoc()) {
                    $plan_item .= '<div class="label">' . str7($get_label['label']) . '</div>';
                }
            }
    $plan_item .=
        '</td>
        <td>' . str7($row['executiontime_note'], 14) . '</td>
        <td>
            <a href="event.php?a=' . $row['executiontime_id'] . '">查看</a>
        </td>
    </tr>
    ';

    $plan_innerHTML .= $plan_item;

}

while ($row = $result->fetch_assoc()) {
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



    $record_item='
    <tr class="tr">
        <td>
            <div class="time">' . $start_time->format('n/j H:i') . '</div>
            <div class="time">' .
            (($row['executiontime_record'] == 2) ? '執行中' : $end_time->format('n/j H:i')) .
            '</div>
        </td>
        <td>' .
        (($row['executiontime_record'] == 2) ? timefmt($start_time->diff(new DateTime())) : timefmt($start_time->diff($end_time))) .
        '</td>
        <td class="category">' . str7($get_category_name) . '</td>
        <td class="task">' .str7($get_task_name) . '</td>
        <td class="labels">';
            if($get_labels->num_rows > 0) {
                while($get_label = $get_labels->fetch_assoc()) {
                    $record_item .= '<div class="label">' . str7($get_label['label']) . '</div>';
                }
            }
    $record_item .=
        '</td>
        <td>' . str7($row['executiontime_note'], 14) . '</td>
        <td>
            <a href="event.php?a=' . $row['executiontime_id'] . '">查看</a>'.
            (($row['executiontime_record'] == 2) ? 
            '<a href="finish.php?a=' . $row['executiontime_id'] . '">完成</a>' : '') .
        '</td>
    </tr>
    ';

    $record_innerHTML .= $record_item;

}

$responseData = $plan_innerHTML . '|' . $record_innerHTML;

echo $responseData;

// $responseData = array(
//     "plan" => $plan_innerHTML,
//     "record" => $record_innerHTML
// );

// $jsonResponse = json_encode($responseData);

// header('Content-Type: application/json');

// echo $jsonResponse;

// 裁切字串
function str7($str, $num=7)
{
    if (mb_strlen($str) > $num) {
        return mb_substr($str, 0, $num) . '...';
    } else {
        return $str;
    }
}

// 格式化時間
function timefmt($time){
    if ($time->format('%a')>0){
        return $time->format('%ad %hh %mm');
    } else if ($time->format('%h')>0){
        return $time->format('%hh %im %ss');
    } else {
        return $time->format('%im %ss');
    }
}