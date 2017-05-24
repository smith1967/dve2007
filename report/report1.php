<?php
// database parameter
$host = 'localhost';

$user = 'root';
$password = '';
$database = 'dve2017';
$charset = 'utf8';
//GRANT ALL PRIVILEGES ON dvt2017.* TO dvt@localhost IDENTIFIED BY '123456';
/*--- Database connect ---*/

$conn = mysqli_connect($host, $user, $password, $database);
//$mysqli = new mysqli($host, $user, $password, $database);
if (mysqli_connect_error())
{    
    header("Content-type: text/html; charset=utf-8");
    die("!à¡Ô´¢éÍ¼Ô´¾ÅÒ´ : " . mysqli_connect_error());
}
mysqli_set_charset($conn, $charset);
//$mysqli->set_charset($charset);

//require_once LIB_PATH.'/functions.php';
$sql="SELECT  z.zone_id, p.province_id, sch.school_id
  , MIN(z.zoneName) as zoneName
  , MIN(p.province_code) as province_code, MIN(p.province_name) province_name
  , MIN(sch.school_name) as school_name
  , IFNULL(SUM(IF(SUBSTRING(s.std_id, 3, 1)='4', 1, 0)),0) sum_level4
  , IFNULL(SUM(IF(SUBSTRING(s.std_id, 3, 1)='3', 1, 0)),0) sum_level3 
  , IFNULL(SUM(IF(SUBSTRING(s.std_id, 3, 1)='2', 1, 0)),0) sum_level2
 ,count(std_id) as sum_all
,sum.sum_of_student
,round(((count(std_id)/sum.sum_of_student)*100),2) as percent
 
FROM student s 
JOIN school sch ON s.school_id=sch.school_Id
JOIN province p ON sch.province_id=p.province_code
JOIN zone z ON p.zone_id=z.zone_id
JOIN sum_of_student sum ON sum.school_id=sch.school_id
GROUP BY z.zone_id, p.province_id, sch.school_id
";
$result = mysqli_query($conn,$sql);
    // output data of each row
    while($row = mysqli_fetch_array($result)) {
    echo $row['percent']."&nbsp;&nbsp;";
	echo $row['sum_level2']."<br />";
	}
