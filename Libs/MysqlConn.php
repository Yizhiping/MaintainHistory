<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/6
 * Time: 9:34
 */


class MysqlConn
{
    private $db_host;// = "127.0.0.1";
    private $db_userid; //= "root";
    private $db_password;//  = "root";
    private $db_dbname; // = "WareHouseManagement";
    public $conn;
    public  $lastSql;   //最後執行的sql
    private $err;
    private $errNo;     //錯誤代碼

    function __construct($host, $uid, $pwd, $db)
    {
        $this->db_host = $host;
        $this->db_userid = $uid;
        $this->db_password = $pwd;
        $this->db_dbname = $db;

        $this->conn = new mysqli($host, $uid, $pwd, $db);
        if($this->conn)
        {
            $this->conn->query("set names utf8");
        } else {
            die("数据库连接错误" + $this->conn->error);
        }
    }

//    function __destruct()
//    {
//        $this->conn->close();
//    }

    /**
     * @param $sql 需要運行的SQL
     * @return array|bool|null  執行成功返回获取到的表, 类型是二维数组
     */
    function getAllRow($sql)
    {
        $this->lastSql = $sql;
        $res = $this->conn->query($sql);
        if($res)
        {
            $tmpArr = array();
            while ($row = $res->fetch_assoc())
            {
                array_push($tmpArr,$row);
            }
            return $tmpArr;
        } else {
            return false;
        }
    }

    /**
     * @param $sql 需要执行的sql
     * @return bool|mixed   返回记录集的第一条记录
     */
    function getFristRow($sql)
    {
        $res = $this->getAllRow($sql);
        if($res)
        {
            $result = null;
            foreach ($res as $r)
            {
                $result = $r;
                break;
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param $sql 需要执行的sql
     * @return array|bool 执行成功返回记录集中的第一列. 执行失败返回false.
     */
    function getLine($sql)
    {
        $res = $this->getAllRow($sql);
        if($res)
        {
            $arr = array();
            foreach ($res as $r)
            {
                foreach ($r as $key=>$val)
                {
                    array_push($arr,$val);
                    break;
                }

            }
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * @param $sql 需要执行的sql
     * @return bool 执行成功返回符合条件的唯一结果, 执行失败或结果为空返回false.
     */
    function getItemByItemName($sql)
    {
        $res = $this->getAllRow($sql);
        if(sizeof($res)>0)
        {
            return $res[0][0];
        } else {
            return false;
        }
    }

    /**
     * @param $sql
     * @return bool|\mysqli_result 执行一句sql
     */
    public function query($sql)
    {
        $this->lastSql = $sql;
        if($this->conn->query($sql))
        {
            return true;
        } else {
            $this->err = $this->conn->error;
            $this->errNo = $this->conn->errno;
            return false;
        }
    }

    /**
     * 獲取錯誤
     * @return mixed
     */
    public function getErr()
    {
        return $this->err;
    }

    /**
     * 獲取錯誤代碼
     * @return mixed
     */
    public function getErrNo()
    {
        return $this->errNo;
    }
}

