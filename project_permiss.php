<?php
include_once dirname(__FILE__) . '/config.php';

$tablename = 'projects';
$queryStr = " AND `status` > 0 ";
$orderStr = " ORDER BY rank ASC ";
$sql = "SELECT * FROM {$tablename} WHERE 1 " .$queryStr.  $orderStr;
$rs = $db->prepare($sql);
$rs->execute();
$projects = $rs->fetchAll(PDO::FETCH_ASSOC);


$gets = filterVar($_REQUEST);        
$tablename = 'accounts';
$queryStr = " AND `id`=? ";
$sql = "SELECT * FROM {$tablename} WHERE 1 " .$queryStr;
$rs = $db->prepare($sql);
$parme = array( data_get($gets,'u'));
$rs->execute( $parme);
$accout = $rs->fetch(PDO::FETCH_ASSOC);
$accout['Project'] = explode(',', $accout['Project']);

?>
<!DOCTYPE html>
<html lang="tw" dir="ltr">

<head id="Head1" runat="server">
  <title>建築工料分析系統</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="css/menu.css" rel="stylesheet" type="text/css" />
  <link href="css/tree.css" rel="stylesheet" type="text/css" />
  <link href="css/master.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="CSS/first.css" />

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

            <td width="1118" class="top_colr">
              <!-- InstanceBeginEditable name="EditRegion1" -->
              <table width="100%" height="348" align="center" cellpadding="0" cellspacing="1" class="main_sbar">
                <tr>
                  <td align="center">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table1">
                      <tr>
                        <td width="100%">
                          <table width="100%" align="center" cellpadding="1" cellspacing="0" class="top_tab">
                            <tr>
                              <td width="3%">&nbsp;</td>
                              <td width="90%">專案選擇</td>
                              <td width="7%">
                                <div align="right">&nbsp;</span></div>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                    <form id="form_edit1">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table1">
                        <tr>
                          <td width="100%">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="4%" height="25" class="list3">&nbsp;</td>
                                <td width="11%" class="list3">單位編號</td>
                                <!-- <td width="23%" class="list3"><strong>單位名稱</strong></td> -->
                                <td width="10%" class="list3"><strong>工程編號</strong></td>
                                <td width="14%" class="list3"><strong>工程名稱</strong></td>
                                <td width="9%" class="list3"><strong>填報人員</strong></td>
                                <td width="11%" class="list3"><strong>連絡電話</strong></td>
                                <td width="9%" class="list3"><strong>審查人員</strong></td>
                                <td width="9%" class="list3"><strong>建檔日期</strong></td>
                              </tr>
                              <?php
                              if ($projects) { 
                                foreach ($projects as $key => $project) { ?>
                                  <tr>
                                    <td class="list2">
                                      <div align="center">
                                        <input type="checkbox" name="Project[]" class="chk_project" value="<?php echo data_get($project,'id');?>" 
                                              <?php if(in_array(data_get($project,'id'), $accout['Project'])) { echo "checked"; } ?> />
                                      </div>
                                    </td>
                                    <td class="list2"><?php echo data_get($project, 'ECode1'); ?></td>
                                    <!-- <td class="list2"><?php echo data_get($project, 'area'); ?></td> -->
                                    <!-- <td class="list2"><?php echo data_get($project, 'ECode2'); ?></td> -->
                                    <td class="list2"><?php echo data_get($project, 'Name'); ?></td>
                                    <td class="list2"><?php echo data_get($project, 'Location'); ?></td>
                                    <td class="list2"><?php echo data_get($project, 'Owners'); ?></td>
                                    <td class="list2"><?php echo data_get($project, 'Note'); ?></td>
                                    <td class="list2"><?php echo data_get($project, 'Name'); ?></td>
                                    <td class="list2"><?php echo explode(' ', data_get($project, 'created_at'))[0]; ?></td>
                                  </tr>
                                <?php }
                              } else { ?>
                                <tr>
                                  <td class="list2">
                                    <div align="center">
                                      <input type="checkbox" name="Project" class="chk_project" />
                                    </div>
                                  </td>
                                  <td class="list2">382079900Y</td>
                                  <td class="list2">新北市三重區二重國民小學</td>
                                  <td class="list2">A00000001</td>
                                  <td class="list2">圖書館整修工程</td>
                                  <td class="list2">鄭裕傳</td>
                                  <td class="list2">0930888396</td>
                                  <td class="list2">劉道德</td>
                                  <td class="list2">20141112</td>
                                </tr>
                              <?php } ?>
                            </table>
                          </td>
                        </tr>
                      </table>                      

                      <input type="hidden" name="id" value="<?php echo $_GET['u']; ?>" />
                    </form>
                    
                  </td>
                </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="15">
                    <div align="center">
                      <input type="button" name="btn-submit" id="btn-submit" value="確定" />
                      <input type="button" onclick="history.go(-1)" value="取消" />
                    </div>
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
      //表單送出
      $("#btn-submit").click(function() {
        let current_modal = $('#form_edit1')
        let datas = current_modal.serialize()
        let gotoUrl = '<?php echo data_get($gets,'go');?>';
        $.ajax({
                headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                url: "ajax/api_project_permiss.php",
                type: "POST",
                data: datas,
                cache: false,
                resetForm: true,
                success: function(rtndata) {
                    rtndata = JSON.parse(rtndata)
                    if (rtndata.status > 0) {
                      // alert(rtndata.message)
                        location.href = decodeURIComponent(gotoUrl)//rtndata.url
                    } else {
                        console.error(JSON.stringify(rtndata))
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // 通常情況下textStatus和errorThown只有其中一個有值 
                    console.error('status:' + XMLHttpRequest.status + ';rs:' + XMLHttpRequest.readyState + ';ts:' + textStatus)
                }
            })
      });
    });
  </script>

</body>

</html>