<?php
include_once dirname(__FILE__) . '/config.php';

$tablename = 'units';
$queryStr = " AND status=1 ";
$orderStr = " ORDER BY rank ASC ";
$rs = $db->prepare("SELECT * FROM {$tablename} WHERE id=:id ". $queryStr. $orderStr);
$rs->execute( array('id'=> data_get($_SESSION, 'admin_unit')) );
$rows = $rs->fetchAll(PDO::FETCH_ASSOC);
$row = $rows[0];
?>
<!DOCTYPE html>
<html lang="tw" dir="ltr">

<head id="Head1" runat="server">
  <title>建築工料分析系統</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
  <link href="css/menu.css" rel="stylesheet" type="text/css" />
  <link href="css/tree.css" rel="stylesheet" type="text/css" />
  <link href="css/first.css" rel="stylesheet" type="text/css" />
  <link href="css/master.css" rel="stylesheet" type="text/css">
  <style type="text/css">
  </style>

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
              <!-- InstanceBeginEditable name="EditRegion2" -->
              <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#003333">
                <tr>
                  <td width="100%">

                    <form enctype="multipart/form-data" action="ajax/api_upload.php" method="post">

                      <table width="100%" cellpadding="2" cellspacing="0">
                        <tr>
                          <td colspan="4" bgcolor="#FFFFFF" class="form1_td">
                            <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="3%"><img src="images/document_alt_fill_16x16.png" width="24" height="16" border="0" /></td>
                                <td width="90%">編輯 主辦單位資料</td>
                                <td width="7%">&nbsp;</td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td class="list2">單位統編</td>
                          <td class="list2">
                            <label>
                              <input type="text" name="code" class="form1" value="<?php echo $row['Code1'];?>" />
                            </label>
                          </td>
                          <td class="list2">單位名稱</td>
                          <td width="58%" class="list2">
                            <label>
                              <input name="name" type="text" class="form1" value="<?php echo $row['Name1'];?>" />
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td width="9%" class="list2">連絡電話</td>
                          <td width="21%" class="list2">
                            <label>
                              <input name="tel" type="text" class="form1" value="<?php echo $row['Tel'];?>" />
                            </label>
                          </td>
                          <td width="12%" class="list2">單位名稱(英文)</td>
                          <td class="list2">
                            <label>
                              <input name="name2" type="text" class="form1" size="57" value="<?php echo $row['Name2'];?>" />
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td class="list2">商標</td>
                          <td class="list2">
                            <label>
                              <input name="file" type="file" accept="image/gif, image/jpeg, image/png" id="imgInp" class="form1" >
                              <img id="blah" src="storage/<?php echo $tablename.'/'.data_get($row, 'Logo', '../images/246x0w.png');?>" alt="your image" style="width: 100px;" />
                              <br>
                              <input class="rmLogo" type="button" value="圖片拿掉">
                              <input name="Logo" type="hidden" value="<?php echo $row['Logo'];?>">
                            </label>
                          </td>
                          <td class="list2">單位地址</td>
                          <td class="list2">
                            <label>
                              <input name="address" type="text" class="form1" size="57" value="<?php echo $row['Address1'];?>" />
                            </label>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4" bgcolor="#FFFFFF">
                            <div align="center">
                              <input name="button1" type="submit" class="btn-submit" value="儲存" />
                              <input name="button2" type="reset" class="btn-cancel" value="取消" />
                            </div>
                          </td>
                        </tr>
                      </table>

                    </form>

                  </td>
                </tr>
              </table>
              <!-- InstanceEndEditable -->
            </td>
          </tr>
        </table>
        <?php require_once dirname(__FILE__) . '/layouts/bottom.php'; ?>
      </td>
    </tr>
  </table>
  
  <?php require_once dirname(__FILE__) . '/layouts/script.php'; ?>
  <script src="Scripts/switchmenu.js" type="text/javascript"></script>
  <script>
    $(document).ready(function() {
      //用JavaScript抓取Enter事件並按下按鈕
      $(".form1").keypress(function(e) {
        let key = window.event ? e.keyCode : e.which
        if (key == 13) $('.btn-submit').click()
      });

      $('.rmLogo').click(function(){
        $('#blah').prop('src', 'images/246x0w.png')
        $("[name~='Logo']").val('')
      })
    })
  </script>

</body>

</html>