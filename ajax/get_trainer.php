<?php

include_once './../include/config.php';
//if(!is_auth()) redirect ();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
header('Content-Type: application/json; charset=utf-8');
////if (isset($_REQUEST)) {
////    $search_str = '%' . trim($_REQUEST['term']) . '%';
////echo $search_str.'<br>';
////die();
//    $query = "SELECT b.business_id,b.business_name,p.province_name FROM business as b LEFT JOIN province as p ON b.province_id = p.province_code";
////echo $query;
//    $result = mysqli_query($db, $query);
//    if ($result) {
//        $data = array();
//        while ($row = mysqli_fetch_assoc($result)) {
//            $data[] = $row;
//        }
////        $json_data = array();
////        $json_data['data'] = $data;
////        var_dump($json_data);
////        exit();
//        $i=0;
//        foreach ($data as $key) {
//            $data[$i]['button'] = '<a href="'.site_url('app/business/list') . '&action=delete&business_id=' . $data[$i]['business_id'].'" class="btn btn-danger btn-sm delete"><i class="fa fa-remove"></i></a> |
//                                        <a href="'.site_url('app/business/edit') . '&action=edit&business_id=' . $data[$i]['business_id'].'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
//            $i++;
//        }
//        $datax = array('data' => $data);
//        echo json_encode($datax, JSON_UNESCAPED_UNICODE);       
////        echo json_encode($json_data, JSON_UNESCAPED_UNICODE);
//
////        var_dump($json_data);
////        exit();
////        echo json_encode($json_data);
////    var_dump(json_encode($data));
//    } else {
//        echo "can't query";
//    }
$search = strip_tags(trim($_GET['q'])); 
//$search = '%'.$search.'%';
// Do Prepared Query 
$query = "SELECT trainer_id AS id,trainer_name AS name FROM trainer";
//WHERE business_id = ".pq($search);
        //$smnt->prepare("SELECT productId,productName FROM products WHERE productName LIKE :search LIMIT 40");

// Add a wildcard search to the search variable
//$query->execute(array(':search'=>"%".$search."%"));

// Do a quick fetchall on the results
$result = mysqli_query($db, $query);
//var_dump($result);
//$data = array();
//if (mysqli_num_rows($result)>0) {
//    while ($row = mysqli_fetch_assoc($result)) {
//        $data[] = $row;
//    }
//}else{
//    $data[] = array('id' => '0', 'name' => 'ไม่พบข้อมูลครูฝึก');        
//}
////var_dump($data);
//echo json_encode($data, JSON_UNESCAPED_UNICODE);
    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
//        $json_data = array();
//        $json_data['data'] = $data;
//        var_dump($json_data);
//        exit();
        $i=0;
        foreach ($data as $key) {
            $data[$i]['button'] = '<a href="'.site_url('app/trainer/list') . '&action=delete&trainer_id=' . $data[$i]['trainer_id'].'" class="btn btn-danger btn-sm delete"><i class="fa fa-remove"></i></a> |
                                        <a href="'.site_url('app/trainer/edit') . '&action=edit&trainer_id=' . $data[$i]['trainer_id'].'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
            $i++;
        }
        $datax = array('data' => $data);
        echo json_encode($datax, JSON_UNESCAPED_UNICODE);   
    }