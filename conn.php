<?php
try {
    if(!($conn = new mysqli('localhost', 'xiaoyao', 'xiaoyao', 'dotetimer'))) {
        die('Failed to connect to dotetimer server: ' . $conn->connect_error);
    }
} catch (Exception $e) {
    die('Connection failed: ' . $e->getMessage());
}

$conn->query('SET NAMES UTF8'); //設定編碼
$conn->query('SET time_zone = "+8:00"'); //設定時區

date_default_timezone_set('Asia/Taipei');

$category_sorted = [];
$task_sorted = [];

getCategoryTree();
getTaskTree();

function getCategoryTree($parentId = 20, $level = 0) {
    global $conn, $category_sorted, $task_sorted;
    $result = $conn->query("SELECT * FROM category WHERE parent_id = \"{$parentId}\";");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            array_push($category_sorted, ["row"=>$row, "level"=>$level]);
            getCategoryTree($row['category_id'], $level + 1);
        }
    }
}

function getTaskTree($parentId = 1, $level = 0) {
    global $conn, $category_sorted, $task_sorted;
    $result = $conn->query("SELECT * FROM task WHERE task_parent_id = \"{$parentId}\";");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($task_sorted, ["row"=>$row, "level"=>$level]);
            getTaskTree($row['task_id'], $level + 1);
        }
    }
}

function select($from, $where = '', $order = '') {
    global $conn;

    if($where != '') { $where = 'WHERE '.$where; }
    if($order != '') { $order = 'ORDER BY '.$order; }
    $result = $conn->query("SELECT * FROM {$from} {$where} {$order}");
    return $result;
}

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


?>