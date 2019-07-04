<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/3
 * Time: 16:52
 */
?>
<div>
    <form method="post" action="?act=maintain/search">
        <table>
            <tr>
                <td>日期篩選:</td>
                <td><input id="startDate" name="startDate" type="date" value="<?php echo empty($startDate) ? date('Y-m-d', time()-7*24*60*60) : $startDate; ?>">~
                    <input id="stopDate" name="stopDate" type="date" value="<?php echo empty($stopDate) ? date('Y-m-d') : $stopDate ?>"></td>
                <td>線別:</td>
                <td>
                    <input id="line" name="line" class="selInput" value="<?php echo $line ?>" style="width: 150px;">
                    <ul class="itemList"><?php __createSelectItem($conn->getLine("select line from linelist order by line"))?></ul>
                </td>
                <td>狀態</td>
                <td>
                    <select name="state">
                        <option value="All">所有</option>
                        <option value="0" <?php echo $state == "0" ? "selected='selected'" : null?>>未結案</option>
                        <option value="1" <?php echo $state == "1" ? "selected='selected'" : null?>>已結案</option>
                    </select>
                </td>
                <td><input type="submit" value="查詢" id="btnMaintainSearch" name="btnMaintainSearch"></td>
            </tr>
        </table>
    </form>
</div>
<div>
<?php
    if(count($searchResult) >= 1 && is_array($searchResult))
    {
        echo "<table>";
        echo "<tr><td>序號</td><td>日期</td><td>線體</td><td>站位</td><td>代碼</td><td>現象</td><td>原因</td><td>狀態</td><td></td></tr>";
        $i = 0;
        foreach ($searchResult as $result)
        {
            $i++;
            $stateStr = $result['state'] == '1' ? "已結案" : "未結案";
            $linkStr = "<a href='{$homeUrl}?act=maintain/update/{$result['Id']}'>修改</a>";
            echo "<tr><td>{$i}</td><td>{$result['date']}</td><td>{$result['line']}</td><td>{$result['station']}</td><td>{$result['errCode']}</td><td>{$result['errDesc']}</td><td>{$result['rootCause']}</td><td>{$stateStr}</td><td>{$linkStr}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "沒有搜索結果";
    }
?>
</div>