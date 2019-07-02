<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 9:52
 */
$loadPage = null;
switch ($act)
{
    case "userLogout":
        $user->logout();
        header('Location:'. $homeUrl);
        break;

    default:
        if(empty($act))
        {
            //todo: 空請求, 顯示主頁.
        } else {
            if($isMobile)       #如果是移動端
            {
                if(file_exists("Form/" . $act . "_Mobile.php"))     #存在移動頁面就加載移動頁面
                {
                    include "Form/" . $act . "_Mobile.php";
                } else if(file_exists("Form/" . $act . ".php"))     #沒有就加載普通頁面
                {
                    include "Form/" . $act . ".php";
                } else {                                                        #否則就報錯
                    include "Form/404.php";
                }
            } else {                                                            #如果不是移動端
                if(file_exists("Form/" . $act . ".php"))            #頁面存在則加載對應頁面
                {
                    include "Form/" . $act . ".php";
                } else {                                                        #否則加載錯誤頁面
                    include "Form/404.php";
                }
            }
        }
        break;
}

pageEnd: