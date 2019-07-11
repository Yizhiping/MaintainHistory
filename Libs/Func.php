<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/6
 * Time: 13:31
 */

/**
 * 获取get/post/session变量的值, 没有的话返回null
 * @param $v    變量名
 * @return null
 */
function __get($v)
{
    $a = isset($_GET[$v]) ? $_GET[$v] : null;
    isset($a) || $a = isset($_POST[$v]) ? $_POST[$v] : null;
    isset($a) || $a = isset($_SESSION[$v]) ? $_SESSION[$v] : null;
    return $a;
}

/**
 * 在页面上显示一个弹框信息.
 * @param $msg 信息
 */
function __showMsg($msg)
{
//    str_replace('\(', '&#40;', $msg);
//    str_replace('\)', '&#41;', $msg);
    printf("<script type=text/javascript>alert(\"%s\");</script>",$msg);
}

/**
 * 使用js跳轉到指定地址
 * @param $url
 */
function __goUrl($url)
{
    printf("<script type=text/javascript>window.location.href=\"%s\"</script>",$url);
}

/**
 * 獲取遠端IP
 * @return string
 */
function __getIP()
{
    $addr = $_SERVER["REMOTE_ADDR"];
    if(empty($addr)) $addr = $_SERVER["HTTP_CLIENT_IP"];
    if(empty($addr)) $addr = $_SERVER["HTTP_X_FORWARDED_FOR"];
    if(empty($addr)) $addr = 'Unknown';
    return $addr;
}

/**
 * 創建一個按鈕
 * @param $type 類型，a button submit
 * @param $name name
 * @param $id id
 * @param $class class
 * @param $val value
 * @param $link href，a專用
 * @param $lab=null 是否使用Label,為空自動沒有
 */
function __createButton($type, $name, $id, $class, $val, $link, $lab=null)
{
    $htmlCode = "";
    $class .= " button blank";
    switch(strtoupper($type))
    {
        case "A":
            $htmlCode = "<a id='{$id}' name='{$name}' class='{$class}' href='{$link}'>{$val}</a>";
            break;

        case "BUTTON":
        case "SUBMIT":
            if($lab != null) $htmlCode .= "<lable for='{$name}'>{$lab}</lable>";
            $htmlCode .= "<input type='{$type}' id='{$id}' name='{$name}' class='{$class}' value='{$val}'/>";
            break;
    }
    echo $htmlCode;
}

/**
 * 創建一個下拉清單
 * @param $listArr  清單數組
 * @param null $name    名稱
 * @param null $id  id
 * @param null $class   類名
 * @param null $defaultVal  默認值
 * @param null $lab 標籤, 不賦值時不顯示標籤
 * @param false $disable 是否禁用
 */
function __createList($listArr, $name=null, $id=null, $class=null, $defaultVal=null, $lab=null, $disable=false)
{
    $html = null;
    if(!empty($lab)) $html .= "<lable for='{$name}'>{$lab}</lable>";
    $html .= "<select id='{$id}' name='{$name}' class='$class' ";
    $html .= $disable==true ? "disabled='disabled'>" : ">";
    $html .= "<option value='null'>請選擇</option>";
    foreach ($listArr as $i)
    {
        if($i == $defaultVal)
        {
            $html .= "<option value='{$i}' selected='selected'>{$i}</option>";
        } else {
            $html .= "<option value='{$i}'>{$i}</option>";
        }
    }
    $html .= "</select>";
    echo $html;
}

/**
 * 判斷是否為移動客戶端
 * @return bool
 */
function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

/**
 * 創建一個鏈接
 * @param $id
 * @param null $name
 * @param null $class
 * @param string $link
 * @param $desc
 */
function __createLink($id, $name=null, $class=null, $link='#', $desc)
{
    $html = null;
    $html .= "<a id='{$id}' name='{$name}' class='{$class}' href='{$link}' >{$desc}</a>";
    echo $html;
}

/**
 * 創建li清單
 * @param $itemList
 */
function __createSelectItem($itemList)
{
    if(is_array($itemList))
    {
        foreach ($itemList as $value)
        {
            echo "<li class='listOption'>{$value}</li>";
        }
    }
}

/**
 * 截取中文字符串
 * @param $str 要操作的字符串
 * @param $from 開始位置
 * @param $len  長度
 * @return null|string|string[]
 */
function subStr_cut($str,$from,$len)
{
    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
        '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
        '$1',$str);
}

/**
 * 計算兩個日期的天數, 如果day1 小于 day2 則返回 false
 * @param $day1
 * @param $day2
 * @return bool|float|int
 */
function diffBetweenTwoDays ($day1, $day2)
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);
    if ($second2 < $second1) {
        return false;
    } else {
        return ($second2 - $second1) / 86400;
    }
}

function printTab($tab)
{
    echo "<table>";
    foreach ($tab as $item)
    {
        echo "<tr>";
            foreach ($item as $val)
            {
                echo "<td style='border: 1px solid'>{$val}</td>";
            }
        echo "</tr>";
    }
    echo "</table>";
}