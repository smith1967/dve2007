<?php

include_once './../include/config.php';
if(!is_auth()) redirect ();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
header('Content-Type: application/json; charset=utf-8');
if (isset($_REQUEST)) {
    $school_id = trim($_REQUEST['school_id']);
//    echo $school_id.'<br>';
//die();
}
//$school_id = $_SESSION['user']['school_id'];
$user_type_id = $_SESSION['user']['user_type_id'];
if($school_id != ""){
    $query = "SELECT @c:=@c+1 as num,s.std_id,s.citizen_id,s.std_name,s.dateofbirth As dob,IF(s.sex='M','ชาย','หญิง') As sex,mi.minor_name,ma.major_name "
            . "FROM student as s " 
            . "LEFT JOIN "
            . "minor as mi "
            . "ON "
            . "s.minor_id = mi.minor_id "
            . "LEFT JOIN "
            . "major as ma "
            . "ON "
            . "s.major_id = ma.major_id "
            . "JOIN (select @c:=0) r "
            . "WHERE school_id = ".pq($school_id). " AND s.end_edu_id = 1"
            . "";
//    echo $query;
//    die();
    $result = mysqli_query($db, $query);
    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        $datax = array('data' => $data);
        echo json_encode($datax, JSON_UNESCAPED_UNICODE); 
//        echo "can't query";
    }
}
