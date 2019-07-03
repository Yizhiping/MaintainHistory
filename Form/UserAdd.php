<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/3
 * Time: 13:48
 */

$uid = strtoupper(trim(__get('uid')));
$pwd1 = __get('pwd1');
$pwd2 = __get('pwd2');
$name = __get('name');
$mail = __get('mail');
$err = null;

if($method == 'add')
{

    if(empty($uid) || !preg_match("/^[L,S][0-9,A][0-9]{7}$/", $uid))
    {
        $err .= "工號格式不正確." . chr(13);
        goto userAddEnd;
    }
    if(empty($pwd1) || $pwd1!=$pwd2)
    {
        $err .= "密碼不能為空, 且兩次密碼需一致." . chr(13);
        goto userAddEnd;
    }

    if(empty($name)) {
        $err .= "姓名為空." . chr(13);
        goto userAddEnd;
    }

    $userInfo = $user->sampleUserInfo;
    $userInfo['uid'] = $uid;
    $userInfo['pwd'] = $pwd1;
    $userInfo['name'] = $name;
    $userInfo['mail'] = $mail;

    if($user->userAdd($userInfo))
    {
        __showMsg('註冊成功, 如需設置權限, 請聯繫管理員.');
        __goUrl($homeUrl);
    } else {
        if($user->uconn->getErrNo() == 1062)
        {
            __showMsg("註冊失敗,用戶名已存在.");
        } else
        {
            __showMsg("註冊失敗, 請檢查註冊資料.");
        }
    }

    userAddEnd:
}




?>

<style>
    #divUserAdd table tr td:nth-child(1)
    {
        text-align: right;
    }
    #divUserAdd table tr td:nth-child(2)
    {
        text-align: left;
    }

</style>
<div style="color: red;"><?php echo $err?></div>
<div id="divUserAdd">
    <form method="post" action="?act=userAdd/add">
        <table>
            <tr>
                <td>賬號:</td>
                <td><input name="uid" id="uid" type="text" value="<?php echo $uid ?>"></td>
                <td>*賬號為9位工號</td>
            </tr>
            <tr>
                <td>密碼:</td>
                <td><input type="password" name="pwd1" id="pwd1" value="<?php echo $pwd1 ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td>確認密碼:</td>
                <td><input type="password" name="pwd2" id="pwd2" value="<?php echo $pwd2 ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td>姓名:</td>
                <td><input type="text" name="name" id="name" value="<?php echo $name ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td>郵箱:</td>
                <td><input type="text" name="mail" id="mail" value="<?php echo $mail ?>"></td>
                <td>*沒有則留空</td>
            </tr>
            <tr>
                <td><a href="<?php echo $homeUrl ?>">返回</a></td>
                <td style="text-align: right"><input type="submit" name="btnUserAdd" id="btnUserAdd" value="註冊"></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>
