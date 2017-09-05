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
//$search = strip_tags(trim($_GET['q']));
//$search = '%'.$search.'%';
// Do Prepared Query 
$query = "SELECT trainer_id AS id,trainer_name AS name FROM trainer";
$result = mysqli_query($db, $query);

if ($result) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    $i = 0;
    foreach ($data as $key) {
        $data[$i]['button'] = '<a href="' . site_url('app/trainer/list') . '&action=delete&trainer_id=' . $data[$i]['trainer_id'] . '" class="btn btn-danger btn-sm delete"><i class="fa fa-remove"></i></a> |
                                        <a href="' . site_url('app/trainer/edit') . '&action=edit&trainer_id=' . $data[$i]['trainer_id'] . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
        $i++;
    }
    $datax = array('data' => $data);
    echo json_encode($datax, JSON_UNESCAPED_UNICODE);
}