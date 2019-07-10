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
//对进行过按数量进行排序
array_multisort(array_column($allCount,'count'), SORT_ASC, $allCount);

?>
<script type="text/javascript" src="Script/excanvas.js"></script>
<script type="text/javascript" src="Script/loongchart.core.min.js"></script>
<script type="text/javascript" src="Script/loongchart.pie.min.js"></script>
<script type="text/javascript" src="Script/loongchart.bar.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var data = [
            <?php
                $tmpArr = array();
            foreach ($allCount as $item)
            {
                array_push($tmpArr,'{ text: "' . $item['name'] .'", value:' . $item['count'] .'}');
            }
            echo implode(',' . chr(13),$tmpArr);

            ?>
        ];
        var options = {
            title: { content: '前十大不良' }
            //subTitle: { content: 'Let see which brower shares the most.' }
        };
        (new LChart.Bar('myChart', 'CN')).SetSkin('BlackAndWhite').Draw(data, options);
        (new LChart.Pie('myChart1', 'CN')).SetSkin('BlackAndWhite').Draw(data, options);
    });
    //$(document).ready(
    //    var data = [
    //        <?php
    //        $tmpArr = array();
    //        foreach ($allCount as $item)
    //        {
    //            array_push($tmpArr,'{ text: "' . $item['name'] .'", value:' . $item['count'] .'}');
    //        }
    //        echo implode(',' . chr(13),$tmpArr);
    //
    //        ?>
    //    ];
    //    var options = {
    //        title: { content: '前十大不良' }
    //        //subTitle: { content: 'Let see which brower shares the most.' }
    //    };
    //    (new LChart.Bar('myChart', 'CN')).SetSkin('BlackAndWhite').Draw(data, options);
    //);
</script>
<style>
    table{ table-layout:fixed;}
    table td{ word-break:break-word;}

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
        width: 120px;
    }
    #tabCount tr td a{
        color: #000;
        text-decoration: none;
    }
    #showChart {
        display: inline-table;
    }

    #showChart div {
        float: left;
    }
</style>
<div>
    <div>
        <form method="post" action="?act=maintain/chart">
            <table>
                <tr>
                    <td>日期:</td>
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
                <tr>
                    <td>统计依据</td>
                    <td>
                        <select name="filterBy">
                            <option value="errCode">錯誤代碼</option>
                            <option value="line">線體</option>
                            <option value="model">機種</option>
                            <option value="team">團隊</option>
                        </select>
                    </td>
                    <td colspan="5"></td>
                </tr>
            </table>
        </form>
    </div>
    <div style="margin-top: 5px; display: inline-block;" id="showChart">
        <div id="myChart" style="width: 500px; height: 300px;"></div>
        <div id="myChart1" style="width: 500px; height: 300px;"></div>
    </div>
</div>
