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
$user_type_id=$_SESSION['user']['user_type_id'];
    if ($user_type_id==4){
        $query = "SELECT @c:=@c+1 as num, m.mou_id,s.`school_name`,b.`business_name`,m.`mou_date` "
                ."FROM `mou` m "
                ."join business b ON b. `business_id`=m.`business_id` "
                ."join school s ON s.`school_id`=m.`school_id` "
                ."join (select @c:=0) r "
                ."WHERE s.school_id=".pq($school_id).""
                ."ORDER by m.`school_id` ";
    }else{
         $query = "SELECT @c:=@c+1 as num, m.mou_id,s.`school_name`,b.`business_name`,m.`mou_date` "
                ."FROM `mou` m "
                ."join business b ON b. `business_id`=m.`business_id` "
                ."join school s ON s.`school_id`=m.`school_id` "
                ."join (select @c:=0) r "
                ."ORDER by m.`school_id` ";
    }
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
        foreach ($data as $key) {
            $data[$i]['button'] = '<a href="'.site_url('app/mou/list') . '&action=delete&mou_id=' . $data[$i]['mou_id'].'" class="btn btn-danger btn-sm delete"><i class="fa fa-remove"></i></a> |
                                        <a href="'.site_url('app/mou/edit') . '&action=edit&mou_id=' . $data[$i]['mou_id'].'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
            $i++;
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