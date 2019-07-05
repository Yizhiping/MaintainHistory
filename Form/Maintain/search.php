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

    #tabCount{ table-layout:fixed;}

    #tabCount td{ word-break:break-word;}
    .selInput {
        width: 150px;
    }
    #line {
        width: 80px;
    }

    #errCode {
        width: 100px;
    }

    #tabCount {
        table-layout: fixed;
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

    #tabCount tr td:first-child {
        background-color: #000;
        color: #fff;
        font-weight: bold;
        /*         width: 30px; */
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
        border: 1px solid #666;
        word-wrap: break-word;
        width: 120px;
    }

</style>
<div>
    <div>
        <form method="post" action="?act=maintain/search">
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
                        <input class="selInput" id="line" name="line" value="<?php echo $line ?>">
                        <ul class="itemList">
                            <li class='listOption'>All</li>
                            <?php __createSelectItem($lineList) ?>
                        </ul>
                    </td>
                    <td>站別</td>
                    <td>
                        <input class="selInput" id="station" name="station" value="<?php echo $station ?>">
                        <ul class="itemList">
                            <li class='listOption'>All</li>
                            <?php __createSelectItem($stationList) ?>
                        </ul>
                    </td>
                    <td>錯誤代碼</td>
                    <td>
                        <input class="selInput" id="errCode" name="errCode" value="<?php echo $errCode ?>">
                        <ul class="itemList">
                            <li class='listOption'>All</li>
                            <?php __createSelectItem($errCodeList) ?>
                        </ul>
                    </td>
                    <td>機種</td>
                    <td>
                        <input class="selInput" id="model" name="model" value="<?php echo $model ?>">
                        <ul class="itemList">
                            <li class='listOption'>All</li>
                            <?php __createSelectItem($modelList) ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div>
        <table id="tabCount">
            <?php
            $firstRow = true;
            foreach ($allCount as $lineName=>$count)
            {
                if($firstRow)       //第一行, 打印標題
                {
                    $firstRow = false;
                    echo "<tr class='tabTile'><td></td>";
                    foreach ($count as $stationName=>$item)
                    {
                        echo "<td>{$stationName}</td>";
                    }
                    echo "</tr>";
                }
                echo "<tr>";
                $firstCol = true;
                foreach ($count as $stationName=>$item) {
                    if($firstCol) {
                        $firstCol = false;
                        echo "<td class='lineName'>{$lineName}</td>";
                    }
                    echo "<td>{$item}</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>
