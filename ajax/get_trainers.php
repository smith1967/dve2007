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

$search = strip_tags(trim($_GET['q'])); 
//$search = '%'.$search.'%';
// Do Prepared Query 
$query = "SELECT trainer_id AS id,trainer_name AS name FROM trainer WHERE business_id=".pq($search);
//WHERE business_id = ".pq($search);
        //$smnt->prepare("SELECT productId,productName FROM products WHERE productName LIKE :search LIMIT 40");

// Add a wildcard search to the search variable
//$query->execute(array(':search'=>"%".$search."%"));

// Do a quick fetchall on the results
$result = mysqli_query($db, $query);
//var_dump($result);
$data = array();
if (mysqli_num_rows($result)>0) {
   while ($row = mysqli_fetch_assoc($result)) {
       $data[] = $row;
   }
}else{
   $data[] = array('id' => '0', 'name' => 'ไม่พบข้อมูลครูฝึก');        
}
//var_dump($data);
echo json_encode($data, JSON_UNESCAPED_UNICODE);
