<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/3
 * Time: 16:27
 * 這是一個子路由, 應該寫到主路由中
 */

$loadFile = file_exists("Form/Maintain/{$method}.php") ? "Form/Maintain/{$method}.php" : "Form/Maintain/search.php";
include($loadFile);
