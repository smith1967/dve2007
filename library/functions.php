<?php

include_once 'password_hash.php';
include_once 'student_function.php';

function hs($s) {
    return htmlspecialchars($s);
}

function pq($s) {
    global $db;
    $str = mysqli_real_escape_string($db, $s);
    return "'" . trim($str) . "'";
}

function site_url($url = '', $direct = false) {
    $res = substr($url, 0, 1);
    if ($res == '/')
        $url = substr($url, 1);
    if (!$direct)
        return SITE_URL . 'index.php?' . $url;
    else
        return SITE_URL . $url;
}

function redirect($url = '') {
    $url = site_url($url);
    header('Location: ' . $url);
    exit;
//    echo '<meta http-equiv="Refresh" content="0; url=' . $url . '" />';
//echo '<meta http-equiv="refresh" content="0" url="'.$url.'">';
//echo "<script>window.location.href='".$url."'</script>";
}

function is_auth($url = '') {
    if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function is_admin() {
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type_id'] == '1') {
        return TRUE;
    } else {
        return FALSE;
    }
}

function is_dvt_admin() {
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type_id'] == '2') {
        return TRUE;
    } else {
        return FALSE;
    }
}

function is_dvt_staff() {
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type_id'] == '3') {
        return TRUE;
    } else {
        return FALSE;
    }
}

function is_school_staff() {
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type_id'] == '4') {
        return TRUE;
    } else {
        return FALSE;
    }
}

function gen_option($sql, $def) {
    global $db;
    if (is_array($sql)) {
        foreach ($sql as $k => $v) {
            $sel = $k == $def ? ' selected="selected"' : '';
            $a[] = "<option value=\"$k\"{$sel}>$v</option>";
        }
    } else {
        $res = mysqli_query($db, $sql);
        $a = array();
        while ($row = mysqli_fetch_row($res)) {
            $sel = $row[0] == $def ? ' selected="selected"' : '';
            $a[] = "<option value=\"{$row[0]}\"{$sel}>{$row[1]}</option>";
        }
    }
    return implode('', $a);
}

function gen_bootrap_radio($name, $data, $def = '', $sep = '') {
    global $db;
    $a = array();
    if (!is_array($data)) {
        $data = array();
        $res = mysqli_query($db, $data);
        while ($row = mysqli_fetch_row($res)) {
            $data[$row[0]] = $row[1];
        }
    }
    foreach ($data as $k => $v) {
//        $id = $name . '_' . $k;
        $chk = $k == $def ? ' checked="checked"' : '';
        $a[] = "<div class=\"radio\"><label><input type=\"radio\" name=\"{$name}\" value=\"{$k}\"{$chk}>{$v}</label></div>";
    }
    return implode($sep, $a);
}

function gen_radio($name, $data, $def = '', $sep = '') {
    global $db;
    $a = array();
    if (!is_array($data)) {
        $data = array();
        $res = mysqli_query($db, $data);
        while ($row = mysqli_fetch_row($res)) {
            $data[$row[0]] = $row[1];
        }
    }
    foreach ($data as $k => $v) {
        $id = $name . '_' . $k;
        $chk = $k == $def ? ' checked="checked"' : '';
        $a[] = "<input type=\"radio\" name=\"{$name}\" id=\"{$id}\" value=\"{$k}\"{$chk}><label for=\"{$id}\">{$v}</label>";
    }
    return implode($sep, $a);
}

function resize_image($src, $dest, $width, $height) {
    $type = exif_imagetype($src); // [] if you don't have exif you could use getImageSize() 
    $allowedTypes = array(
        1, // [] gif 
        2, // [] jpg 
        3, // [] png 
        6   // [] bmp 
    );
    if (!in_array($type, $allowedTypes)) {
        return false;
    }
    switch ($type) {
        case 1 :
            $image = imageCreateFromGif($src);
            break;
        case 2 :
            $image = imageCreateFromJpeg($src);
            break;
        case 3 :
            $image = imageCreateFromPng($src);
            break;
        case 6 :
            $image = imageCreateFromBmp($src);
            break;
    }
//    $image = imagecreatefromstring($src);
    $width_orig = imagesx($image);
    $height_orig = imagesy($image);
    $ratio_orig = $width_orig / $height_orig;
    if ($width / $height > $ratio_orig) {
        $width = $height * $ratio_orig;
    } else {
        $height = $width / $ratio_orig;
    }
    $image_p = imagecreatetruecolor($width, $height);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
    switch ($type) {
        case 1 : imagecreatefromgif($image_p);
//            $image = imagecreatefromgif($image_p); 
            break;
        case 2 : imagejpeg($image_p, $dest, 75);
//            $image = imageCreateFromJpeg($src); 
            break;
        case 3 : imagecreatefrompng($image_p);
//            $image = imageCreateFromPng($src); 
            break;
        case 6 : imagecreatefromwbmp($image_p);
//            $image = imageCreateFromBmp($src); 
            break;
    }

//    imagejpeg($image_p, $dest, 100);
    imagedestroy($image_p);
    imagedestroy($image);
    return true;
}

function resize_image_data($src, $dest, $width, $height) {
//        var_dump($height_orig);
//    var_dump($src);
//    die();
    $image = imagecreatefromstring($src);
    $width_orig = imagesx($image);
    $height_orig = imagesy($image);
    $ratio_orig = $width_orig / $height_orig;
    if ($width / $height > $ratio_orig) {
        $width = $height * $ratio_orig;
    } else {
        $height = $width / $ratio_orig;
    }
    ;
    $image_p = imagecreatetruecolor($width, $height);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
    imagejpeg($image_p, $dest, 100);
    imagedestroy($image_p);
    imagedestroy($image);
    return true;
}

function gen_sidebar_menu($items, $active = 'home', $subactive = 'index') {
    $ret = "";
    $level = 0;
    $indent = str_repeat(" ", $level * 2);
    $ret .= sprintf("%s<ul class='sidebar-menu'>\n", $indent);
//    $indent = str_repeat(" ", ++$level * 2);
    foreach ($items as $items => $subitems) {
        if ($subitems['cond'] == FALSE)
            continue;
        $level = 1;
        $indent = str_repeat(" ", $level * 2);
        if ($items == $active) {
            $ret .= sprintf("%s<li class='active treeview'>\n", $indent);
        } else {
            $ret .= sprintf("%s<li class='treeview'>\n", $indent);
        }
        $level = 3;
        $indent = str_repeat(" ", $level * 2);
        $ret .= sprintf("%s<a href='%s'>\n", $indent, $subitems['url']);
        $level = 4;
        $indent = str_repeat(" ", $level * 2);
        $ret .= sprintf("%s<i class='%s'></i>\n", $indent, $subitems['class']);
        $ret .= sprintf("%s<span>%s</span>\n", $indent, $subitems['title']);
        if (isset($subitems['subitems'])) {
            $ret .= sprintf("%s<span class='pull-right-container'>\n", $indent);
            $ret .= sprintf("%s<i class='fa fa-angle-left pull-right'></i>\n", $indent);
            $ret .= sprintf("%s</span>\n", $indent);
        }
        $level = 3;
        $indent = str_repeat(" ", $level * 2);
        $ret .= sprintf("%s</a>\n", $indent);
        if (isset($subitems['subitems'])) {
            $ret .= sprintf("%s<ul class='treeview-menu'>\n", $indent);
            foreach ($subitems['subitems'] as $item => $subitem) {
                if ($subitem['cond'] == FALSE)
                    continue;
                $level = 4;
                $indent = str_repeat(" ", $level * 2);
                if ($item == $subactive && $items == $active)
                    $ret .= sprintf("%s<li class='active'><a href='%s'><i class='fa fa-circle-o'></i> %s</a>", $indent, site_url($subitem['url']), $subitem['title']);
                else
                    $ret .= sprintf("%s<li><a href='%s'><i class='fa fa-circle-o'></i> %s</a>", $indent, site_url($subitem['url']), $subitem['title']);
                $ret .= sprintf("</li>\n");
            }
            $level = 3;
            $indent = str_repeat(" ", $level * 2);
            $ret .= sprintf("%s</ul>\n", $indent);
        }
        $level = 1;
        $indent = str_repeat(" ", $level * 2);
        $ret .= sprintf("%s</li>\n", $indent);
    }
    $level = 0;
    $indent = str_repeat(" ", $level * 2);
    $ret .= sprintf("%s</ul>\n", $indent);
//    echo $ret;
//    die();
    return($ret);
}

function gen_menu($menu = array(), $active = '', $sub_active = '') {
    $ret = "";
    foreach ($menu as $k => $m) {
        if ($m['cond'] === false)
            continue;
        $sel = $k == $active ? ' class="active treeview"' : ' class="treeview"';
        $ret = '<li' . $sel . '><a href="#">'
                . '<i class="fa fa-dashboard"></i> '
                . '<span>' . $item . '</span>'
                . '<span class="pull-right-container">'
                . '<i class="fa fa-angle-left pull-right"></i>'
                . '</span></a>';
        $href = site_url($m['url']);
        if (isset($m['param']))
            $href .= '&' . $m['param'];
        $a[] = '<li' . $sel . '><a href="' . $href . '">' . $m['title'] . '</a></li>';
    }
    return '<ul class="' . $menu_class . '">' . implode('', $a) . '</ul>';
}

function set_err($error = '') {
    $_SESSION['err'][] = $error;
}

function set_info($info = '') {
    $_SESSION['info'][] = $info;
}

function show_error($err) {
    echo '<div class="alert alert-danger">';
    if (is_array($err) && count($err) > 0)
        echo "<ul><li>" . implode('</li><li>', $err) . "</li></ul>";
    echo '</div>';
}

function show_info($info) {
    echo '<div class="alert alert-info">';
    if (is_array($info) && count($info) > 0)
        echo "<ul><li>" . implode('</li><li>', $info) . "</li></ul>";
    echo '</div>';
}

function check_pid($pid) {
    $pattern = '/\d{13}/';
//$pid = $_POST['pid'];
    $result = true;
    if (preg_match($pattern, $pid)) {
        $sum = 0;
        for ($i = 0; $i < 12; $i++)
            $sum += (float) $pid[$i] * (13 - $i);
        if ((11 - $sum % 11) % 10 == (float) $pid[12])
            $result = false;
    }
    return $result;
}

function check_passwd($password, $pattern = '/^[a-zA-Z]{1}\w{4,13}[a-zA-Z]{1}$/') {
//$pattern = '/^[a-zA-Z]{1}\w{4,13}[a-zA-Z]{1}$/';
//$pid = $_POST['pid'];
    $result = false;
    $result = preg_match($pattern, $password);
    return $result;
}

function check_uname($username) {
    $pattern = '/^[a-z0-9]{5,12}$/';
//$pid = $_POST['pid'];
    $result = false;
    if (preg_match($pattern, $username))
        $result = true;
    return $result;
}

function check_thai($s) {
//$tis = utf2tis($s);
//$pattern = '/^[ก-๙]{3,}$/';
//$pattern = '/^[ก-๛]{3,}$/';
    $pattern = '#^[ก-๛]{3,}$#u';
//$pid = $_POST['pid'];
    $result = false;
    if (preg_match($pattern, $s))
        $result = true;
    return $result;
}

function get_ip() {
    $ip = array();
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
        $ip[] = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
        $ip[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (!empty($_SERVER['REMOTE_ADDR'])) {  //to check ip is pass from proxy
        $ip[] = $_SERVER['REMOTE_ADDR'];
    }
    if (count($ip) > 1) {
        $s = implode("/", $ip);
    } else {
        $s = $ip[0];
    }
    return $s;
}

function gen_thead($array) {
    $s = '<thead><th>' . implode('</th><th>', $array) . '</th></thead>';
    return $s;
}

function gen_td($array) {
    $s = '<td>' . implode('</td><td>', $array) . '</td>';
    return $s;
}

//contains function to test user connectivity and to force logout user
//function to test user connectivity
function test_user_connectivity($user, $password, $radiusserver, $radiusport, $nasportnumber, $nassecret) {
//test user connectivity using radtest command
    $command = "radtest $user $password $radiusserver:$radiusport $nasportnumber $nassecret";
    $result = `$command`;

    $output = "<b>Command</b>: $command<br /><b>Output:</b><br />" . nl2br($result);
    return $output;
}

//function to force disconnect user
function disconnect_user($theUser, $nasaddr, $coaport, $sharedsecret) {
//disconnect user using radclient
    $command = "echo \"User-Name=$theUser\"|radclient -x $nasaddr:$coaport disconnect $sharedsecret";
    $result = `$command`;

    $output = "<b>Command</b>: $command<br /><b>Output:</b><br />" . nl2br($result) . "<br />";
    return $output;
}

function show_message() {
    if (isset($_SESSION['err'])) {
        echo show_error($_SESSION['err']);
        unset($_SESSION['err']);
    }
    if (isset($_SESSION['info'])) {
        echo show_info($_SESSION['info']);
        unset($_SESSION['info']);
    }
}

function pagination($total, $url = '#', $page = 0, $order = '', $limit = 10) {
    global $db;
    $value = $total / $limit;
    $pages = ceil($value);

    if ($pages > 10) {
        $html = '<div class="btn-group">';
        $html .= '<button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">เลือกหน้า <span class="caret"></span></button>';
        $html .= '<ul class="dropdown-menu">';
    } else {
        $html = '<ul class="pagination">';
    }
    for ($i = 0; $i < $pages; $i++) :
        if (empty($order)) {
            $purl = $url . "&page=" . $i;
            $html .= ($page == $i) ? '<li class="active"><a href="' . $purl . '">' . ($i + 1) . '</a></li>' : '<li><a href="' . $purl . '">' . ($i + 1) . '</a></li>';
        } else {
            $purl = $url . "&page=" . $i;
            $html .= ($page == $i) ? '<li class="active"><a href="' . $purl . '">' . ($i + 1) . '</a></li>' : '<li><a href="' . $purl . '">' . ($i + 1) . '</a></li>';
        }
    endfor;
    $html .= '</ul>';
    if ($pages > 10)
        $html .= '</div>';
    return $html;
}

//human readable time format
function humanTime($seconds) {
    if ($seconds <= 60) {
        return "00:00:" . sprintf("%02d", $seconds);
    }

    $hour = floor($seconds / 3600);
    $seconds -=($hour * 3600);
    $minute = floor($seconds / 60);
    $seconds -=($minute * 60);

    return sprintf("%d:%02d:%02d", $hour, $minute, $seconds);
}

function set_var(&$param) {
    if (isset($param)) {
        echo $param;
    } else {
        echo '';
    }
}

function get_param($param) {

//    $param = array(
//        'action' => 'test',
//        'filename' => 'filetest',
//    );
    $params = '';
    if (is_array($param)) {
        foreach ($param as $key => $value) {
            $params .= '&' . $key . '?' . $value;
        }
        return $params;
    }
}
