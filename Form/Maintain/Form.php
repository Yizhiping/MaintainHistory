<?php
function __createSelectItem($itemList, $default)
{
    foreach ($itemList as $value)
    {
        if($default == $value)
        {
            echo "<option value='{$value}' selected='selected'>>{$value}</option>";
        } else {
            echo "<option value='{$value}'>{$value}</option>";
        }
    }
}

?>
<style>
    #divMaintainAdd select,#divMaintainAdd input[type='text']{
        width: 100%;
    }

    #divMaintainAdd textarea {
        overflow-y: scroll;
        width: 100%;
        height:100px;
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
<table>
    <tr>
        <td class="maintainTitle">日期:</td>
        <td>
            <select></select>
        </td>
        <td class="maintainTitle">時間:</td>
        <td>
            <select></select>
        </td>
        <td class="maintainTitle">班別:</td>
        <td>
            <select>
                <option value="Day">白班</option>
                <option value="Night">夜班</option>
            </select>
        </td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td class="maintainTitle">線體:</td>
        <td><input type="text" id="line" name="line" value="<?php echo $line ?>">
            <select id="selLine" name="selLine">
                <?php __createSelectItem($conn->getLine("select line from linelist order by line"), $line)   ?>
            </select>
        </td>
         <td class="maintainTitle">機種:</td>
        <td>
            <input type="text" id="model" name="model" value="<?php echo $model ?>">
            <select id="selModel" name="selModel">
                <?php __createSelectItem($conn->getLine("select name from modellist order by name"), $model)   ?>
            </select>
        </td>
        <td class="maintainTitle">站位:</td>
        <td title="發生異常的站位">
            <input type="text" id="station" name="station" value="<?php echo $station ?>">
            <select id="selStation" name="selStation">
                <?php __createSelectItem($conn->getLine("select name from stationlist order by name"), $station)   ?>
            </select>
        </td>
        <td class="maintainTitle">Device:</td>
        <td title="發生異常時測試程式顯示的不良代碼, 如沒有則留空."><input type="text" id="device" name="device" value="<?php echo $device ?>"></td>
        <td></td>
    </tr>
    <tr>
        <td class="maintainTitle">不良代碼:</td>
        <td><input type="text" id="errCode" name="errCode" value="<?php echo $errCode ?>"></td>
        <td class="maintainTitle">現象描述:</td>
        <td colspan="5"><input type="text" name="errDesc" id="errDesc" value="<?php echo $errDesc ?>"></td>
        <td class="notice">簡單描述異常的現象, 如產品不上電,測試程式無反應,XX項測試不良.</td>
    </tr>
    <tr>
        <td class="maintainTitle">異常原因:</td>
        <td colspan="7"><textarea name="rootCause" id="errDesc" ><?php echo $rootCause ?></textarea></td>
        <td class="notice">描述導致異常的原因, 如電源線接觸不良, 網絡無連接, Cable線舊損.</td>
    </tr>
    <tr>
        <td class="maintainTitle">原因分析:</td>
        <td colspan="7"><textarea name="causeAnalysis" id="causeAnalysis" ><?php echo $causeAnalysis ?></textarea></td>
        <td class="notice">描述導致異常的原因, 如線材使用壽命已盡, 治具接口未調準好, 校驗手法錯誤.</td>
    </tr>
    <tr>
        <td class="maintainTitle">對策:</td>
        <td colspan="7"><textarea name="action" id="action" ><?php echo $action ?></textarea></td>
        <td class="notice">描述針對異常所採取的的措施, 如更換線材, 重新調製治具, 重新做環境校驗.</td>
    </tr>
    <tr>
        <td class="maintainTitle">效果確認:</td>
        <td colspan="7"><input type="text" id="result" value="<?php echo $result ?>"></td>
        <td class="notice">描述執行對策后, 異常是否有所改善.</td>
    </tr>
    <tr>
        <td class="maintainTitle">處理人:</td>
        <td colspan="7"><input type="text" id="owner" value="<?php echo $owner ?>"></td>
        <td class="notice">該異常的責任人</td>
    </tr>
</table>