<?php
require_once 'include/config.php';
function MakeMenu($items, $class = "fa fa-files-o", $active = 'home', $subactive = 'index') {
    $ret = "";
    $level = 0;
    $indent = str_repeat(" ", $level * 2);
    $ret .= sprintf("%s<ul class='sidebar-menu'>\n", $indent);
//    $indent = str_repeat(" ", ++$level * 2);
    foreach ($items as $items => $subitems) {
        if($subitems['cond']==FALSE)
            continue;
        $level=1;
        $indent = str_repeat(" ", $level * 2);
        if($items == $active){
            $ret .= sprintf("%s<li class='active treeview'>\n", $indent );
        }else
            $ret .= sprintf("%s<li class='treeview'>\n", $indent);            
//        $ret .= sprintf("</li>\n");
        $level=3;
        $indent = str_repeat(" ", $level * 2);
        $ret .= sprintf("%s<a href='%s'>\n", $indent,$subitems['url']);                    
        $level=4;
        $indent = str_repeat(" ", $level * 2);
        $ret .= sprintf("%s<i class='%s'></i>\n",$indent,$class);
        $ret .= sprintf("%s<span>%s</span>\n",$indent, $subitems['title']);
        $ret .= sprintf("%s<span class='pull-right-container'>\n",$indent);
        $ret .= sprintf("%s<i class='fa fa-angle-left pull-right'></i>\n",$indent);
        $ret .= sprintf("%s</span>\n",$indent);
        $level=3;
        $indent = str_repeat(" ", $level * 2);
        $ret .= sprintf("%s</a>\n",$indent);
        $ret .= sprintf("%s<ul class='treeview-menu'>\n", $indent);
        foreach ($subitems['subitems'] as $item => $subitem){
            if($subitems['cond']==FALSE)
                continue;
            $level=4;
            $indent = str_repeat(" ", $level * 2);
            if($item == $subactive && $items == $active)
                $ret .= sprintf("%s<li class='active'><a href='%s'><i class='fa fa-circle-o'></i> %s</a>", $indent,  site_url($subitem['url']) ,$subitem['title']);
            else
                $ret .= sprintf("%s<li><a href='%s'><i class='fa fa-circle-o'></i> %s</a>", $indent,  site_url($subitem['url']) ,$subitem['title']);
            $ret .= sprintf("</li>\n");
        }
        $level=3;
        $indent = str_repeat(" ", $level * 2);        
        $ret .= sprintf("%s</ul>\n", $indent);  
        $level=1;
        $indent = str_repeat(" ", $level * 2);         
        $ret .= sprintf("%s</li>\n", $indent);    
      
//        if (!is_numeric($item)) {
//            $ret .= sprintf("%s<li><a href=''>%s</a>", $indent, $item);
//        }
//        if (is_array($subitems)) {
//            $ret .= "\n";
//            $ret .= MakeMenu($subitems, $level + 1);
//            $ret .= $indent;
//        } else if (strcmp($item, $subitems)) {
//            $ret .= sprintf("%s<li><a href=''>%s</a>", $indent, $subitems);
//        }
//        $ret .= sprintf("</li>\n", $indent);
    }
    $level = 0;
    $indent = str_repeat(" ", $level * 2);
    $ret .= sprintf("%s</ul>\n", $indent);
    return($ret);
}


$menu = Array(
    'home' => array(
        'title' => 'หน้าหลัก',
        'url' => '#',
        'cond' => true,
        'subitems' => array(
            'index' => array(
                'title' => 'หน้าหลัก',
                'url' => 'app/home/index',
                'cond' => true,
            ),
            'test' => array(
                'title' => 'ทดสอบ',
                'url' => 'app/home/test',
                'cond' => true,
            ),
        ),
    ),
    'school' => array(
        'title' => 'สถานศึกษา',
        'url' => '#',
        'cond' => true,
        'subitems' => array(
            'index' => array(
                'title' => 'หน้าหลัก',
                'cond' => true,
                'url' => 'app/school/index',
            ),
            'school-list' => array(
                'title' => 'ทดสอบ',
                'url' => 'app/school/list',
                'cond' => true,
            ),
        ),
    ),
);


//var_dump($menu);

echo MakeMenu($menu);
?>