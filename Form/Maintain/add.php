<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/3
 * Time: 16:52
 */
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#formMaintainAdd').submit(function () {
            if($('#line').val() == "")
            {
                $('#line').focus();
                alert("線體不能為空.");
                return false;
            }
            if($('#model').val() == "")
            {
                $('#model').focus();
                alert("機種不能為空.");
                return false;
            }
            if($('#station').val() == "")
            {
                $('#station').focus();
                alert("站位不能為空.");
                return false;
            }
            if($('#device').val() == "")
            {
                $('#device').focus();
                alert("Device不能為空.");
                return false;
            }
            if($('#errClass').val() == "")
            {
                $('#errClass').focus();
                alert("類別不能為空.");
                return false;
            }
            if($('#errDesc').val() == "")
            {
                $('#errDesc').focus();
                alert("現象描述不能為空.");
                return false;
            }
            if($('#rootCause').val() == "")
            {
                $('#rootCause').focus();
                alert("異常原因不能為空.");
                return false;
            }
            if($('#causeAnalysis').val() == "")
            {
                $('#causeAnalysis').focus();
                alert("原因分析不能為空.");
                return false;
            }
            if($('#action').val() == "")
            {
                $('#action').focus();
                alert("對策不能為空.");
                return false;
            }
            if($('#result').val() == "")
            {
                $('#result').focus();
                alert("結果不能為空.");
                return false;
            }
            if($('#owner').val() == "")
            {
                $('#owner').focus();
                alert("處理人不能為空.");
                return false;
            }
        });
    });

</script>
<div id="divMaintainAdd" style="margin-top: 5px;">
    <form method="post" action="?act=maintain/add" id="formMaintainAdd">
<?php
include("Form/Maintain/Form.php");
?>
        <div><input type="reset" value="清空重填" class="button"><input type="submit" value="添加記錄" name="btnMaintainAdd" id="btnMaintainAdd"></div>
    </form>
</div>
