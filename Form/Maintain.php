<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/3
 * Time: 16:27
 * 這是一個子路由, 應該寫到主路由中
 */

//********************************加載庫文件*********************************
include("Libs/MaintainHistory.php");
$maintain = new MaintainHistory();

//********************************函數****************************************
//function __createSelectItem($itemList)
//{
//    foreach ($itemList as $value)
//    {
//        echo "<li class='listOption'>{$value}</li>";
//    }
//}

//********************************獲取表單變量*******************************
$id = __get('id');
$date = __get('date');
$shift = __get('shift');
$line = __get('line');
$model = __get('model');
$station = __get('station');
$device = __get('device');
$errCode = __get('errCode');
$errDesc = __get('errDesc');
$rootCause = __get('rootCause');
$causeAnalysis = __get('causeAnalysis');
$action = __get('action');
$result = __get('result');
$state = __get('state');
$owner = __get('owner');

switch ($method)
{
    case 'add':
    $owner = $user->uid;

        if(!empty(__get('btnMaintainAdd'))) {
            $maintainInfo = $maintain->sampleHistory;
            $maintainInfo['date'] = $date;
            $maintainInfo['shift'] = $shift;
            $maintainInfo['line'] = $line;
            $maintainInfo['model'] = $model;
            $maintainInfo['station'] = $station;
            $maintainInfo['device'] = $device;
            $maintainInfo['errCode'] = $errCode;
            $maintainInfo['errDesc'] = $errDesc;
            $maintainInfo['rootCause'] = $rootCause;
            $maintainInfo['causeAnalysis'] = $causeAnalysis;
            $maintainInfo['action'] = $action;
            $maintainInfo['result'] = $result;
            $maintainInfo['state'] = $state;
            $maintainInfo['owner'] = $owner;
            if ($maintain->add($maintainInfo)) {
                __showMsg("添加成功");
                $date = $shift = $line = $model = $station = $device = $errCode = $errDesc = $rootCause = $causeAnalysis = $action = $result = $state = $owner = null;

            } else {
                __showMsg("添加失敗");
            }
        }
        break;

    case 'update':
        break;
    case 'search':
        $startDate = __get('startDate');
        $stopDate = __get('stopDate');
        $filter = array();
        if($state != 'All') $filter += array('state'=>$state);
        if(!empty($line)) $filter += array('line'=>$line);
        $searchResult = $maintain->search(array('Id','date','line','station','errCode','errDesc','rootCause','state'),
            $filter, "date between '{$startDate}' and '{$stopDate}'");
        break;

}

$loadFile = file_exists("Form/Maintain/{$method}.php") ? "Form/Maintain/{$method}.php" : "Form/Maintain/search.php";
include($loadFile);
