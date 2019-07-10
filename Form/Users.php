<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 17:11
 */

if(!$user->authByRole('管理員')) goto pageEnd;

//添加用戶
if(!empty(__get('btnUserAdd')))
{
    $teamAdd = __get('team');
    $userInfo = $user->sampleUserInfo;
    $userInfo['uid'] = __get('uid');
    $userInfo['name'] = __get('uname');
    $userInfo['pwd'] = password_hash(__get('password'),PASSWORD_DEFAULT);
    $userInfo['mail'] = __get('mail');

    if(empty($userInfo['uid']) || empty($userInfo['pwd']))
    {
        __showMsg('用戶創建失敗, 用戶名和密碼不能為空.');
    } else {
        if ($user->userAdd($userInfo,$teamAdd)) {
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
$allUsers = $conn->getAllRow("select uid,name from users");

//獲取所有角色信息
$allRoles = $conn->getAllRow("select code,name from role");

//獲取所有團隊
$allTeams = $conn->getLine("select name from teamlist");

//更新用戶角色
if(!empty(__get('btnUpdateRole')))
{
    //刪除原有角色
    $user->delByUserFromURID($uid);

    //插入角色信息
    foreach ($allRoles as $r)
    {
        if(!empty(__get($r['code'])))
        {
            $user->addByUserToURID($uid,$r['code']);
        }
    }
    __showMsg("角色信息更新成功.");
}

//獲取用戶角色ID
$roleForUid = $user->getRoleByUid($uid,'code');
if(!$roleForUid) $roleForUid = array();                 //無角色的時候賦值空數組

//更新用戶團隊
if(!empty(__get('btnUpdateTeam')))
{
    $tmpArr = array();
    foreach ($allTeams as $item)
    {
        if(!empty(__get($item))){
            array_push($tmpArr, __get($item));
        }
    }
    if($user->updateUserTeam($uid, $tmpArr))
    {
        __showMsg("用戶團隊更新成功");
    }
}

//獲取用戶團隊
$teamForUid = $user->getTeamByUid($uid);
if(empty($teamForUid)) $teamForUid = array();

?>
<style>

    .InfoTitle {
        background-color: #222;
        color: #fff;
        text-align: center;
    }

    .InfoTitle td {
        width: 200px;
    }

    #userRole td:first-child,#userTeam td:first-child{
        text-align: right;
    }
    #userRole td:nth-child(2),#userTeam td:nth-child(2){
        text-align: left;
    }

    #userRole td,#userTeam td{
        width: 100px;
        text-align: center;
        border-bottom: 1px solid #222;
    }
</style>
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
    <table>
        <tr>
      <td>賬號名</td>
      <td><input type="text" name="uid" id="uid" style="width: 100px;" /></td>
      <td>用戶名</td>
            <td><input type="text" name="uname" id="uname" style="width: 100px;" /></td>
            <td>密碼</td>
            <td><input type="text" name="password" id="password" style="width: 100px;" /></td>
            <td>郵件</td>
            <td><input type="text" name="mail" id="mail" style="width: 100px;" /></td>
            <td>團隊</td>
            <td>
                <input type="text" name="team" id="team" style="width: 100px;" class="selInput"/>
                <ul class="itemList">
                    <?php __createSelectItem($conn->getLine("select name from teamlist"));  ?>
                </ul>

            </td>
            <td><input type="submit" name="btnUserAdd" id="btnUserAdd" value="創建用戶" /></td>
        </tr>
    </form>
    </table>
</div>

<div id="divUserManagement" >
  <form action="?act=users&amp;subact=usermanagement" method="post" enctype="multipart/form-data" name="formUserManagement" id="formUserManagement">
      <div class="divSearch">
        <label>選擇用戶</label>
          <select name="userID" id="userID">
              <option value="">選擇用戶</option>
                <?php
                foreach ($allUsers as $item)
                {
                    if($item['uid'] == $uid)
                    {
                        echo "<option value='{$item['uid']}' selected='selected'>{$item['name']}</option>";
                    } else {
                        echo "<option value='{$item['uid']}'>{$item['name']}</option>";
                    }
                }
                ?>
          </select>

        <input type="submit" name="btnUserDel" id="btnUserDel" value="刪除用戶" />
        <input type="submit" name="btnGetRole" id="btnGetRole" value="獲取用戶角色" />
        <input type="submit" name="btnUpdateRole" id="btnUpdateRole" value="更新用戶角色" />
        <input type="submit" name="btnGetRole" id="btnGetRole" value="獲取用戶團隊" />
        <input type="submit" name="btnUpdateTeam" id="btnUpdateTeam" value="更新用戶團隊" />
      </div>
      <div id="showUserInfo">
          <table>
              <tr class="InfoTitle">
                  <td>角色</td>
                  <td>團隊</td>
              </tr>
              <tr>
                  <td valign="top">
                      <table id="userRole">
                          <?php
                            foreach ($allRoles as $item)
                            {
                                $isChecked = null;
                                if(in_array($item['code'],$roleForUid)) $isChecked = "checked='checked'";
                                echo "<tr><td>{$item['name']}</td><td><input type='checkbox' name='{$item['code']}' value='{$item['code']}' {$isChecked} /></td></tr>";
                            }
                          ?>
                      </table>
                  </td>
                  <td valign="top">
                      <table id="userTeam">
                          <?php
                            foreach ($allTeams as $item)
                            {
                                $isChecked = null;
                                if(in_array($item,$teamForUid)) $isChecked = "checked='checked'";
                                echo "<tr><td>{$item}</td><td><input type='checkbox' name='{$item}' value='{$item}' {$isChecked} /></td></tr>";
                            }
                          ?>
                      </table>
                  </td>
              </tr>
          </table>
      </div>
  </form>
</div>

<?php pageEnd: ?>