<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/10
 * Time: 10:12
 */
 
?>
<?php ?>
<table width="563" border="0">
  <tr>
    <td width="100" align="right">id:</td>
    <td width="200" align="left"><?php echo $user->uid ?></td>
  </tr>
  <tr>
    <td align="right">賬戶名:</td>
    <td align="left"><?php echo $user->name ?></td>
  </tr>
  <tr>
    <td align="right">郵件:</td>
    <td align="left"><?php echo $user->mail ?></td>
  </tr>
<!--  <tr>-->
<!--      角色-->
<!--    <td align="right">群組:</td>-->
<!--    <td align="left">--><?php //echo $user->group ?><!--</td>-->
<!--  </tr>-->
  <tr>
    <td align="right">最後登錄時間:</td>
    <td align="left"><?php echo $user->lastLogin ?></td>
  </tr>
  <tr>
    <td align="right">最後登錄地址:</td>
    <td align="left"><?php echo $user->loginAddr ?></td>
  </tr>
  <tr>
    <td align="right">總登錄次數:</td>
    <td align="left"><?php echo $user->loginTimes ?></td>
  </tr>
</table>
