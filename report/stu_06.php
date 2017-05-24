 
<?php
header("Content-type: text/html; charset=utf-8");
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
    die("!เกิดข้อผิดพลาด : " . mysqli_connect_error());
}
mysqli_set_charset($conn, $charset);
//$mysqli->set_charset($charset);

//require_once LIB_PATH.'/functions.php';
$sql="SELECT  z.zone_id,p.province_id, sch.school_id
  , MIN(z.zoneName) as zoneName
  , MIN(p.province_code) as province_code, MIN(p.province_name) province_name
  , MIN(sch.school_name) as school_name
  , IFNULL(SUM(IF(SUBSTRING(s.std_id, 3, 1)='4'
  and s.end_edu_id=1 
  and s.edu_year='2559'
  , 1, 0)),0) sum_level4
  , IFNULL(SUM(IF(SUBSTRING(s.std_id, 3, 1)='3'
  and s.end_edu_id=1 
  and s.edu_year='2559'
  , 1, 0)),0) sum_level3 
  , IFNULL(SUM(IF(SUBSTRING(s.std_id, 3, 1)='2'
  and s.end_edu_id=1 
  and s.edu_year='2559'
  , 1, 0)),0) sum_level2
  ,IFNULL(SUM(IF(
     (SUBSTRING(s.std_id, 3, 1)='4'
  OR SUBSTRING(s.std_id, 3, 1)='3'  
  OR SUBSTRING(s.std_id, 3, 1)='2')
  and s.end_edu_id=1  and s.edu_year='2559', 1 , 0)),0) sum_total
   ,round((
(IFNULL(SUM(IF(
     (SUBSTRING(s.std_id, 3, 1)='4'
	OR SUBSTRING(s.std_id, 3, 1)='3'  
	OR SUBSTRING(s.std_id, 3, 1)='2')
	and s.end_edu_id=1  and s.edu_year='2559', 1 , 0)),0))
 / (sum.sum_of_student) *100),2) as percent
 ,count(std_id) as sum_all
,sum.sum_of_student 
FROM student s 
JOIN school sch ON s.school_id=sch.school_Id
JOIN province p ON sch.province_id=p.province_code
JOIN zone z ON p.zone_id=z.zone_id
JOIN sum_of_student sum ON sum.school_id=sch.school_id
GROUP BY z.zone_id, p.province_id, sch.school_id
";
$result = mysqli_query($conn,$sql);
    // output data of each row
    echo " ข้อมูลจำนวนนักเรียนรายสถานศึกษาจำนวนตามภูมิภาคที่จัดการเรียนอาชีวศึกษาแบบระบบทวิภาคี  ปีการศึกษา 2559";
    ?>
   <table style="width:100%" border="1">
  <tr>
    <th>ที่</th>
    <th>ภาค</th> 
    <th>จังหวัด</th>
    <th> ชื่อสถานศึกษา</th> 
    <th>ป.ตรี</th> 
    <th>ปวส.</th>
    <th>ปวช.</th> 
    <th>รวมนักเรียนทวิทั้งหมด</th>
    <th>จำนวนักเรียนทั้งหมดแบบเงื่อนไข</th> 
     <th>ทั้งหมด</th>
    <th>ร้อยละ/ทั้งหมด</th>
  </tr>
    <?php
   $num=1;
   while($row = mysqli_fetch_array($result)) {
   ?>

  <tr>
   <td><?php echo $num ?></td> 
   <td><?php echo $row['zoneName'] ?></td> 
   <td><?php echo $row['province_name'] ?></td>
   <td><?php echo $row['school_name'] ?></td>
   <td><?php echo $row['sum_level4'] ?></td>
   <td><?php echo $row['sum_level3'] ?></td>
   <td><?php echo $row['sum_level2'] ?></td>
   <td><?php echo $row['sum_all'] ?></td>
   <td><?php echo $row['sum_total'] ?></td>
   <td><?php echo $row['sum_of_student'] ?></td>
    <td><?php echo $row['percent'] ?></td>

  </tr>
<?php
$num++;
}
echo "</table>";

