<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw"">

<head id="Head1" runat="server">
  <!-- InstanceBeginEditable name="doctitle" -->
  <title>建築工料分析系統</title>
  <!-- InstanceEndEditable -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="stylesheet" href="resources/css/first.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>


  <script type="text/javascript">
    function MM_preloadImages() { //v3.0
      var d = document;
      if (d.images) {
        if (!d.MM_p) d.MM_p = new Array();
        var i, j = d.MM_p.length,
          a = MM_preloadImages.arguments;
        for (i = 0; i < a.length; i++)
          if (a[i].indexOf("#") != 0) {
            d.MM_p[j] = new Image;
            d.MM_p[j++].src = a[i];
          }
      }
    }

    function MM_swapImgRestore() { //v3.0
      var i, x, a = document.MM_sr;
      for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
    }

    function MM_findObj(n, d) { //v4.01
      var p, i, x;
      if (!d) d = document;
      if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
        d = parent.frames[n.substring(p + 1)].document;
        n = n.substring(0, p);
      }
      if (!(x = d[n]) && d.all) x = d.all[n];
      for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
      for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
      if (!x && d.getElementById) x = d.getElementById(n);
      return x;
    }

    function MM_swapImage() { //v3.0
      var i, j = 0,
        x, a = MM_swapImage.arguments;
      document.MM_sr = new Array;
      for (i = 0; i < (a.length - 2); i += 3)
        if ((x = MM_findObj(a[i])) != null) {
          document.MM_sr[j++] = x;
          if (!x.oSrc) x.oSrc = x.src;
          x.src = a[i + 2];
        }
    }
  </script>

  <script src="resources/js/switchmenu.js" type="text/javascript"></script>
  <link href="resources/css/menu.css" rel="stylesheet" type="text/css" />
  <link href="resources/css/tree.css" rel="stylesheet" type="text/css" />
  <link href="resources/css/first.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    body {
      margin-left: 0px;
      margin-top: 0px;
      margin-right: 0px;
      margin-bottom: 0px;
    }
  </style>
  <!-- InstanceBeginEditable name="head" -->
  <!-- InstanceEndEditable -->
</head>

<body style="font-family:新細明體;" onload="MM_preloadImages('images/service_1.png')">
  <table width="1200" height="" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top">
        <table width="100%" height="600" border="0" cellpadding="0" cellspacing="0" style=";">
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
              <!-- InstanceBeginEditable name="EditRegion1" -->
              <table width="100%" align="center" cellpadding="0" cellspacing="1" class="main_sbar">
                <tr>
                  <td height="276" align="right">
                    <table border="0" cellspacing="0" cellpadding="3" align="center" scrollbar-face-color:="scrollbar-face-color:" #b46868;>
                    </table>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table1">
                      <tr>
                        <td width="100%">
                          <table width="100%" align="center" cellpadding="1" cellspacing="0" class="top_tab">
                            <tr>
                              <td width="3%">&nbsp;</td>
                              <td width="88%">工程專案</td>
                              <td width="9%">
                                <div align="right"><strong><img src="images/report.png" width="16" height="16" border="0" />&nbsp;<img src="images/document_alt_fill_16x16.png" width="24" height="16" border="0" />&nbsp;<img src="images/trash-empty16x16.png" width="16" height="16" border="0" />&nbsp;</strong></div>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                    <iframe src="p001.html" name="list1" width="100%" height="355" id="list1" scrolling="Yes" frameborder="no" border="0 framespacing=" 0"></iframe>
                  </td>
                </tr>
              </table>
              <!-- InstanceEndEditable -->
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
                        <td class="list2">單位編號</td>
                        <td class="list2"><label>
                            <input type="text" name="textfield" id="textfield" />
                          </label></td>
                        <td class="list2">單位名稱</td>
                        <td width="25%" class="list2">
                          <form id="form2" name="form2" method="post" action="">
                            <label>
                              <input type="text" name="textfield2" id="textfield2" />
                            </label>
                          </form>
                        </td>
                        <td width="7%" class="list2">建檔日期</td>
                        <td width="29%" class="list2">
                          <form id="form3" name="form3" method="post" action="">
                            <label>
                              <input type="text" name="textfield3" id="textfield3" />
                            </label>
                          </form>
                        </td>
                      </tr>
                      <tr>
                        <td width="7%" class="list2">工程編號</td>
                        <td width="25%" class="list2">
                          <form id="form4" name="form4" method="post" action="">
                            <label>
                              <input name="textfield4" type="text" id="textfield4" />
                            </label>
                          </form>
                        </td>
                        <td width="7%" class="list2">工程名稱</td>
                        <td class="list2">
                          <form id="form5" name="form5" method="post" action="">
                            <label>
                              <input name="textfield5" type="text" id="textfield5" />
                            </label>
                          </form>
                        </td>
                        <td class="list2">工程別號</td>
                        <td class="list2">
                          <form id="form6" name="form6" method="post" action="">
                            <label>
                              <input type="text" name="textfield6" id="textfield6" />
                            </label>
                          </form>
                        </td>
                      </tr>
                      <tr>
                        <td class="list2">工程地點</td>
                        <td class="list2">
                          <form id="form7" name="form7" method="post" action="">
                            <label>
                              <input name="textfield7" type="text" id="textfield7" />
                            </label>
                          </form>
                        </td>
                        <td class="list2">用途說明</td>
                        <td class="list2">
                          <form id="form8" name="form8" method="post" action="">
                            <label>
                              <input type="text" name="textfield8" id="textfield8" />
                            </label>
                          </form>
                        </td>
                        <td class="list2">結構型式</td>
                        <td class="list2">
                          <form id="form9" name="form9" method="post" action="">
                            <label>
                              <input type="text" name="textfield9" id="textfield9" />
                            </label>
                          </form>
                        </td>
                      </tr>
                      <tr>
                        <td class="list4">文件資料</td>
                        <td class="list4">
                          <form id="form10" name="form10" enctype="multipart/form-data" method="post" action="">
                            <label></label>
                            <input name="textfield10" type="text" id="textfield10" />
                            <label>
                              <input type="submit" name="button" id="button" value="上傳PDF" />
                            </label>
                          </form>
                        </td>
                        <td class="list4">影像資料</td>
                        <td class="list4"><input name="textfield11" type="text" id="textfield11" />
                          <label>
                            <input type="submit" name="button3" id="button3" value="上傳JPG" />
                          </label></td>
                        <td class="list4">預算鎖定</td>
                        <td class="list4">
                          <form id="form1" name="form1" method="post" action="">
                            <label>
                              <input type="radio" name="radio" id="radio" value="radio" />
                              <img src="images/lock_open.png" width="16" height="16" /> </label>
                            <label>
                              <input type="radio" name="radio2" id="radio2" value="radio2" />
                            </label>
                            <img src="images/lock.png" width="16" height="16" />
                          </form>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" bgcolor="#FFFFFF" class="list2"><br />
                          <br />
                          <br /></td>
                      </tr>
                      <tr>
                        <td colspan="6" bgcolor="#FFFFFF">
                          <div align="center">
                            <form id="form11" name="form11" method="post" action="#">
                              <input name="button1" type="submit" id="button1" value="儲存" />
                              <input name="button2" type="submit" value="取消" id="button2" />
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