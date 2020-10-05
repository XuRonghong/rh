<?php
include_once dirname(__FILE__) . '/config.php';
?>
<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw" dir="ltr">

<head id="Head1" runat="server">
  <title>建築工料分析系統</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
  <link href="css/master.css" rel="stylesheet" type="text/css">
  <link href="css/menu.css" rel="stylesheet" type="text/css" />
  <link href="css/tree.css" rel="stylesheet" type="text/css" />
  <link href="css/first.css" rel="stylesheet" type="text/css" />
  <style type="text/css"></style>

  <?php require_once dirname(__FILE__) . '/layouts/script.php'; ?>
  <script src="Scripts/switchmenu.js" type="text/javascript"></script>
  <script>
      function MM_swapImgRestore() { //v3.0
        var i, x, a = document.MM_sr;
        for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
      }

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
</head>

<body>
  <table width="1200" height="" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top">
        <table width="100%" height="600" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <?php require_once dirname(__FILE__) . '/layouts/top.php'; ?>
          </tr>
          <tr>
            <?php require_once dirname(__FILE__) . '/layouts/menu.php'; ?>

            <td width="1118" valign="top" class="top_colr">
              <!-- InstanceBeginEditable name="EditRegion1" -->
              <table width="100%" height="378" align="center" cellpadding="0" cellspacing="1" class="main_sbar">
                <tr>
                  <td height="376" align="right" valign="top" background="images/bg_gr.gif">
                    <table border="0" cellspacing="0" cellpadding="3" align="center" scrollbar-face-color:="scrollbar-face-color:" #b46868;>
                    </table>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="top_table1">
                      <tr>
                        <td width="100%">
                          <table width="100%" align="center" cellpadding="1" cellspacing="0" class="top_tab">
                            <tr>
                              <td width="92%" height="22"><strong>系統維護</strong></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" class="top_table1">
                      <tr>
                        <td height="363"><br />
                          <br />
                          <table height="350" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td height="58">
                                <a href="unit_edit.php" alt="主辦單位資料" target="_parent" onmouseover="MM_swapImage('Image1','','images/ma_01.png',1)" onmouseout="MM_swapImgRestore()">
                                  <img src="images/m_01.png" name="Image1" width="193" height="170" border="0" id="Image1" />
                                </a>
                              </td>
                              <td>
                                <a href="account.php" alt="帳號權限管理" target="_parent" onmouseover="MM_swapImage('Image2','','images/ma_02.png',1)" onmouseout="MM_swapImgRestore()">
                                  <img src="images/m_02.png" name="Image2" width="190" height="170" border="0" id="Image2" />
                                </a>
                              </td>
                              <td>
                                <a href="project.php" alt="專案備份維護" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','images/ma_03.png',1)">
                                  <img src="images/m_03.png" name="Image3" width="194" height="170" border="0" id="Image3" />
                                </a>
                              </td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="58">
                                <a href="index06_4.htm" alt="料號分類設定" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image4','','images/ma_05.png',1)">
                                  <img src="images/m_05.png" name="Image4" width="193" height="169" border="0" id="Image4" />
                                </a>
                              </td>
                              <td>
                                <a href="index06_5.htm" alt="工項編碼維護" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image5','','images/ma_06.png',1)">
                                  <img src="images/m_06.png" name="Image5" width="190" height="169" border="0" id="Image5" />
                                </a>
                              </td>
                              <td>
                                <a href="index06_6.htm" alt="工料編碼維護" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image7','','images/ma_07.png',1)">
                                  <img src="images/m_07.png" name="Image7" width="194" height="169" border="0" id="Image7" />
                                </a>
                              </td>
                              <td>
                                <a href="index06_7.htm" alt="單價分析維護" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image8','','images/ma_08.png',1)">
                                  <img src="images/m_08.png" name="Image8" width="206" height="169" border="0" id="Image8" />
                                </a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <!-- InstanceEndEditable -->
              <!-- InstanceBeginEditable name="EditRegion2" -->
              <!-- InstanceEndEditable -->
            </td>
          </tr>
        </table>
        <?php require_once dirname(__FILE__) . '/layouts/bottom.php'; ?>
      </td>
    </tr>
  </table>
</body>
<!-- InstanceEnd -->

</html>