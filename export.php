<?php
    session_start();
    require_once 'config/config.php';
    require_once 'class/TelegramBot.php';

    //  session management
    if (!isset($_SESSION['session_user_id'])) {
        header('Location: login.php');
        exit();
    }

    $uid = $_SESSION['session_user_id'];

    switch(strtolower($_GET['type'])) {
        case 'excel' :
            exportToExcel($db, $uid);
            break;

        case 'sql' :
            exportToSQL($db, $uid);
            break;
    }


    function exportToSQL($db, $uid) {
    }

    function exportToExcel($db, $uid) {
        $filename = "database.xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $user_query = $db->query("SELECT * FROM t_manager WHERE m_userid='$uid'")->fetchAll();
        $flag = false;
        foreach($user_query as $row) {
            if(!$flag) { 
                echo implode("\t", array_keys($row)) . "\r\n"; 
                $flag = true; 
            }  
            array_walk($row, 'filterData'); 
            echo implode("\t", array_values($row)) . "\r\n"; 
        }

    }

    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }
?>