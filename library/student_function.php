<?php
function getSchoolName($school_id){
    global $db;
    $query = "SELECT * FROM school where school_id='".$school_id."'";
    //echo $query;
    $rs = mysqli_query($db, $query);
    $row = mysqli_fetch_array($rs,MYSQLI_ASSOC);
    return $row['school_name'];
}
function getMajorName($major_id){
    global $db;
    $query = "SELECT * FROM major where major_id='".$major_id."'";
    //echo $query;
    $rs = mysqli_query($db, $query);
    $row = mysqli_fetch_array($rs);
    return $row['major_name'];
}

function getMinorName($minor_id){
    global $db;
    $query = "SELECT * FROM minor where minor_id='".$minor_id."'";
    //echo $query;
    $rs = mysqli_query($db, $query);
    $row = mysqli_fetch_array($rs);
    return $row['minor_name'];
}

//แปลง 2011-03-08 to 8 มีนาคม 2554
function chDay3($s){
	$d=explode("-",$s);
	//print_r($d);
	$arr_month=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                     'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
	$y=$d[0]+543;
	//$da=ins0($d[0]);
	return del0($d[2])." ".$arr_month[$d[1]-1]." ".$y;
}
//ตัดเลข 0 ถ้าไม่ถึง 10 // 08 >> 8
function del0($s){
    if ($s<10){
        $r=substr($s,1);
    }else{
        $r=$s;
    }
    return $r;
}
// M=>ชาย
function convSex($s){
    if ($s=='M'){
        $r='ชาย';
    }else{
        $r='หญิง';
    }
    return $r;
}

function getzoneName($zone_id){
    global $db;
    $query = "SELECT * FROM zone where zone_id='".$zone_id."'";
    //echo $query;
    $rs = mysqli_query($db, $query);
    $row = mysqli_fetch_array($rs,MYSQLI_ASSOC);
    return $row['zoneName'];
}