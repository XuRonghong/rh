<?php
include_once dirname(__FILE__) . '/config.php';

// $tablename = 'class';
// $queryStr = " AND open=1 ";
// $orderStr = " ORDER BY rank ASC ";
// $rs = $db->prepare("SELECT * FROM {$tablename} WHERE class=1 ". $queryStr. $orderStr);
// $rs->execute();
// $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw" dir="ltr">

<head id="Head1" runat="server">
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>建築工料分析系統</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <!-- InstanceEndEditable -->

    <link href="css/menu.css" rel="stylesheet" type="text/css" />
    <link href="css/tree.css" rel="stylesheet" type="text/css" />
    <link href="css/first.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    </style>

    <script src="Scripts/switchmenu.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $(".btn-clear").click(function() {
                $("[name~='account']").val('')
                $("[name~='password']").val('')
                $("[id~='ckbRememberMe']").prop('checked', false)
            })

            $(".btn-submit").click(function() {
                // var account = $("[name~='account']").val() || ''       
                var pw = $("[name~='password']").val() || ''
                var pw1 = $("[name~='password_1']").val() || ''
                var pw2 = $("[name~='password_2']").val() || ''
                if ( pw=='' || pw1=='' || pw2=='') {
                    alert('Empty')
                    return
                }
                if ( pw1!==pw2 ) {
                    alert('密碼確認有誤')
                    $("[name~='password_2']").focus()
                    return
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
                    },
                    url: "ajax/api_login.php",
                    type: "POST",
                    data: {
                        'type': 'update',
                        // 'account': account,
                        'password': pw,
                        'password1': pw1
                    },
                    cache: false,
                    // resetForm: true,
                    success: function(rtndata) {
                        rtndata = JSON.parse(rtndata)
                        if (rtndata.status > 0) {
                            location.href = rtndata.url
                        } else {
                            alert(rtndata.message)
                            if(rtndata.code == 1){
                                $("[name~='password']").focus()
                            } else if(rtndata.code == 2){
                                $("[name~='password1']").focus()
                            } 
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        // 通常情況下textStatus和errorThown只有其中一個有值 
                        console.error('status:' + XMLHttpRequest.status + ';rs:' + XMLHttpRequest.readyState + ';ts:' + textStatus)
                    }
                });
            });
        });
    </script>
</head>

<body >
    <table width="1200" height="" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top">
                <table width="100%" height="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="40" colspan="2" valign="top">
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="top_logo">
                                <tr>
                                    <td width="26%" class="top_bg">
                                        <asp:ImageButton ID="BMS51_ID" ImageUrl="~/IMAGES/top_01.gif" runat="server" onclick="BMS51_ID_Click" />
                                        <img src="images/CEC_top_01.gif" width="311" height="40" /></td>
                                    <td width="23%" class="top_font">&nbsp;</td>
                                    <td width="24%" class="top_font" style="text-align:right">&nbsp;</td>
                                    <td width="27%" align="right"><a href="#"></a><img src="images/CEC_top_04.gif" width="356" height="40" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="200" height="552" class="left_tab" style="vertical-align:top; text-align:center;">
                            <asp:Button ID="Button1" runat="server" Text="＜" onclick="Button1_Click" Height="28" />
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_colr_table">
                                            <tr>
                                                <td width="6%" rowspan="2">
                                                    <asp:Image ID="Image1" ImageUrl="~/IMAGES/user.png" runat="server" />
                                                </td>
                                                <td width="63%" height="26">編號：1234567890</td>
                                                <td width="31%" rowspan="2">
                                                    <div align="center"><a href="index.htm"><img src="IMAGES/logout.gif" alt="登出" border="0" /></a></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>姓名：鄭裕傳</td>
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
                                    <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="index01.htm">專 案 建 立</a>
                                        <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="11" id="22" align="center">
                                            <ul id="subnavlist" style="list-style-type:none;padding-left:0px">
                                                <li><a class="SubMenu" href="#" target="_parent"></a></li>
                                                <li><a class="SubMenu" href="#" target="_parent"></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="index02.htm">工 程 填 報</a>
                                        <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="33" id="44" align="left">
                                            <ul id="subnavlist" style="list-style-type:none;padding-left:0px">
                                                <li><a class="SubMenu" href=" ../index05.htm" target="_top"></a></li>
                                                <li><a class="SubMenu" href="#" target="_top"></a> </li>
                                            </ul>
                                        </div>
                                    </li>
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
                                    <li><a style="background-repeat: no-repeat; background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="index06.htm">系 統 維 護</a></li>
                                </ul>
                            </div>
                            <p>&nbsp;</p>
                            <p><br />
                            </p>
                            <div>
                                <ul id="navlist3" style="list-style-type:none;padding-left:0px">
                                    <li><span class="left_font">11月13日星期四</span>
                                        <br />
                                        <span class="left_font1">PM 3:37</span></li>
                                </ul>
                            </div>
                            <div><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image7','','images/service_1.png',1)"><img src="images/service.png" name="Image7" width="150" height="53" border="0" id="Image7" /></a></div>
                        </td>
                        <td width="1118" valign="top" class="top_colr">
                            <!-- InstanceBeginEditable name="EditRegion2" -->
                            <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#003333">
                                <tr>
                                    <td width="100%">
                                        <table width="100%" cellpadding="2" cellspacing="0">
                                            <tr>
                                                <td colspan="6" bgcolor="#FFFFFF" class="form1_td">
                                                    <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td width="3%"><img src="images/document_alt_fill_16x16.png" width="24" height="16" border="0" /></td>
                                                            <td width="88%">編輯內容</td>
                                                            <td width="9%">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="list2"></td>
                                                <td class="list2"></td>
                                                <td class="list2">舊密碼</td>
                                                <td width="25%" class="list2">
                                                    <form id="form5" name="form5" method="post" action="">
                                                        <label>
                                                            <input class="txtPassword" name="password" maxLength="20" size="20" type="password">
                                                        </label>
                                                    </form>
                                                </td>
                                                <td width="7%" class="list2"></td>
                                                <td width="29%" class="list2"></td>
                                            </tr>
                                            <tr>
                                                <td width="7%" class="list2"></td>
                                                <td width="25%" class="list2"></td>
                                                <td width="7%" class="list2">新密碼</td>
                                                <td class="list2">
                                                    <form id="form5" name="form5" method="post" action="">
                                                        <label>
                                                            <input class="txtPassword" name="password_1" maxLength="20" size="20" type="password">
                                                        </label>
                                                    </form>
                                                </td>
                                                <td class="list2"></td>
                                                <td class="list2"></td>
                                            </tr>
                                            <tr>
                                                <td class="list2"></td>
                                                <td class="list2"></td>
                                                <td class="list2">密碼確認</td>
                                                <td class="list2">
                                                    <form id="form8" name="form8" method="post" action="">
                                                        <label>
                                                            <input class="txtPassword" name="password_2" maxLength="20" size="20" type="password">
                                                        </label>
                                                    </form>
                                                </td>
                                                <td class="list2"></td>
                                                <td class="list2"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" bgcolor="#FFFFFF">
                                                    <div align="center">
                                                        <form id="form11" name="form11" method="post" action="#">
                                                            <input type="button" name="btn-submit" class="btn-submit" value="確定" />
                                                            <input type="button" name="btn-clear" class="btn-clear" value="清除" />
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!-- InstanceEndEditable -->
                        </td>
                    </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td bgcolor="#303f5e" class="bottom1">&nbsp;達義資訊整合有限公司<strong> reach right Information Co.,Ltd.</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
<!-- InstanceEnd -->

</html>