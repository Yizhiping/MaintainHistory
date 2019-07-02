<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 17:11
 */

if(!$user->authByRole('管理員')) goto pageEnd;

if(!empty(__get('btnUserAdd')))   //添加用戶
{
    $userInfo = $user->sampleUserInfo;
    $userInfo['uid'] = __get('uid');
    $userInfo['name'] = __get('uname');
    $userInfo['pwd'] = password_hash(__get('password'),PASSWORD_DEFAULT);
    $userInfo['mail'] = __get('mail');

    if(empty($userInfo['uid']) || empty($userInfo['pwd']))
    {
        __showMsg('用戶創建失敗, 用戶名和密碼不能為空.');
    } else {
        if ($user->userAdd($userInfo)) {
            __showMsg('用戶添加成功');
        } else {
            __showMsg("用戶添加失敗" . $user->uconn->getErr());
        }
    }
}

$uid = __get('userID');         //當前頁面操作的用戶ID
//刪除用戶
if(!empty(__get('btnUserDel')))
{
    //從用戶表,角色表刪除
    if($user->userDelete($uid))
    {
        __showMsg('用戶刪除成功.');
    } else {
        __showMsg('用戶刪除失敗');
    }

    //為接下來的操作賦值當前用戶為空,
    $uid = "";
}


//獲取所有用戶列表, 打印用戶下拉列表
$opstr = "";
foreach ($conn->getLine("select uid from users") as $u)
{
    if($uid == $u)
    {
        $opstr .= "<option selected='selected' value='{$u}'>{$u}</option>";
    } else {
        $opstr .= "<option value='{$u}'>{$u}</option>";
    }
}

//獲取所有角色信息
$roles = $conn->getAllRow("select name,code from role");

//更新用戶角色
if(!empty(__get('btnUpdateRole')))
{
    //刪除原有角色
    $user->delByUserFromURID($uid);

    //插入角色信息
    foreach ($roles as $r)
    {
        if(!empty(__get($r[1])))
        {
            $user->addByUserToURID($uid,$r[1]);
        }
    }
    __showMsg("角色信息更新成功.");
}

//獲取用戶角色URID, 以checkbox呈現當前用戶角色信息
$roleChkBoxstr = "";
$urids = $conn->getLine("select rid from urid where uid ='{$uid}'");    //獲取用戶角色信息
if(!is_array($urids)) $urids = array();                                        //如果沒有賦值空
foreach ( $roles as $r)
{
    if(in_array($r[1],$urids))
    {
        $roleChkBoxstr .= "<div><label for='{$r[1]}'>{$r[0]}</label><input type='checkbox' name='{$r[1]}' id='{$r[1]}' value='{$r[0]}' checked='checked'/></div>";
    } else {
        $roleChkBoxstr .= "<div><label for='{$r[1]}'>{$r[0]}</label><input type='checkbox' name='{$r[1]}' id='{$r[1]}' value='{$r[0]}'/></div>";
    }
}

?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#btnUserAdd').click(function (e) {
            if($('#uid').val() =="" || $('#uname').val()=="" || $('#password').val()=="")
            {
                alert('賬號,用戶名,密碼不能為空.');
                return false;
            }
        });
    });
</script>
<div id="divUserAdd" class="divSearch">
    <form action="?act=users&amp;subact=useradd" method="post" enctype="multipart/form-data" id="formUserAdd">

      <label for="uid">賬號名</label>
      <input type="text" name="uid" id="uid" style="width: 100px;" />
      <label for="uname">用戶名</label>
      <input type="text" name="uname" id="uname" style="width: 100px;" />
      <label for="password">密碼</label>
      <input type="text" name="password" id="password" style="width: 100px;" />
      <label for="mail">郵件</label>
      <input type="text" name="mail" id="mail" style="width: 100px;" />
<!--      <label for="description">說明</label>-->
<!--      <input type="text" name="description" id="description" style="width: 100px;" />-->
      <input type="submit" name="btnUserAdd" id="btnUserAdd" value="創建用戶" />
    </form>
</div>

<div id="divUserManagement" >
  <form action="?act=users&amp;subact=usermanagement" method="post" enctype="multipart/form-data" name="formUserManagement" id="formUserManagement">
      <div class="divSearch">
    <label>選擇用戶
      <select name="userID" id="userID">
          <option value="">選擇用戶</option>
        <?php echo $opstr ?>
      </select>
    </label>
      <input type="submit" name="btnUserDel" id="btnUserDel" value="刪除用戶" />
    <input type="submit" name="btnGetRole" id="btnGetRole" value="獲取用戶角色" />
      <input type="submit" name="btnUpdateRole" id="btnUpdateRole" value="更新用戶角色" />
      </div>
      <div><?php echo $roleChkBoxstr ?></div>
    
  </form>
</div>

<?php pageEnd: ?>