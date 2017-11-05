<?php
$string="1,2,3,4,5";
$array=array_map('intval', explode(',', $string));
var_dump($array);
$array = implode("','",$array);
var_dump($array);
return ;
?>
<form method="post">
    <textarea name="data_list"></textarea>
    <input type="submit" name="submit">
</form>
<?php
if($_POST){
    echo $_POST['data_list'];
    $data = explode("\r\n", $_POST['data_list']);
    var_dump($data);
}
//var_dump($_SERVER);
////Generate a random string.
//$token = openssl_random_pseudo_bytes(16);
//
////Convert the binary data into hexadecimal representation.
//$token = bin2hex($token);
//
////Print it out for example purposes.
//echo $token;

