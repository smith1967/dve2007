<?php
include_once './../include/config.php';
//ตรวจสอบว่า มีค่า ตัวแปร $_GET['show_province'] เข้ามาหรือไม่  	//แสดงรายชื่อจังหวัด
//var_dump($_GET);
header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
header('Content-Type: application/json; charset=utf-8');
if(isset($_GET['show_province'])){

        //คำสั่ง SQL เลือก id และ  ชื่อจังหวัด
        $sql = "SELECT PROVINCE_CODE,PROVINCE_NAME FROM province";

        //ประมวณผลคำสั่ง SQL
        $result = $db->query($sql);

        //ตรวจสอบ จำนวนข้อมูลที่ได้ มีค่ามากกว่า  0 หรือไม่
        if ($result->num_rows > 0) {

                //วนลูปแสดงข้อมูลที่ได้ เก็บไว้ในตัวแปร $row
                while($row = $result->fetch_assoc()) {

                        //เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
                        $json_result[] = [
                                'id'=>$row['PROVINCE_CODE'],
                                'name'=>$row['PROVINCE_NAME'],
                        ];
                }

                //ใช้ Function json_encode แปลงข้อมูลในตัวแปร $json_result ให้เป็นรูปแบบ Json
                echo json_encode($json_result);

        } 
}


//ตรวจสอบว่า มีค่า ตัวแปร $_GET['province_id'] เข้ามาหรือไม่  //แสดงรายชืออำเภอ
if(isset($_GET['province_id'])){

        //กำหนดให้ตัวแปร $province_id มีค่าเท่ากับ $_GET['province_id]
        $province_id = $_GET['province_id'];

        //คำสั่ง SQL เลือก AMPHUR_ID และ  AMPHUR_NAME ที่มี PROVINCE_ID เท่ากับ $province_id
        $sql = "SELECT AMPHUR_CODE,AMPHUR_NAME FROM amphur WHERE PROVINCE_CODE = ".pq($province_id)." ";

        //ประมวณผลคำสั่ง SQL
        $result = $db->query($sql);

        //ตรวจสอบ จำนวนข้อมูลที่ได้ มีค่ามากกว่า  0 หรือไม่
        if ($result->num_rows > 0) {

                //วนลูปนำข้อมูลที่ได้ เก็บไว้ในตัวแปร $row
                while($row = $result->fetch_assoc()) {

                        //เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
                        $json_result[] = [
                                'id'=>$row['AMPHUR_CODE'],
                                'name'=>$row['AMPHUR_NAME'],
                        ];
                }

                //ใช้ Function json_encode แปลงข้อมูลในตัวแปร $json_result ให้เป็นรูปแบบ Json
                echo json_encode($json_result);

        } 
}


//ตรวจสอบว่า มีค่า ตัวแปร $_GET['province_id'] เข้ามาหรือไม่  //แสดงรายชืออำเภอ
if(isset($_GET['amphur_id'])){

        //กำหนดให้ตัวแปร $amphur_id มีค่าเท่ากับ $_GET['amphur_id]
        $amphur_id = $_GET['amphur_id'];

        //คำสั่ง SQL เลือก DISTRICT_CODE และ  DISTRICT_NAME ที่มี AMPHUR_ID เท่ากับ $amphur_id
        $sql = "SELECT DISTRICT_CODE,DISTRICT_NAME FROM district WHERE AMPHUR_CODE = ".pq($amphur_id)." ";

        //ประมวณผลคำสั่ง SQL
        $result = $db->query($sql);

        //ตรวจสอบ จำนวนข้อมูลที่ได้ มีค่ามากกว่า  0 หรือไม่
        if ($result->num_rows > 0) {

                //วนลูปนำข้อมูลที่ได้ เก็บไว้ในตัวแปร $row
                while($row = $result->fetch_assoc()) {

                        //เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
                        $json_result[] = [
                                'id' => $row['DISTRICT_CODE'],
                                'name'=>$row['DISTRICT_NAME'],

                        ];
                }

                //ใช้ Function json_encode แปลงข้อมูลในตัวแปร $json_result ให้เป็นรูปแบบ Json
                echo json_encode($json_result);
        }         
}
if(isset($_GET['district_id'])){

        //กำหนดให้ตัวแปร $amphur_id มีค่าเท่ากับ $_GET['amphur_id]
        $district_id = $_GET['district_id'];

        //คำสั่ง SQL เลือก DISTRICT_CODE และ  DISTRICT_NAME ที่มี AMPHUR_ID เท่ากับ $amphur_id
        $sql = "SELECT zipcode FROM zipcodes WHERE district_code = ".pq($district_id)." ";
//        echo $sql.'<br>';
        //ประมวณผลคำสั่ง SQL
        $result = $db->query($sql);

        //ตรวจสอบ จำนวนข้อมูลที่ได้ มีค่ามากกว่า  0 หรือไม่
        if ($result->num_rows > 0) {

                //วนลูปนำข้อมูลที่ได้ เก็บไว้ในตัวแปร $row
                while($row = $result->fetch_assoc()) {
                        //เก็บข้อมูลที่ได้ไว้ในตัวแปร Array 
                        $json_result[] = [
                                'id' => $row['zipcode'],
//                                'name'=>$row['DISTRICT_NAME'],
                        ];
                }

                //ใช้ Function json_encode แปลงข้อมูลในตัวแปร $json_result ให้เป็นรูปแบบ Json
                echo json_encode($json_result);
        }         
}


?>