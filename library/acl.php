<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of acl
 *
 * @author IT
 */
class acl {
    //put your code here
    var $allowed;
    function __construct($url,$user_type) {
        $url_list = array(
            '',
            'app/home/index',
            'app/user/edit',
            'app/user/login',
            'app/user/signup',
            'app/user/logout'
            );
        if(in_array($url, $url_list) ){
            $this->allowed = true;
        }else if($user_type==1){
            $this->allowed = true;
        }else if($user_type==2){
            $this->is_dvt_admin($url); 
        }else if($user_type==3){
            $this->is_dvt_staff($url);        
        }else if($user_type==4){
            $this->is_school_staff($url);
        }
    }
    function is_dvt_admin($url){
        $url_list = array(
            'app/mou/list',
            'app/mou/edit',
            'app/mou/insert',
            'app/home/dvt_admin',
            'app/user/edit',
            'app/do_school_vg/list-do_school_vg'
            );
        $this->allowed = in_array($url, $url_list);
    }

    function is_dvt_staff($url){
        $url_list = array(
            'app/user/edit',
            'app/home/dvt_staff',
            'app/do_school_vg/list-do_school_vg',
            'app/mou/list',
            'app/mou/edit',
            'app/mou/insert',
            );
        $this->allowed = in_array($url, $url_list);
    }
    function is_school_staff($url){
        $url_list = array(
            'app/home/school_staff',
            'app/business/list',
            'app/school/list-data',
            'app/school/edit-data',
            'app/business/edit',
            "app/business/insert",
            'app/student/list',
            'app/student/check-data',
            'app/student/import-std',
            'app/student/import-dvt-student',
            'app/mou/list',
            'app/mou/edit',
            'app/mou/insert',
            'app/student/file-manager',
            'app/student/check-data',
            'app/do_business_vg/list-do_business_vg',
            'app/trainer/list',
            'app/trainer/insert',
            'app/training/insert_group',
            'app/trainer/edit',
            'app/training/list',
            'app/training/insert',
            'app/training/edit'
            );
        $this->allowed = in_array($url, $url_list);
    }    
}

?>
