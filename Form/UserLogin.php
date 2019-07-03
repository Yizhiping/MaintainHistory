<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/6
 * Time: 16:15
 */
$uid = __get('uid');
$pwd = __get('password');

if(!empty(__get('btnUserLogin')))
{
    if(empty($uid) || empty($pwd))
    {
        __showMsg("账号和密码不能为空.");
    } else {
        if($user->login($uid, $pwd))
        {
           header("Location:" . $homeUrl);
        } else {
            __showMsg("账号或密码错误, 登录失败.");
        }
    }
}

?>
<script type="text/javascript">
$(document).ready(function(e) {
    $('#btnuserLogin').click( function(e)
	{
		if($('#uid').val()=="" || $('#password').val() == "")
		{
			alert("用戶名和密碼不能為空.");
			return false;
		} else 
		{
            return true;
		}
	}
	);
});
</script>
<style>
    #divUserLogin {
        left: 50%;
        top: 50%;
        position: absolute;
        transform: translate(-50%, -50%);
    }
    #divUserLogin table tr td:nth-child(1){
        float: left;
        width: 60px;
    }

    #divUserLogin table tr td:nth-child(2){
        float: right;
    }

    #divUserLogin table tr td{
        height: 40px;
    }
</style>
<div style="height: 100%; width: 100%; position: relative">
    <div id="divUserLogin">
        <form id="formUserLogin" enctype="multipart/form-data" action="?act=userLogin" method="post">
            <table>
                <tr>
                    <td>賬號</td>
                    <td><input id="uid" name="uid" type="text" value="<?php echo $uid ?>"/></td>
                </tr>
                <tr>
                    <td>密碼</td>
                    <td><input id="password" name="password" type="password" value="<?php echo $pwd ?>"/></td>
                </tr>
                <tr>
                    <td><a href="?act=userAdd">註冊</a></td>
                    <td><input type="submit" name="btnUserLogin" id="btnUserLogin" value="登入系统"></td>
                </tr>
            </table>
        </form>
    </div>
</div>