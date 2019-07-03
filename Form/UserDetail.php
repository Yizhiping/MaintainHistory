<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 10:12
 */

$oldPwd = __get('oldPwd');
$newPwd1 = __get('newPwd1');
$newPwd2 = __get('newPwd2');

if($method=='changePassword') {
    if($newPwd1 == $newPwd2 && !empty($newPwd1) && !empty($newPwd2))
    {
        if($user->changePassword($user->uid, $oldPwd, $newPwd1))
        {
            __showMsg('密碼修改成功, 請以新密碼重新登錄系統.');
            __goUrl($homeUrl . '?act=userLogout');
        } else {
            __showMsg("舊密碼驗證失敗.");
        }
    } else {
        __showMsg("密碼修改失敗, 兩次新密碼對比錯誤.");
    }
}

?>
<style>
    #tabUserInfo {
        width: 800px;
    }
    #tabUserInfo td {
        border-bottom: 1px solid #222222;
        border-right: 1px solid #222222;

    }
    #tabUserInfo tr td:nth-child(1) {
        text-align: right;
        width: 150px;
    }
    #tabUserInfo tr td:nth-child(2) {
        text-align: left;
        width: 650px;
    }

    #formChangePassword input[type='password']{
        width: 200px;
    }
</style>
<table>
    <tr>
        <td>
            <table border="0" id="tabUserInfo">
              <tr>
                <td>id:</td>
                <td><?php echo $user->uid ?></td>
              </tr>
              <tr>
                <td>賬戶名:</td>
                <td><?php echo $user->name ?></td>
              </tr>
              <tr>
                <td>郵件:</td>
                <td><?php echo $user->mail ?></td>
              </tr>
              <tr>
                    <td>角色:</td>
                    <td><?php echo empty($user->role) ? null : implode(',', $user->role) ?></td>
                </tr>
                <tr>
                    <td>權限:</td>
                    <td><?php echo empty($user->fun) ? null : implode(',', $user->fun) ?></td>
                </tr>
              <tr>
                <td>最後登錄時間:</td>
                <td><?php echo $user->lastLogin ?></td>
              </tr>
              <tr>
                <td>最後登錄地址:</td>
                <td><?php echo $user->loginAddr ?></td>
              </tr>
              <tr>
                <td>總登錄次數:</td>
                <td><?php echo $user->loginTimes ?></td>
              </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <form method="post" action="?act=userDetail/changePassword" id="formChangePassword">
                <table>
                    <tr>
                        <td>原密碼:</td>
                        <td><input type="password" name="oldPwd" id="oldPwd"></td>
                    </tr>
                    <tr>
                        <td>新密碼:</td>
                        <td><input type="password" name="newPwd1" id="newPwd1"></td>
                    </tr>
                    <tr>
                        <td>確認新密碼:</td>
                        <td><input type="password" name="newPwd2" id="newPwd2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="right"><input type="submit" name="btnChangePassword" value="變更密碼"></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>