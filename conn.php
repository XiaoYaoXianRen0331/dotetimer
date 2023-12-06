<?php
$conn = new mysqli('localhost', 'xiaoyao', 'xiaoyao', 'dotetimer');

if ($conn->connect_error) {
    die('Connection failed.</br>$conn->connect_error');
}

$conn->query('SET NAMES UTF8'); //設定編碼
$conn->query('SET time_zone = "+8:00"'); //設定時區

$category = $conn->query("SELECT * FROM $table_category");
$task = $conn->query("SELECT * FROM $table_task");
$label = $conn->query("SELECT * FROM $table_label");

date_default_timezone_set('Asia/Taipei');

$category_sorted = [];
$task_sorted = [];

getCategoryTree();
getTaskTree();

function getCategoryTree($parentId = 20, $level = 1) {
    global $conn, $category_sorted, $task_sorted;
    $result = $conn->query("SELECT * FROM category WHERE parent_id = \"{$parentId}\";");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            array_push($category_sorted, ["row"=>$row, "level"=>$level]);
            getCategoryTree($row['category_id'], $level + 1);
        }
    }
}

function getTaskTree($parentId = 1, $level = 1) {
    global $conn, $category_sorted, $task_sorted;
    $result = $conn->query("SELECT * FROM task WHERE task_parent_id = \"{$parentId}\";");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($task_sorted, ["row"=>$row, "level"=>$level]);
            getTaskTree($row['task_id'], $level + 1);
        }
    }
}
?>