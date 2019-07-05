<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/11
 * Time: 10:42
 */
if(!$user->authByRole('管理員')) goto pageEnd;

$rid = __get('role');
$rDesc = __get("iptRoleDesc");
//新增角色
if(!empty(__get("btnRoleCreate")))
{
    if(empty($rDesc))
    {
        __showMsg('角色描述不能爲空.');
    } else {
        if($user->roleAdd($rDesc))
        {
            __showMsg('角色創建成功.');
        } else {
            __showMsg('角色創建失敗.' . $user->uconn->getErr());
        }
    }

}

//刪除角色
if(!empty(__get("btnRoleDel")))
{
    if($user->roleDelete($rid))
    {
        __showMsg('角色刪除成功.');
    } else {
        __showMsg('角色刪除失敗.' . $user->uconn->getErr());
    }
}

//獲取所有角色清單
$roleList = $conn->getAllRow("select name,code from role order by  Name");
//獲取所有權限清單
$funList  = $conn->getAllRow('select code,name from fun order by Name');

//更新角色權限
if(!empty(__get('btnUpdateRoleInfo')))
{
    //刪除所有角色權限
    $user->delByRoleFromRFID($rid);
    foreach ($funList as $fun)
    {
        if(!empty(__get($fun['code'])))
        {
            $user->addByRoleToRFID($rid, $fun['code']);
        }
    }
    __showMsg("角色權限更新成功.");
}

//獲取當前角色所有權限
@$rfids = $conn->getLine("select fid from rfid where rid='{$rid}'");


if(!is_array($rfids)) $rfids = array();     //如有沒有直接賦值空數組

//以checkbox呈現角色權限
$checkBoxStr = "";
foreach ($funList as $fun)
{
    if(in_array($fun['code'],$rfids)) {
        $checkBoxStr .= "<div><label for='{$fun['code']}'>{$fun['name']}</label><input type='checkbox' name='{$fun['code']}' id='{$fun['code']}' value='{$fun['code']}' checked='checked'/></div>";
    } else {
        $checkBoxStr .= "<div><label for='{$fun['code']}'>{$fun['name']}</label><input type='checkbox' name='{$fun['code']}' id='{$fun['code']}' value='{$fun['code']}'/></div>";
    }
}

//生成角色下拉清單
$roleListStr = "";
foreach ($roleList as $role)
{
    if($rid == $role['code'])
    {
        $roleListStr .= "<option value='{$role['code']}' selected='selected'>{$role['name']}</option>";
    } else {
        $roleListStr .= "<option value='{$role['code']}'>{$role['name']}</option>";
    }
}

 ?>
<script type="text/javascript">
    $(document).ready(function(e){
        $('#btnRoleCreate').click(function(e){
            if($('#iptRoleDesc').val()=="")
            {
                alert('角色描述不能爲空.');
                return false;
            } else {
                return true;
            }
        });
    });
</script>
 <form action="?act=roles" method="post" enctype="multipart/form-data" name="formRole">
   <div class="divSearch">
      <label for="iptRoleDesc">角色描述</label>
      <input type="text" name="iptRoleDesc" id="iptRoleDesc" />
        <input type="submit" name="btnRoleCreate" id="btnRoleCreate" value="創建角色" />
   </div>
   <div class="divSearch">
     <label for="role">角色</label>
   <select name="role" id="role">
       <option>選擇角色</option>
        <?php echo $roleListStr ?>
   </select>
   <input type="submit" name="btnRoleDel" id="btnRoleDel" value="刪除角色" />
   <input type="submit" name="btnGetRoleInfo" id="btnGetRoleInfo" value="獲取角色權限" />
   <input type="submit" name="btnUpdateRoleInfo" id="btnUpdateRoleInfo" value="更新角色權限" />
   </div>
     <div style="margin-left: 5px; margin-top: 5px;">
         <?php echo $checkBoxStr ?>
     </div>

 </form>

<?php pageEnd: ?>