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
        $('#errDesc').attr('disabled', true);
        $('#rootCause').attr('disabled', true);
        $('#causeAnalysis').attr('disabled', true);
        $('#action').attr('disabled', true);
        $('#result').attr('disabled', true);
        $('#state').attr('disabled', true);
        $('#btnMaintainUpdate').attr('disabled', true);
    });

</script>
<div id="divMaintainAdd" style="margin-top: 5px;">
        <?php
        include("Form/Maintain/Form.php");
        ?>
</div>
