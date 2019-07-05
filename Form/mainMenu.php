    <style>

        #menu,#userInfo {cursor: pointer;}
        #menu li{float: left;}
        #userInfo li{float: right;}

        .menuDiv ul li {
            /*! display: inline; */
            width: 100px;
            text-align: center;
            border: 1px solid #000;
            margin-right: 1px;
        }

        #menu ul {  display: none;}
        #menu li:hover{
            background-color: #fff;
        }
        #menu li:hover ul { /*鼠标滑过显示子菜单*/
            display: block;
            z-index: 999;
        }

        #menu li ul li {
            clear: both;
            /*             background-color: #fff;
                        border-radius: 5%;
                        border: 1px solid red; */
            border-left: none;
            border-right: none;
            border-bottom:  none;
            margin-top: 2px;
        }
        .menuDiv a {
            display: block;
            border: none;
            text-decoration: none;
            color: #000;
        }
        .menuDiv a:visited {
            color: #000;
        }

        .menuDiv a:hover
        {
            background: #000;
            color: #fff;
        }
    </style>

<div>
    <div class="menuDiv">
        <ul id="menu">
            <li>維護記錄
                <ul>
                    <li><a href="?act=maintain/add">添加</a></li>
<!--                    <li><a href="?act=maintain/update">更新</a></li>-->
                    <li><a href="?act=maintain/personal">個人專區</a></li>
                </ul>
            </li>
            <li>查詢
                <ul>
                    <li><a href="?act=maintain/search">查詢資料</a></li>
                    <li><a>項目2</a></li>
                </ul>
            </li>
            <li>報表
                <ul>
                    <li><a>項目1</a></li>
                    <li><a>項目2</a></li>
                </ul>
            </li>
            <li>後台
                <ul>
                    <li><a href="?act=Users">用戶管理</a></li>
                    <li><a href="?act=Roles">角色管理</a></li>
                    <li><a href="?act=Fun">功能管理</a></li>

                </ul>
            </li>
            <li>其他
                <ul>
                    <li><a>項目1</a></li>
                    <li><a>項目2</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="menuDiv">
        <ul id="userInfo">
            <li><a href="?act=userDetail"><?php echo $user->name ?></a></li>
            <li><a href="?act=userLogout">登出</a></li>
        </ul>
    </div>
</div>
