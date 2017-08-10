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
if (isset($_GET)) {
    $search_str = '%' . strip_tags($_GET['term']) . '%';
    $school_id = strip_tags($_SESSION['user']['school_id']);
//echo $search_str.'<br>';
//die();
    $query = "SELECT citizen_id as value,std_name as label FROM student "
            . "WHERE school_id = " . pq($school_id) 
            . " AND std_name LIKE " . pq($search_str) 
            . " AND end_edu_id = 1 " 
            . " OR std_id LIKE " . pq($search_str);
// echo $query;
    $result = mysqli_query($db, $query);
    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
//    var_dump(json_encode($data));
    } else {
        echo "can't query";
    }
}
//$data = array(
//    array(
//      'id'=>1,
//    'name'=>'test'  
//    ),
//        array(
//      'id'=>2,
//    'name'=>'test2'  
//    ),
//);
//echo json_encode($data);