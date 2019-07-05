<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/11
 * Time: 17:06
 */

if(!$user->authByRole('管理員')) goto pageEnd;

//創建功能
$funDesc = __get('iptFunDesc');
if(!empty(__get('btnCreateFun')))
{
    if(empty($funDesc))
    {
        __showMsg('功能名稱不能為空.');
    } else{
        if($user->funAdd($funDesc))
        {
            __showMsg('功能創建成功');
        } else{
            __showMsg('功能創建失敗,' . $user->uconn->getErr());
        }
    }
}

//刪除功能
if(!empty(__get('btnFunDel')))
{
    foreach ($conn->getAllRow("select code from fun") as $f)
    {
        if(!empty(__get($f[0])))
        {
            $user->funDelete($f[0]);
        }
    }
    __showMsg('功能刪除成功.');
}

//以checkbox呈現所有功能
$funListstr = "";
foreach ($conn->getAllRow("select code,name from fun order by Name") as $fun)
{
    $funListstr .= "<li><label for='{$fun['code']}'>{$fun['name']}</label><input type='checkbox' id='{$fun['code']}' name='{$fun['code']}' value='{$fun['code']}'/></li>";
}

?>
<form action="?act=fun" method="post" enctype="multipart/form-data" name="formFun" id="formFun">
<div>
    <div class="divSearch">
      <label for="iptFunDesc">功能描述</label>
      <input type="text" name="iptFunDesc" id="iptFunDesc" />
      <input type="submit" name="btnCreateFun" id="btnCreateFun" value="創建功能" />
        <input type="submit" name="btnFunDel" id="btnFunDel" value="刪除選擇的功能" />
    </div>
    <div>
    	<ul>
            <?php echo $funListstr ?>
        </ul>

    </div>
</div>
</form>

<?php pageEnd:?>