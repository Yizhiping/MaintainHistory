<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/6/6
 * Time: 14:35
 */

class User
{
    public $uid;                //账号名称
    public $name;               //用户名称
    public $mail;               //邮件
    public $enable;             //用戶是否啟用
    public $lastLogin;          //最后登录时间
    public $loginAddr;          //最后登录地址
    public $loginTimes;         //登录次数
    public $role;               //用戶角色
    public $fun;                //用戶權限
    public $uconn;
    public $isLogined = false;

    public $sampleUserInfo = array(
        'uid'   => null,
        'pwd'   => null,
        'name'  => null,
        'mail'  => null,
    );

    /**
     * 初始化, 如果是已經登錄, 則從session讀取用戶的相關信息
     * User constructor.
     */
    function __construct()
    {
        global $conn;
        $this->uconn = $conn;
        if(isset($_SESSION['isLogined']))
        {
            if($_SESSION["isLogined"] == true) {
                $this->uid = $_SESSION["uid"];
                $this->name = $_SESSION["name"];
                $this->mail = $_SESSION["mail"];
                $this->isLogined = true;
                $this->lastLogin = $_SESSION['lastLogin'];
                $this->loginAddr = $_SESSION['loginAddr'];
                $this->loginTimes= $_SESSION['loginTimes'];
                $this->role = $_SESSION['role'];
                $this->fun  = $_SESSION['fun'];
            }
        }
    }

    /**
     * 用戶登錄
     * @param $uid  用戶賬號
     * @param $pwd  用戶密碼
     * @return bool
     */
    function login($uid, $pwd)
    {
        $userInfo = $this->uconn->getFristRow("select uid,pwd,name,mail,lastLogin,loginTimes,loginAddr,enable from users where Uid='{$uid}'");
        if($userInfo)
        {
            if(password_verify($pwd, $userInfo['pwd']))     //verify password
            {
                //将用户信息存入session, 更新類成員信息
                $this->loginAddr = $_SESSION['loginAddr'] =  __getIP();
                $this->isLogined = $_SESSION['isLogined'] = true;          //isLogined
                $this->uid =    $_SESSION['uid'] = $userInfo['uid'];            //uid
                $this->name =   $_SESSION['name'] = $userInfo['name'];           //name
                $this->mail =   $_SESSION['mail'] = $userInfo['mail'];           //mail
                $this->lastLogin = $_SESSION['lastLogin'] = $userInfo['lastLogin'];   //lastLogin
                $this->loginTimes = $_SESSION['loginTimes'] = $userInfo['loginTimes']; //LoginTimes
                $this->enable = $_SESSION['enable'] = $userInfo['enable'];         //enable
                $this->role = $_SESSION['role'] = $this->uconn->getLine("select name from role where code in(select rid from urid where uid='{$uid}' )");
                $this->fun  = $_SESSION['fun'] = $this->uconn->getLine("select name from fun  where code in(select fid from rfid where rid in (select rid from urid where uid='{$uid}'))");

                //更新登录信息
                $this->uconn->query("update users set loginAddr='{$this->loginAddr}', lastLogin=now(), LoginTimes=LoginTimes+1 where Uid='{$this->uid}'");
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    /**
     * 用戶登出
     */
    function logout()
    {
        $this->isLogined = false;
        $_SESSION = array();        //将session设置为一个空数组, 清除所有数据.
    }

    /**
     * 刪除一個用戶
     * @param $uid  賬號
     * @return bool|mysqli_result
     */
    public function userDelete($uid)
    {

        $this->uconn->query('begin');
        $sql = "delete from urid where uid='{$uid}'";
        if(!$this->uconn->query($sql))
        {
            $this->uconn->query('rollback');
            return false;
        }

        if(!$this->uconn->query("delete from users where uid='{$uid}'"))
        {
            $this->uconn->query('rollback');
            return false;
        }

         return $this->uconn->query('commit');
    }

    /**
     * 變更用戶密碼
     * @param $uid      賬號
     * @param $oldPwd   舊密碼
     * @param $newPwd   新密碼
     * @return bool|mysqli_result
     */
    public function changePassword($uid, $oldPwd, $newPwd)
    {
        if(password_verify($oldPwd, $this->uconn->getItemByItemName("select pwd from users where uid='{$uid}'")))
        {
            $newPwd = password_hash($newPwd, PASSWORD_DEFAULT);
            if($this->uconn->query("update users set pwd='{$newPwd}'"))
            {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 增加一個用戶
     * @param $userInfo
     * @return bool|mysqli_result
     */
    public function userAdd($userInfo)
    {
        $userInfo['pwd'] = password_hash($userInfo['pwd'],PASSWORD_DEFAULT);
        $sql = "insert into users (uid, name, pwd, mail) value (
                '{$userInfo['uid']}',
                '{$userInfo['name']}',
                '{$userInfo['pwd']}',
                '{$userInfo['mail']}')";
        return $this->uconn->query($sql);
    }

    /**
     * 增加一個角色
     * @param $rName    角色名
     * @return bool     成功返回true, 失敗返回false
     */
    public function roleAdd($rName)
    {
        $rid = uniqid("RID_");
        return $this->uconn->query("insert into role (Code, Name) value ('{$rid}','$rName')");
    }

    /**
     * 刪除一個角色
     * @param $rid
     * @return bool   成功返回true, 失敗返回false
     */
    public function roleDelete($rid)
    {
        #開始事物
        $this->uconn->query('begin');
        #刪除角色與功能對應關係 rfid
        $sql = "delete from rfid where rid='$rid'";
        if(!$this->uconn->query($sql))
        {
            $this->uconn->query('rollback');
            return false;
        }
        #刪除用戶與角色對應關係 urid
        $sql = "delete from urid where rid='{$rid}'";
        if(!$this->uconn->query($sql))
        {
            $this->uconn->query('rollback');
            return false;
        }
        #刪除角色
        $sql = "delete from role where Code='{$rid}'";
        if(!$this->uconn->query($sql))
        {
            $this->uconn->query('rollback');
            return false;
        }
        #提交事物
        return $this->uconn->query('commit');
    }

    /**
     * 增加一個功能
     * @param $fName
     * @return bool|mysqli_result
     */
    public function funAdd($fName)
    {
        $fid = uniqid("FID_");
        return $this->uconn->query("insert into fun (Code, Name) value ('{$fid}','{$fName}')");
    }

    /**
     * 刪除一個功能
     * @param $fid
     * @return bool|mysqli_result
     */
    public function funDelete($fid)
    {
        #開始事務
        $this->uconn->query('begin');
        #刪除角色與功能關係 rfid
        $sql = "delete from rfid where fid='{$fid}'";
        if(!$this->uconn->query($sql))
        {
            $this->uconn->query('rollback');
            return false;
        }
        #刪除功能
        $sql = "delete from fun where Code='{$fid}'";
        if(!$this->uconn->query($sql))
        {
            $this->uconn->query('rollback');
            return false;
        }
        #提交事務
        return $this->uconn->query('commit');
    }

    /**
     * 從角色/功能關係表刪除
     * @param $rid
     * @return bool|mysqli_result
     */
    public function delByRoleFromRFID($rid)
    {
        return $this->uconn->query("delete from rfid where rid='{$rid}'");
    }

    /**
     * 增加一個角色/功能關係
     * @param $rid
     * @param $fid
     * @return bool|mysqli_result
     */
    public function addByRoleToRFID($rid, $fid)
    {
        return $this->uconn->query("insert into rfid (rid, fid) VALUE ('{$rid}','{$fid}')");
    }

    /**
     * 從用戶/角色表刪除項目
     * @param $uid
     * @return bool|mysqli_result
     */
    public function delByUserFromURID($uid)
    {
        return $this->uconn->query("delete from urid where uid='{$uid}'");
    }

    /**
     * 增加一個用戶/角色關係
     * @param $uid
     * @param $rid
     * @return bool|mysqli_result
     */
    public function addByUserToURID($uid, $rid)
    {
        return $this->uconn->query("insert into urid (uid, rid) value ('{$uid}','{$rid}')");
    }

    /**
     *  以業務名稱驗證當前用戶是否有權限訪問
     * @param $fname 業務名稱.
     * @param bool $alert 是否顯示警告
     * @return bool
     */
    function authByFun($fname, $alert=true)
    {
        //$err = false;
        //獲取所有用戶角色

        if($this->uid == "admin") return true;      //管理員跳過檢查
        if(!is_array($this->fun)) return false;     //無功能返回false
        if(in_array($fname,$this->fun))
        {
            return true;
        } else {
            if($alert) __showMsg('沒有權限訪問當前業務.');
            return false;
        }
    }

    /**
     * 以角色名稱驗證當前用戶是否有權限訪問
     * @param $rName    角色名
     * @param bool $alert 是否顯示警告
     * @return bool
     */
    function authByRole($rName, $alert=true)
    {
        if ($this->uid == "admin") return true;         //管理員跳過檢查
        if (!is_array($this->role)) return false;       //無角色返回false
        if (in_array($rName, $this->role)) {
            return true;
        } else {
            if ($alert) __showMsg('沒有權限訪問當前業務.');
            return false;
        }
    }

    public function authByFunOnlyAuto($method)
    {
        if ($this->uid == "admin") return true;

        if($res = $this->uconn->getItemByItemName("select Name from fun where method='$method'"))
        {
           if(count($res)==0) return false;
            return  $this->authByFun($res,false);
        } else {
            return false;
        }
    }
}