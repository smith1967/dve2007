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
//if (isset($_REQUEST)) {
//    $search_str = '%' . trim($_REQUEST['term']) . '%';
//echo $search_str.'<br>';
//die();
$school_id = $_SESSION['user']['school_id'];
$user_type_id = $_SESSION['user']['user_type_id'];
if($user_type_id==4){
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
//        $json_data = array();
//        $json_data['data'] = $data;
//        var_dump($json_data);
//        exit();
//        $i=0;
//        foreach ($data as $key) {
//            $data[$i]['button'] = '<a href="'.site_url('app/business/list') . '&action=delete&business_id=' . $data[$i]['business_id'].'" class="btn btn-danger btn-sm delete"><i class="fa fa-remove"></i></a> |
//                                        <a href="'.site_url('app/business/edit') . '&action=edit&business_id=' . $data[$i]['business_id'].'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
//            $i++;
//        }
        $datax = array('data' => $data);
        echo json_encode($datax, JSON_UNESCAPED_UNICODE); 
       
//        echo json_encode($json_data, JSON_UNESCAPED_UNICODE);

//        var_dump($json_data);
//        exit();
//        echo json_encode($json_data);
//    var_dump(json_encode($data));
    } else {
        echo "can't query";
    }
}else{
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
            . "WHERE s.end_edu_id = 1"
            . "";
//    echo $query;
//    die();
    $result = mysqli_query($db, $query);
    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
//        $json_data = array();
//        $json_data['data'] = $data;
//        var_dump($json_data);
//        exit();
//        $i=0;
//        foreach ($data as $key) {
//            $data[$i]['button'] = '<a href="'.site_url('app/business/list') . '&action=delete&business_id=' . $data[$i]['business_id'].'" class="btn btn-danger btn-sm delete"><i class="fa fa-remove"></i></a> |
//                                        <a href="'.site_url('app/business/edit') . '&action=edit&business_id=' . $data[$i]['business_id'].'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
//            $i++;
//        }
        $datax = array('data' => $data);
        echo json_encode($datax, JSON_UNESCAPED_UNICODE); 
       
//        echo json_encode($json_data, JSON_UNESCAPED_UNICODE);

//        var_dump($json_data);
//        exit();
//        echo json_encode($json_data);
//    var_dump(json_encode($data));
    } else {
        echo "can't query";
    }

}
//}
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