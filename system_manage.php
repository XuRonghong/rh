<?php
include_once dirname(__FILE__) . '/config.php';
?>
<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw" dir="ltr">

<head id="Head1" runat="server">
  <title>建築工料分析系統</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  
  <link href="css/master.css" rel="stylesheet" type="text/css">
  <link href="css/menu.css" rel="stylesheet" type="text/css" />
  <link href="css/tree.css" rel="stylesheet" type="text/css" />
  <link href="css/first.css" rel="stylesheet" type="text/css" />
  <style type="text/css"></style>

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
                              <?php if (data_get($_SESSION, 'admin_auth1') < 2) { ?>
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
                              <?php } else { ?>
                                <td>
                                </td>
                                <td>
                                </td>
                              <?php }  ?>
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
  
  <?php require_once dirname(__FILE__) . '/layouts/script.php'; ?>
  <script>
    $(document).ready(function() {

    });
  </script>
</body>
<!-- InstanceEnd -->

</html>