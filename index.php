<?php
require_once 'include/config.php';
include_once 'library/acl.php';
$req = substr($_SERVER['REQUEST_URI'], strlen($_SERVER['SCRIPT_NAME'])+1);
$param = explode('&', $req);
//var_dump($req);
//var_dump($req);
//var_dump(is_dvt_staff());

$ctrl_act = array_shift($param);
 if(isset($_SESSION['user']['user_type_id'])){
     $acl = new acl($ctrl_act, $_SESSION['user']['user_type_id']);
//     var_dump($acl);
//     var_dump($ctrl_act);
//     die();
     if($acl->allowed == FALSE){
         set_err('คุณไม่มีสิทธิ์เข้าในหน้า '. $ctrl_act);
         redirect('app/home/index');
     }
 }else{
     $acl = new acl($ctrl_act,5);
     if($acl->allowed == FALSE){
         set_err('คุณไม่มีสิทธิ์เข้าในหน้า '. $ctrl_act);
         redirect('app/home/index');
     }  
 }
//var_dump($ctrl_act);
$file = dirname(__FILE__) . '/' . $ctrl_act . '.php';
if (!is_file($file)) {
	$file = dirname(__FILE__) . '/app/home/index.php';
}
// var_dump($file);
// die();
ob_start();
include $file;
$content = ob_get_contents();
ob_end_clean();
echo $content;
//require_once INC_PATH. 'template.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
