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

//********************************獲取表單變量*******************************
$id = __get('id');
$date = __get('date');
$shift = __get('shift');
$team = __get('team');
$line = __get('line');
$model = __get('model');
$station = __get('station');
$device = __get('device');
$errCode = __get('errCode');
$errClass = __get('errClass');
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
        $name  = $user->name;
        if(!empty(__get('btnMaintainAdd'))) {
            $maintainInfo = $maintain->sampleHistory;
            $maintainInfo['date'] = $date;
            $maintainInfo['shift'] = $shift;
            $maintainInfo['team'] = $team;
            $maintainInfo['line'] = $line;
            $maintainInfo['model'] = $model;
            $maintainInfo['station'] = $station;
            $maintainInfo['device'] = $device;
            $maintainInfo['errCode'] = $errCode;
            $maintainInfo['errClass'] = $errClass;
            $maintainInfo['errDesc'] = $errDesc;
            $maintainInfo['rootCause'] = $rootCause;
            $maintainInfo['causeAnalysis'] = $causeAnalysis;
            $maintainInfo['action'] = $action;
            $maintainInfo['result'] = $result;
            $maintainInfo['state'] = $state;
            $maintainInfo['owner'] = $owner;
            if ($maintain->add($maintainInfo)) {
                __showMsg("添加成功");
                $team = $date = $shift = $line = $model = $station = $device = $errCode = $errDesc = $rootCause = $causeAnalysis = $action = $result = $state = $owner = null;

            } else {
                __showMsg("添加失敗");
            }
        }
        break;           //增加
    case 'update':
        $id = is_null($dat) ? $id : $dat;        //url的第三個參數為id
        if (!is_numeric($id)) {                    //id必須為數字, 負責判斷為無效
            __showMsg("無效的請求數據");
        } else {
            //取得當前id的數據
            $fields = array('id','date','shift','team','line','model','station','device','errCode','errClass','errDesc','rootCause','causeAnalysis','zAction','result','state','owner');
            $filter = array('id'=>$id);
            $maintainInfo = $maintain->search($fields, $filter);
            $maintainInfo = $maintainInfo[0];
            //更新
            if(empty(__get('btnMaintainUpdate'))) {     //如果不是更新,賦值顯示的變量.
                $date = $maintainInfo['date'];
                $shift = $maintainInfo['shift'];
                $team = $maintainInfo['team'];
                $line = $maintainInfo['line'];
                $model = $maintainInfo['model'];
                $station = $maintainInfo['station'];
                $device = $maintainInfo['device'];
                $errCode = $maintainInfo['errCode'];
                $errClass = $maintainInfo['errClass'];
                $errDesc = $maintainInfo['errDesc'];
                $rootCause = $maintainInfo['rootCause'];
                $causeAnalysis = $maintainInfo['causeAnalysis'];
                $action = $maintainInfo['zAction'];
                $result = $maintainInfo['result'];
                $state = $maintainInfo['state'];
                $owner = $maintainInfo['owner'];
                $name = $user->getNameByUid($owner,'name');
            } else {
                $updateData = array('errDesc'=>$errDesc,'rootCause'=>$rootCause,'causeAnalysis'=>$causeAnalysis,'zAction'=>$action,'result'=>$result,'state'=>$state);
                if($maintain->update($id,$updateData))
                {
                    __showMsg("更新成功.");
                } else {
                    __showMsg("更新失敗.");
                }
            }
        }
        break;        //更新
    case 'view':
        $id = is_null($dat) ? $id : $dat;        //url的第三個參數為id
        if (!is_numeric($id)) {                    //id必須為數字, 負責判斷為無效
            __showMsg("無效的請求數據");
        } else {
            //取得當前id的數據
            $fields = array('id','date','shift','team','line','model','station','device','errCode','errClass','errDesc','rootCause','causeAnalysis','zAction','result','state','owner');
            $filter = array('id'=>$id);
            $maintainInfo = $maintain->search($fields, $filter);
            $maintainInfo = $maintainInfo[0];

            $date = $maintainInfo['date'];
            $shift = $maintainInfo['shift'];
            $team = $maintainInfo['team'];
            $line = $maintainInfo['line'];
            $model = $maintainInfo['model'];
            $station = $maintainInfo['station'];
            $device = $maintainInfo['device'];
            $errCode = $maintainInfo['errCode'];
            $errClass = $maintainInfo['errClass'];
            $errDesc = $maintainInfo['errDesc'];
            $rootCause = $maintainInfo['rootCause'];
            $causeAnalysis = $maintainInfo['causeAnalysis'];
            $action = $maintainInfo['zAction'];
            $result = $maintainInfo['result'];
            $state = $maintainInfo['state'];
            $owner = $maintainInfo['owner'];
            $name = $user->getNameByUid($owner,'name');

        }
        break;          //更新
    case 'personal':
        $startDate = __get('startDate');
        $stopDate = __get('stopDate');
        $filter = array();
        $sqlSub = null;
        $searchResult = null;


        if((diffBetweenTwoDays($startDate,$stopDate) !== false) && (diffBetweenTwoDays($startDate,$stopDate) <= 31)) {
            if ($state != 'All') $filter += array('state' => $state);
            if (!empty($line)) $filter += array('line' => $line);

            if (!$user->authByRole('管理員', false)) $sqlSub = " and owner='{$user->uid}'";        //作owner過濾, 只能查看自己填寫的, 管理員不限制
            $searchResult = $maintain->search(array('Id', 'date', 'line', 'station', 'errCode', 'errClass','errDesc', 'rootCause', 'state'),
                $filter, "date between '{$startDate}' and '{$stopDate}'" . $sqlSub . " order by date");
        } else {
            __showMsg("搜索的日期錯誤, 開始日期必須小雨結束日期, 且最多搜索的天數不大於30天.");
        }

        break;      //個人專區
    case 'list':          //查找
        $startDate = __get('startDate');
        $stopDate = __get('stopDate');
        $filter = array();
        $sqlSub = null;
        $searchResult = null;

        if((diffBetweenTwoDays($startDate,$stopDate) !== false) && (diffBetweenTwoDays($startDate,$stopDate) <= 91)) {
            $tmpArr = array();
            $allCount  = array();


            //獲取篩選條件
            foreach (array('line','station','errCode','model') as $key)
            {
                if($$key != 'All') array_push($tmpArr,"{$key}='{$$key}'");
            }

            //處理篩選條件
            $sqlSub = implode(' and ', $tmpArr);
            $sqlSub = empty($sqlSub) ? null : " and " . $sqlSub ;

            $searchResult = $conn->getAllRow("select id,date,team,line,station,errCode,errClass,errDesc,causeAnalysis,state from maintainhistory where date between '{$startDate}' and '{$stopDate}' {$sqlSub}");

        } else {
            __showMsg("搜索的日期錯誤, 開始日期必須小雨結束日期, 且最多搜索的天數不大於90天.");
        }
        break;          //查找
    case 'chart':             //图表
        $startDate = __get('startDate');
        $stopDate = __get('stopDate');
        $filterBy  = __get('filterBy');
        $sqlSub = null;
        $searchResult = null;

        if((diffBetweenTwoDays($startDate,$stopDate) !== false) && (diffBetweenTwoDays($startDate,$stopDate) <= 91)) {
            $tmpArr = array();
            $allCount  = array();

            //獲取篩選條件
            foreach (array('team','line','station','errCode','model') as $key)
            {
                if($$key != 'All') array_push($tmpArr,"{$key}='{$$key}'");
            }

            //處理篩選條件
            $sqlSub = implode(' and ', $tmpArr);
            $sqlSub = empty($sqlSub) ? null : " and " . $sqlSub ;

            //統計前9大的數據
            $sql = "select {$filterBy} as name,count({$filterBy}) as count from maintainhistory  where date between '{$startDate}' and '{$stopDate}' {$sqlSub} group by {$filterBy} order by count({$filterBy}) desc";
            $result = $conn->getAllRow($sql);
            if(!empty($result)) {
                //取前9大的數據
                $top9 = array_slice($result, 0, 9);
                //前9大的名字
                $top9Name = array_column($top9, 'name');
                $_SESSION['top9Name'] = $top9Name;

                $other = $conn->getItemByItemName("select count(id) as count from maintainhistory where date between '{$startDate}' and '{$stopDate}' {$sqlSub} and {$filterBy} not in ('" . implode("','", $top9Name) . "')");
                if($other != '0') {
                    $allCount = $top9 + array(9=>array('name' => 'other', 'count' => $other));
                } else {
                    $allCount = $top9;
                }
            } else {
                $allCount = false;
            }


            //todo: 計算不在9大不良, 將兩個合併

        } else {
            __showMsg("搜索的日期錯誤, 開始日期必須小雨結束日期, 且最多搜索的天數不大於90天.");
        }
        break;          //图表
    case 'showList':            //顯示特定內容
        $dat = str_replace('*','=',$dat);
        $dat = str_replace(' ','+',$dat);

        $tmpArr = explode('|',base64_decode($dat));
        $startDate = $tmpArr[0];
        $stopDate  = $tmpArr[1];
        $team      = $tmpArr[2];
        $line      = $tmpArr[3];
        $station   = $tmpArr[4];
        $model     = $tmpArr[5];
        $subFil    = $tmpArr[6];

        //獲取篩選條件
        $tmpArr = array();
        foreach (array('team','line','station','model') as $key)
        {
            if(strtoupper($$key) != 'ALL' && !empty($$key)) array_push($tmpArr,"{$key}='{$$key}'");
        }

        //處理篩選條件
        $sqlSub = implode(' and ', $tmpArr);
        $sqlSub = empty($sqlSub) ? null : " and " . $sqlSub ;

        $result = $conn->getAllRow("select id,model,station,errCode,errDesc,causeAnalysis,zAction from maintainhistory where date between '{$startDate}' and '{$stopDate}' {$sqlSub}   and {$subFil} order by date");
        break;
    case 'search':          //查找
        /*http://127.0.0.1/maintainhistory/Index.php?act=maintain/showChart/2019-07-03/2019-07-10/3H/Beamforming */
        $startDate = __get('startDate');
        $stopDate = __get('stopDate');
        $filter = array();
        $sqlSub = null;
        $searchResult = null;

        if((diffBetweenTwoDays($startDate,$stopDate) !== false) && (diffBetweenTwoDays($startDate,$stopDate) <= 91)) {
            $tmpArr = array();
            $allCount  = array();

            //獲取篩選條件
            foreach (array('line','station','errCode','model') as $key)
            {
                if($$key != 'All') array_push($tmpArr,"{$key}='{$$key}'");
            }

            //處理篩選條件
            $sqlSub = implode(' and ', $tmpArr);
            $sqlSub = empty($sqlSub) ? null : $sqlSub . ' and ';

            $searchLineList = $conn->getLine("select line from maintainhistory where {$sqlSub} date between '{$startDate}' and '{$stopDate}' group by line order by line");
            $searchStationList = $conn->getLine("select station from maintainhistory where {$sqlSub} date between '{$startDate}' and '{$stopDate}' group by station order by station");


            if(!empty($searchLineList)) {
                foreach ($searchLineList as $searchLine) {
                    $lineCount = array();
                    foreach ($searchStationList as $searchStation) {
                        $lineCount += array($searchStation => $conn->getItemByItemName("select count(id) from maintainhistory where line='{$searchLine}' and station='{$searchStation}' and date between '{$startDate}' and '{$stopDate}'"));
                    }
                    $allCount += array($searchLine => $lineCount);
                }
            }
        } else {
            __showMsg("搜索的日期錯誤, 開始日期必須小雨結束日期, 且最多搜索的天數不大於90天.");
        }
        break;          //查找
}

$loadFile = file_exists("Form/Maintain/{$method}.php") ? "Form/Maintain/{$method}.php" : "Form/404.php";
include($loadFile);
