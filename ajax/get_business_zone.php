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
    $zone_id = trim($_REQUEST['zone_id']);
//    echo $school_id.'<br>';
//die();
}
    $query = "SELECT b.business_id,b.business_name,p.province_name,COUNT(t.trainer_id) AS trainers FROM business as b LEFT JOIN province as p ON b.province_id = p.province_code LEFT JOIN trainer AS t ON b.business_id = t.business_id WHERE p.zone_id = ".pq($zone_id)." GROUP BY b.business_id ORDER BY `b`.`business_id` ASC";
//echo $query;
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
        $i=0;
        if($_SESSION['user']['user_type_id'] == '1'){                
            foreach ($data as $key) {
                $data[$i]['button'] = '<a href="'.site_url('app/business/list') . '&action=delete&business_id=' . $data[$i]['business_id'].'" class="btn btn-danger btn-sm delete" onclick="return confirm(\'ยืนยันการลบข้อมูล?\');">  <i class="fa fa-remove"></i></a> |
                                            <a href="'.site_url('app/business/edit') . '&action=edit&business_id=' . $data[$i]['business_id'].'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
                $i++;
            }       
        }else{
            foreach ($data as $key) {
                $data[$i]['button'] = '<a href="'.site_url('app/business/edit') . '&action=edit&business_id=' . $data[$i]['business_id'].'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
                $i++;
            }     
        }
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