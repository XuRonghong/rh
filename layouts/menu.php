
<td width="200" height="552" class="left_tab" style="vertical-align:top; text-align:center;">
    <asp:Button ID="Button1" runat="server" Text="＜" Height="28" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_colr_table">
                    <tr>
                        <td width="6%" rowspan="3">
                            <asp:Image ID="Image1" ImageUrl="~/IMAGES/user.png" runat="server" />
                        </td>
                        <td width="63%" height="26">編號：<?php echo data_get($_SESSION, 'admin_id'); ?></td>
                        <td width="31%" rowspan="2">
                            <div class="btn-logout"><img src="IMAGES/logout.gif" alt="登出" border="0" /></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            統編<?php echo data_get($_SESSION, 'admin_code'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            姓名：<?php echo data_get($_SESSION, 'admin_name'); ?><br>
                            <input type="button" class="btn-goto" data-url="repw.php" value="更改密碼" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" height="55" border="0">
        <tr>
            <td class="td_03_top"><strong>工程專案</strong></td>
        </tr>
        <tr>
            <td class="td_03">
                <p>20150604A1 <br />
                    新北市三重區<br />
                    <br />
                    大陸建設住宅<br />
                </p>
            </td>
        </tr>
    </table>
    <!-- begin class menu -->
    <div id="navcontainer">
        <ul id="navlist" style="list-style-type:none;padding-left:0px">
            <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="project.php">專 案 建 立</a>
                <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="11" id="22" align="center">
                    <ul id="subnavlist" style="list-style-type:none;padding-left:0px">
                        <li><a class="SubMenu" href="#" target="_parent"></a></li>
                        <li><a class="SubMenu" href="#" target="_parent"></a></li>
                    </ul>
                </div>
            </li>
            <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="test1.php">工 程 填 報</a>
                <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="33" id="44" align="left">
                    <ul id="subnavlist" style="list-style-type:none;padding-left:0px">
                        <li><a class="SubMenu" href=" ../index05.htm" target="_top"></a></li>
                        <li><a class="SubMenu" href="#" target="_top"></a> </li>
                    </ul>
                </div>
            </li>
            <?php if( data_get($_SESSION, 'admin_auth1') < 2 ){ ?>
            <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="index03.htm">工 程 分 析</a>
                <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="55" id="66" align="left">
                    <ul id="subnavlist" style="list-style-type:none;padding-left:0px">
                        <li><a class="SubMenu" href="#" target="_top"></a></li>
                        <li><a class="SubMenu" href="#" target="_top"></a></li>
                    </ul>
                </div>
            </li>
            <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="JavaScript:showOnOff('yes','7','8');">料 號 編 碼</a>
                <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="7" id="8">
                    <ul id="subnavlist2" style="list-style-type:none;padding-left:0px">
                        <li><a class="SubMenu" href="index05.htm" target="_parent">工 項 範 圍</a></li>
                        <li><a class="SubMenu" href="#" target="_parent">工 料 範 圍</a></li>
                    </ul>
                </div>
            </li>
            <?php } ?>
            <li><a style="background-repeat: no-repeat; background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="system_manage.php">系 統 維 護</a></li>
        </ul>
    </div>
    <p>&nbsp;</p>
    <p><br />
    </p>
    <div>
        <ul id="navlist3" class=" left_menu" style="list-style-type:none;padding-left:0px">
            <li>
                <span class="left_font date">11月13日星期四</span>
                <br />
                <span class="left_font1 time">PM 3:37</span>
            </li>
        </ul>
    </div>
    <div><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image7','','images/service_1.png',1)"><img src="images/service.png" name="Image7" width="150" height="53" border="0" id="Image7" /></a></div>
</td>