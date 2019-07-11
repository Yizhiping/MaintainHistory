<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/6
 * Time: 14:11
 */

date_default_timezone_set("Asia/Shanghai");     //设定默认时区
session_start();        //开启session

define("EOL", "<br />");        //定义一个Html的换行
require_once "MysqlConn.php";

/********************一些环境参数**********************/
$remoteAddr = __getIP();
$isMobile = isMobile();
$cssName = $isMobile ? "MainPage_Mobile.css" : "MainPage.css";

/*********************数据库连接************************/
$db_host = "127.0.0.1";
$db_uid  = "maintainhistory";
$db_pwd  = "#*c123456";
$db_name = "MaintainHistory";

/**********************一些参数**************************/
$homeUrl = "Index.php";     //默认页面
//$homePage = "http://" . $_SERVER['SERVER_ADDR'] . "/maintainhistory/index.php";
$homePage = "http://172.22.255.125/maintainhistory/index.php";
//$opid = 'S09264888';        //系統調用SFIS用到的工號
//$device = '111111';         //系統調用SFIS用到的撥號

$actList = array(
    'maintain'=>'維護記錄',
    'Users'=>'用戶管理',
    'Roles' => '角色管理',
    'Fun'=>'功能管理'
                );
$methodList = array(
    'add'=>'添加',
    'update'=>'更新',
    'search'=>'查找',
    'personal'=>'個人專區'
);


$conn = new MysqlConn($db_host, $db_uid, $db_pwd, $db_name);


