<style>


    #divMaintainAdd select,#divMaintainAdd input[type='text'],#divMaintainAdd input[type='date']{
        width: 150px;
        font-size: 0.8em;
    }

    #divMaintainAdd textarea {
        overflow-y: scroll;
        width: 100%;
        height:100px;
        font-size: 0.8em;
    }

    #divMaintainAdd table tr td{
        border-bottom: 1px solid #666;
    }

    #divMaintainAdd .notice
    {
        font-size: 0.7em;
        text-align: left;
        color: blueviolet;
    }
    #divMaintainAdd .maintainTitle {
        width: 100px;
        text-align: right;
    }
</style>
<table id="tabMaintainForm">
    <tr>
        <td class="maintainTitle">日期:</td>
        <td>
            <input type="date" id="date" name="date" value="<?php echo empty($date) ? date("Y-m-d") : $date ;?>" class="input">
        </td>
        <td class="maintainTitle">班別:</td>
        <td>
            <select id="shift" name="shift">
                <option value="Day">白班</option>
                <option value="Night"
                <?php
                if(empty($shift)) {
                    if(((int)date('H')) >= 20 &&((int)date('H')) < 8) echo " selected = selected";
                } else if($shift=='Night') {
                    echo " selected = selected";
                }

                    ?>
                >夜班</option>
            </select>
        </td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td class="maintainTitle">線體:</td>
        <td title="發生異常時的所在綫體"><input type="text" id="line" name="line" value="<?php echo $line ?>" class="selInput">
            <ul id="selLine" name="selLine" class="itemList">
                <?php __createSelectItem($conn->getLine("select line from linelist order by line"))   ?>
            </ul>
        </td>
         <td class="maintainTitle">機種:</td>
        <td title="發生異常的機種">
            <input type="text" id="model" name="model" value="<?php echo $model ?>" class="selInput">
            <ul id="selModel" name="selModel" class="itemList">
                <?php __createSelectItem($conn->getLine("select name from modellist order by name"))   ?>
            </ul>
        </td>
        <td class="maintainTitle">站位:</td>
        <td title="發生異常的站位">
            <input type="text" id="station" name="station" value="<?php echo $station ?>" class="selInput">
            <ul id="selStation" name="selStation" class="itemList">
                <?php __createSelectItem($conn->getLine("select name from stationlist order by name"))   ?>
            </ul>
        </td>
        <td class="maintainTitle">Device:</td>
        <td title="發生異常的站位的撥號,或是第幾機."><input type="text" id="device" name="device" value="<?php echo $device ?>"></td>
        <td></td>
    </tr>
    <tr>
        <td class="maintainTitle">不良代碼:</td>
        <td title="發生異常時測試程式顯示的不良代碼, 如沒有則留空.">
            <input type="text" id="errCode" name="errCode" value="<?php echo $errCode ?>" class="selInput">
            <ul id="selErrCode" name="selErrCode" class="itemList">
                <?php __createSelectItem($conn->getLine("select code from errorcode order by code"))   ?>
            </ul>
        </td>
        <td class="maintainTitle">異常類別:</td>
        <td>
            <input type="text" id="errClass" name="errClass" value="<?php echo $errClass ?>" class="selInput">
            <ul id="selErrClass" name="selErrClass" class="itemList">
                <?php __createSelectItem($conn->getLine("select name from errorClass order by name"))   ?>
            </ul>
        </td>
        <td class="maintainTitle">現象描述:</td>
        <td colspan="3" title="簡單描述異常的現象, 如產品不上電,測試程式無反應,XX項測試不良."><input type="text" name="errDesc" id="errDesc" value="<?php echo $errDesc ?>" style="width: 100%;"></td>
    </tr>
    <tr>
        <td class="maintainTitle">異常原因:</td>
        <td colspan="8"><textarea name="rootCause" id="rootCause" ><?php echo $rootCause ?></textarea></td>
    </tr>
    <td></td>
    <td class="notice" colspan="8">描述導致異常的原因, 如電源線接觸不良, 網絡無連接, Cable線舊損.</td>
    <tr>
        <td class="maintainTitle">原因分析:</td>
        <td colspan="8"><textarea name="causeAnalysis" id="causeAnalysis" ><?php echo $causeAnalysis ?></textarea></td>
    </tr>
    <tr>
        <td></td>
        <td class="notice" colspan="8">描述導致異常的原因, 如線材使用壽命已盡, 治具接口未調準好, 校驗手法錯誤.</td>
    </tr>
    <tr>
        <td class="maintainTitle">對策:</td>
        <td colspan="8"><textarea name="action" id="action" ><?php echo $action ?></textarea></td>
    </tr>
    <tr>
        <td></td>
        <td class="notice" colspan="8">描述針對異常所採取的的措施, 如更換線材, 重新調製治具, 重新做環境校驗.</td>
    </tr>
    <tr>
        <td class="maintainTitle">效果確認:</td>
        <td colspan=8" title="描述執行對策后, 異常是否有所改善."><input type="text" id="result" name="result" value="<?php echo $result ?>" style="width: 100%;"></td>
    </tr>
    <tr>
        <td>狀態:</td>
        <td>
            <select name="state" id="state">
                <option value="0">未結案</option>
                <option value="1" <?php echo $state == "1" ? "selected='selected'" : null?>>已結案</option>
            </select>
        </td>
        <td class="maintainTitle">處理人:</td>
        <td colspan="8" title="該異常的責任人"><input readonly="readonly" type="text" id="owner" name="owner" value="<?php echo $owner ?>" style="width: 100%;"></td>
    </tr>
</table>