<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/5
 * Time: 17:22
 */
//***********************************獲取各個下拉列表的清單****************************
$lineList = $conn->getLine("select line from linelist order by line");
$stationList = $conn->getLine("select name from stationlist order by name");
$errCodeList = $conn->getLine("select code from errorcode order by code");
$modelList = $conn->getLine("select name from modellist order by name");
?>

<style>
    .selInput {
        width: 150px;
    }
    #line {
        width: 80px;
    }

    #errCode {
        width: 100px;
    }
    #tabCount tr:first-child {
        background-color: #000;
        color: #fff;
        font-weight: bold;
    }

    #tabCount tr:first-child td{
        /*         height: 30px; */
        padding: 0 0.4em 0;
        text-align: center;
    }

    #tabCount tr not::marker{
        text-align: center;
        padding: 0 0.5em 0;
        background-color: #eee
    }
    #tabCount tr td {
        text-align: center;
        border-bottom: 1px solid #666;
        border-right: 1px solid #666;
        font-size: 0.8em;
    }
    #tabCount tr td a{
        color: #000;
        text-decoration: none;
        display: block;
        width: 100%;
        height: 100%;
        line-height: 100%;
    }

    #tabCount tr td a:hover{
        background-color: #222222;
        color: #fff;
    }

    #tabCount tr:hover {
        background-color: #2BBBAD;
    }

</style>
<div>
    <div>
        <form method="post" action="?act=maintain/list">
            <table>
                <tr>
                    <td>日期篩選:</td>
                    <td colspan="6"><input id="startDate" name="startDate" type="date" value="<?php echo empty($startDate) ? date('Y-m-d', time()-7*24*60*60) : $startDate; ?>">~
                        <input id="stopDate" name="stopDate" type="date" value="<?php echo empty($stopDate) ? date('Y-m-d') : $stopDate ?>"></td>
                    <td><input type="submit" value="查找" id="btnMaintainSearch" name="btnMaintainSearch" class="button"></td>
                </tr>
                <tr>
                    <td>線別</td>
                    <td>
                        <input class="selInput" id="line" name="line" value="<?php echo $line==null ? 'All' : $line ?>">
                        <ul class="itemList">
                            <li class='listOption'>All</li>
                            <?php __createSelectItem($lineList) ?>
                        </ul>
                    </td>
                    <td>站別</td>
                    <td>
                        <input class="selInput" id="station" name="station" value="<?php echo $station==null ? 'All' : $station ?>">
                        <ul class="itemList">
                            <li class='listOption'>All</li>
                            <?php __createSelectItem($stationList) ?>
                        </ul>
                    </td>
                    <td>錯誤代碼</td>
                    <td>
                        <input class="selInput" id="errCode" name="errCode" value="<?php echo $errCode==null ? 'All' : $errCode ?>">
                        <ul class="itemList">
                            <li class='listOption'>All</li>
                            <?php __createSelectItem($errCodeList) ?>
                        </ul>
                    </td>
                    <td>機種</td>
                    <td>
                        <input class="selInput" id="model" name="model" value="<?php echo $model==null ? 'All' : $model ?>">
                        <ul class="itemList">
                            <li class='listOption'>All</li>
                            <?php __createSelectItem($modelList) ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div style="margin-top: 5px;">
        <?php
        if(empty($searchResult))
        {
            echo "沒有可以顯示的內容, 請更換搜索條件重試.";

        } else {
            $firstRow = true;
            $idx = 0 ;
            echo "<table id='tabCount'>";
            foreach ($searchResult as $titleName => $val) {
                $idx++;
                if ($firstRow)       //第一行, 打印標題
                {
                    $firstRow = false;
                    echo "<tr class='tabTile'>";
                    foreach (array('序號','日期','團隊','線體','站位','代碼','類別','描述','原因','狀態','View') as $item) {
                        echo "<td>{$item}</td>";
                    }
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td>{$idx}</td>";
                echo "<td>{$val['date']}</td>";
                echo "<td>{$val['team']}</td>";
                echo "<td>{$val['line']}</td>";
                echo "<td>{$val['station']}</td>";
                echo "<td>{$val['errCode']}</td>";
                echo "<td>{$val['errClass']}</td>";
                echo "<td>{$val['errDesc']}</td>";
                echo "<td>{$val['rootCause']}</td>";
                printf("<td>%s</td>", $val['state'] == 1 ? '已結案' : '未結案');
                printf("<td><a href='?act=maintain/view/%d' target='maintainHistory_view'>查看</a></td>", $val['id']);
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
</div>
