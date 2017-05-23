<?php
  define("NOsTinyDB",FALSE);
function sInsertTb($db_param,$tb,$data,$debug=false){
  $db=$db_param['db'];
  $prefix=$db_param['prefix'];
  $query="insert into {$prefix}{$tb} ";
  
  $col="(";
  $val=" values (";
  $i=0;
  foreach($data as $k=>$v){
    if($i){$col.=","; $val.=",";}
    $col.=$k;
    $val.=$v;
    
    $i++;
          }
  
  $col.=")";
  $val.=");";
  
 $query.=$col.$val;
  
  if($debug)print $query;
  mysqli_query($db,$query);
    
  return mysqli_insert_id($db);   
 }
 
  function sSelectTb($db_param,$tbname,$col=NULL,$where=NULL,$debug=false){
    $db=$db_param['db'];
  	$prefix=$db_param['prefix'];
    if(!$col)$col='*';
    $query="select {$col} from {$prefix}{$tbname}";
    if($where)$query.=" where ".$where;
    if($db)$data=mysqli_query($db,$query);
    $res=array();
    if($data&&mysqli_num_rows($data)){
    while($row=mysqli_fetch_array($data)){
      $res[]=$row;
    }
   }
    if($debug)print $query;
    //print mysqli_error($db);
    return $res;
  }
  
  function sUpdateTb($db_param,$tbname,$data,$where=NULL,$debug=false){
    $db=$db_param['db'];
  	$prefix=$db_param['prefix'];
    $i=0;
    $query="update {$prefix}{$tbname} set ";
      foreach($data as $k=>$v){
        if($i)$query.=",";
        $query.=$k."=".$v;
    
        $i++;
        }
    if($where)$query.=" where ".$where;
    if($debug)print $query;
    return mysqli_query($db,$query);
  }
  
  function sDeleteTb($db_param,$tbname,$where=NULL,$debug=false){
    $db=$db_param['db'];
  	$prefix=$db_param['prefix'];
    $query="delete from {$prefix}{$tbname}";
    if($where)$query.=" where ".$where;
    $data=mysqli_query($db,$query);
    if($debug)print $query;
    return $data;
  }
  
 function strC($str,$t='"'){
 	return $t.$str.$t;
 }
 
