<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/5
 * Time: 14:48
 */
include "Libs/Func.php";        //函数集
include "Libs/Config.php";      //设定
require_once "Libs/MysqlConn.php";   //Mysql连接库
include "Libs/User.php";        //用户管理

//****************************實例化用戶類*******************************
$user = new User();

//****************************獲取url參數
$urlPara = explode('/',__get("act"));
$act  = $urlPara[0];        //呼叫類
$method = isset($urlPara[1]) ? $urlPara[1] : null;      //呼叫方法
$dat    = isset($urlPara[2]) ? $urlPara[2] : null;      //附加數據

//****************************生成標題************************************
$title = "歡迎使用<維護記錄庫>";
$title .= isset($actList[$act]) ? '-' . $actList[$act] : null;
$title .= isset($methodList[$method]) ? '-' . $methodList[$method] : null;

?>

<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<link href="Css/<?php echo $cssName ?>" rel="stylesheet">
<link href="Css/modernforms.css" rel="stylesheet">
<link rel="icon" href="Favicon.ico">
<script type="text/javascript" src="Script/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="Script/Main.js"></script>
<head>
    <title><?php echo $title ?></title>
</head>
<body>
<div id="Container">
    <div id="header"><?php echo $title ?></div>
    <div id="mainMenu">
        <?php
        /**
        主菜单, 登录后显示
         */
        if($user->isLogined)
        {
            include "Form/mainMenu.php";
        }
        ?>
    </div>
    <div id="mainContent">
        <?php
        /**
         * 这里是中间区域, 显示主要的内容.
         */
        if(!$user->isLogined)   //没有登录的话显示登录界面.
        {
            if($act == 'userAdd')
            {
                include "Form/UserAdd.php";
            } else
            {
                include "Form/UserLogin.php";
            }

        } else {
            include "Libs/Router.php";      //否则加载路由器,处理请求.
        }
        ?>

    </div>
    <div id="footer">最後更新日期: 2019-7-2</div>
</div>
</body>
</html>
