<?php
header('Content-Type: text/html; charset=UTF-8');

require_once '../../include/config.php';
$semester='2559';
$year= substr($semester, 0,2);
$day=date('Y-m-d');
?>
รายงานข้อมูลนักเรียนระบบทวิภาคี ปีการศึกษา <?php echo $semester ?><br>
จำแนกตามจังหวัด<br>
วันที่ทำรายงาน <?php echo $day ?><br>
<table>
    <tr>
        <th rowspan="3">ลำดับที่</th>
        <th rowspan="3">จังหวัด</th>
        <th colspan="21">จำนวนนักเรียน(คน)</th>
        <th rowspan="3">รวม</th>
    </tr> 
    <tr>
        <th colspan="3">ปวช.1</th>
        <th colspan="3">ปวช.2</th>
        <th colspan="3">ปวช.3</th>
        <th colspan="3">ปวส.1</th>
        <th colspan="3">ปวส.2</th>
        <th colspan="3">ป.ตรี 1</th>
        <th colspan="3">ป.ตรี 2</th>
    </tr> 
    <tr>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
    </tr>

<?php
    $query = "SELECT  p.PROVINCE_NAME,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='592'
	and sex='M' and end_edu_id=1 and edu_year='2559', 1 , 0)),0) pvc1_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='592'
	and sex='F' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pvc1_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id , 1, 3)='592' and end_edu_id=1 and edu_year='2559', 1, 0)),0) sum_pvc1,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='582'
	and sex='M' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pvc2_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='582'
	and sex='F' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pvc2_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='582' and end_edu_id=1 and edu_year='2559', 1, 0)),0) sum_pvc2,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='572'
	and sex='M' and end_edu_id=1 and edu_year='2559', 1, 0)) ,0) pvc3_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='572'
	and sex='F' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pvc3_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='572' and end_edu_id=1 and edu_year='2559', 1, 0)),0) sum_pvc3,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='593'
	and sex='M'and end_edu_id=1 and edu_year='2559', 1 , 0)),0) pvs1_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='593'
	and sex='F' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pvs1_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='593' and end_edu_id=1 and edu_year='2559', 1, 0)),0) sum_pvs1,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='583'
	and sex='M' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pvs2_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='583'
	and sex='F' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pvs2_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='583' and end_edu_id=1 and edu_year='2559', 1, 0)),0) sum_pvs2,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='594'
	and sex='M' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pt1_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='594'
	and sex='F' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pt1_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='594' and end_edu_id=1 and edu_year='2559', 1, 0)),0) sum_pt1,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='584'
	and sex='M' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pt2_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='584'
	and sex='F' and end_edu_id=1 and edu_year='2559', 1, 0)),0) pt2_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='584' and end_edu_id=1 and edu_year='2559', 1, 0)),0) sum_pt2,

IFNULL(SUM(IF(
	(SUBSTRING(s.std_id, 1, 3)='592' 
	OR SUBSTRING(s.std_id, 1, 3)='582' 
	OR SUBSTRING(s.std_id, 1, 3)='572' 
	OR SUBSTRING(s.std_id, 1, 3)='593' 
	OR SUBSTRING(s.std_id, 1, 3)='583' 
	OR SUBSTRING(s.std_id, 1, 3)='594' 
	OR SUBSTRING(s.std_id, 1, 3)='584')  
	and end_edu_id=1 
	and edu_year='2559'
	, 1, 0)),0) sum_all

FROM student s 
JOIN school sch ON s.school_id=sch.school_id
JOIN province p ON sch.province_id=p.province_code
GROUP BY  p.province_id,s.school_id";
    //echo $query;
    $result = mysqli_query($db, $query);
    $count=1;
    while ($row = mysqli_fetch_assoc($result)) { 
        
?>


  <tr>
	<td><?php echo $count++ ?></td>
	<td><?php echo $row['PROVINCE_NAME'] ?></td>
	<td><?php echo $row['pvc1_m'] ?></td>
	<td><?php echo $row['pvc1_f'] ?></td>
	<td><?php echo $row['sum_pvc1'] ?></td>
        <td><?php echo $row['pvc2_m'] ?></td>
	<td><?php echo $row['pvc2_f'] ?></td>
	<td><?php echo $row['sum_pvc2'] ?></td>
        <td><?php echo $row['pvc3_m'] ?></td>
	<td><?php echo $row['pvc3_f'] ?></td>
	<td><?php echo $row['sum_pvc3'] ?></td>
        <td><?php echo $row['pvs1_m'] ?></td>
	<td><?php echo $row['pvs1_f'] ?></td>
	<td><?php echo $row['sum_pvs1'] ?></td>
        <td><?php echo $row['pvs2_m'] ?></td>
	<td><?php echo $row['pvs2_f'] ?></td>
	<td><?php echo $row['sum_pvs2'] ?></td>
        <td><?php echo $row['pt1_m'] ?></td>
	<td><?php echo $row['pt1_f'] ?></td>
	<td><?php echo $row['sum_pt1'] ?></td>
        <td><?php echo $row['pt2_m'] ?></td>
	<td><?php echo $row['pt2_f'] ?></td>
	<td><?php echo $row['sum_pt2'] ?></td>
	<td><?php echo $row['sum_all'] ?></td>
	
  </tr>
  

<?php
    }
    ?>
</table>


