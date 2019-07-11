
<style>
    #showList {
        text-align: center;
        font-size: 0.8em;
    }
    #showList .listTitle {
        color: #fff;
        background-color: #222222;
    }

    #showList .listTitle td {
        text-align: center;
        height: 30px;
        padding: 0 0.3em 0;
    }

    #showList .idx {
        text-align: center;
    }

    #showList tr td {
        border-bottom: 1px solid #222;
        border-right: 1px solid #222;
        padding: 0 0.1em 0;
    }

    #showList a {
        display: block;
        height: 100%;
        width: 100%;
        color: #000;
    }

    #showList a:hover {
        color: #fff;
        background-color: #000;
    }

</style>
<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/11
 * Time: 13:40
 */
echo "<div id='showList'>";
$firstRow = false;
echo "<table>";
$idx = 0;
foreach ($result as $item)
{
    $idx++;
    if($firstRow == false)
    {
        $firstRow = true;
        echo "<tr class='listTitle'>";
        foreach (array('序號','機種','站位','異常代碼','異常現象','原因分析','對策','查看') as $title)
        {
            echo "<td>{$title}</td>";
        }
        echo "</tr>";
    }
    echo "<tr>";
    echo "<td class='idx'>{$idx}</td>";
    echo "<td>{$item['model']}</td>";
    echo "<td>{$item['station']}</td>";
    echo "<td>{$item['errCode']}</td>";
    printf("<td class='textLeft'>%s</td>",subStr_cut($item['errDesc'],0,10));
    printf("<td class='textLeft'>%s</td>",subStr_cut($item['causeAnalysis'],0,10));
    printf("<td class='textLeft'>%s</td>",subStr_cut($item['zAction'],0,10));
    echo "<td><a href='?act=maintain/view/{$item['id']}' target='maintainView'>查看詳情</a></td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";