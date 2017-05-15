<?php

include_once './../include/config.php';
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
    $query = "SELECT b.business_id,b.business_name,p.province_name FROM business as b,province as p WHERE b.province_id = p.province_code";
//echo $query;
    $result = mysqli_query($db, $query);
    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            $data[] = array($row[0], $row[1],$row[2]);
        }
//        $json_data = array();
//        $json_data['data'] = $data;
//        var_dump($json_data);
//        exit();
        $totaldata = mysqli_num_rows($result);
        $totalfiltered = $totaldata;
        $json_data = array(
            "draw"            => intval( $_REQUEST['draw'] ),            
            "recordsTotal"    => intval( $totaldata ),
            "recordsFiltered" => intval( $totalfiltered ),
            "data"            => $data
        );        
        echo json_encode($json_data, JSON_UNESCAPED_UNICODE);

//        var_dump($json_data);
//        exit();
//        echo json_encode($json_data);
//    var_dump(json_encode($data));
    } else {
        echo "can't query";
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