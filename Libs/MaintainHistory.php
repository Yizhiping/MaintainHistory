<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/3
 * Time: 15:11
 */

class MaintainHistory
{
    public $mconn;              //數據庫連接引用
    public $sampleHistory = array(
        'id'=>null,             //序號
        'time'=>null,           //時間
        'date'=>null,           //日期
        'shift'=>null,          //班別
        'line'=>null,           //線體
        'model'=>null,          //機種
        'station'=>null,        //站位
        'device'=>null,         //撥號,第幾機
        'errCode'=>null,        //錯誤代碼
        'errDesc'=>null,        //異常描述
        'rootCause'=>null,      //原因
        'causeAnalysis'=>null,  //原因分析
        'action'=>null,         //對策
        'result'=>null,         //結果
        'state'=>0,              //狀態
        'owner'=>null           //處理人
    );
    public function __construct()
    {
        global $conn;
        $this->mconn = $conn;
    }

    /**
     * 增加一條維護記錄, 數據格式如sampleHistory
     * @param $maintainHistory
     * @return bool
     */
    public function add($maintainHistory)
    {
        $maintainHistory = array_slice($maintainHistory,2);
        $sql = "insert into maintainhistory (date,shift, line, model, station, device, errCode, errDesc, rootCause, CauseAnalysis, zAction, result, state,owner)
              value ('" . implode("','",$maintainHistory) ."')";
        return $this->mconn->query($sql);
    }

    /**
     * 更新一條維護記錄
     * @param $id   序號
     * @param bool $rootCause   問題點
     * @param bool $causeAnalysis   原因分析
     * @param bool $action  對策
     * @param bool $result  結果
     * @return bool
     */
    public function update($id, $rootCause=false, $causeAnalysis=false, $action=false, $result=false)
    {
        $updateItem = array();
        if($rootCause != false) array_push($updateItem, "rootCause='{$rootCause}");
        if($causeAnalysis != false) array_push($updateItem, "causeAnalysis='{$causeAnalysis}");
        if($action != false) array_push($updateItem, "action='{$action}");
        if($result != false) array_push($updateItem, "result='{$result}");
        $sql = "update maintainhistory set " . implode(',',$updateItem) . " where id={$id}";
        return $this->mconn->query($sql);
    }

    public function search($fields=false, $filters=false, $sql=null)
    {
        $field = null;
        $filter = null;
        if($fields==false)
        {
            $field = "*";
        } else if(is_array($fields))
        {
            $field = implode(',',$fields);
        }

        if(is_array($filters))
        {
            $tmpArr = array();
            foreach ($filters as $key=>$val)
            {
                array_push($tmpArr,"{$key}='{$val}'");
            }
            if(!empty($tmpArr)) $filter = "and " . implode(' and ', $tmpArr);

        }

        $sqlStr = "select {$field} from maintainhistory where 1=1 {$filter}";
        $sqlStr .= $sql == null ? null: " and " . $sql;

        return $this->mconn->getAllRow($sqlStr);
    }

    /**
     * 刪除一條記錄
     * @param $id
     * @return bool|mysqli_result
     */
    public function del($id)
    {
        return $this->mconn->query("delete from maintainhistory where Id={$id}");
    }

}