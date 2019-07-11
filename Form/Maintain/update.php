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
        //部分欄位需要禁用
        $('#date').attr('disabled',true);
        $('#shift').attr('disabled',true);
        $('#line').attr('disabled',true);
        $('#model').attr('disabled',true);
        $('#station').attr('disabled',true);
        $('#device').attr('disabled',true);
        $('#errCode').attr('disabled',true);
        $('#owner').attr('disabled',true);
        $('#errClass').attr('disabled',true);
        $('#name').attr('disabled',true);
        $('#team').attr('disabled',true);


        //狀態為結案, 全部禁用.
        if($('#state').val()=='1') {
            $('#errDesc').attr('disabled', true);
            $('#rootCause').attr('disabled', true);
            $('#causeAnalysis').attr('disabled', true);
            $('#action').attr('disabled', true);
            $('#result').attr('disabled', true);
            $('#state').attr('disabled', true);
            $('#btnMaintainUpdate').attr('disabled', true);
        }

        $('#formMaintainAdd').submit(function () {
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
        });
    });

</script>
<div id="divMaintainAdd" style="margin-top: 5px;">
    <form method="post" action="?act=maintain/update/<?php echo $id ?>" id="formMaintainUpdate">
        <?php  include("Form/Maintain/Form.php");    ?>
        <div style="width: 1070px; margin-top: 5px;"><input style="float: right;" type="submit" value="更新記錄" name="btnMaintainUpdate" id="btnMaintainUpdate"></div>
    </form>
</div>
