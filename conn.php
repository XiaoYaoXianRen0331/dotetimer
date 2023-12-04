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

?>