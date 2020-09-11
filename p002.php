<?php /*
include_once dirname(__FILE__) . '/config.php';

$tablename = 'class';
$rs = $db->prepare("SELECT * FROM {$tablename} where class=1");
$rs->execute();
$rows = $rs->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head id="Head1" runat="server">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>工程經費概算輔助系統</title>
  <!-- <link rel="stylesheet" type="text/css" href="CSS/BMS.css" /> -->
  <link rel="stylesheet" type="text/css" href="CSS/first.css" />
  <link href="css/menu.css" rel="stylesheet" type="text/css" />
  <link href="css/tree.css" rel="stylesheet" type="text/css" />

  <!-- <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script> -->
  <script src="Scripts/switchmenu.js" type="text/javascript"></script>

  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>

  <style type="text/css">
    body {
      margin-left: 0px;
      margin-top: 0px;
      margin-right: 0px;
      margin-bottom: 0px;
    }
  </style>
</head>

<body style="font-family:新細明體;"> */ ?>
  <table width="1500" border="0" cellpadding="0" cellspacing="0" class="top_table1">
    <tr>
      <td width="1235">
        <table width="100%" cellpadding="1" cellspacing="0" id="table1">
          <tr>
            <td width="24" bgcolor="#FFFFFF" class="list3">&nbsp;</td>
            <td width="64" colspan="3" bgcolor="#FFFFFF" class="list3"><strong>項次</strong></td>
            <td width="305" bgcolor="#FFFFFF" class="list3">項目說明</td>
            <td width="64" bgcolor="#FFFFFF" class="list3">單位</td>
            <td width="52" bgcolor="#FFFFFF" class="list3">比率</td>
            <td width="72" bgcolor="#FFFFFF" class="list3">數量</td>
            <td width="95" bgcolor="#FFFFFF" class="list3">單價</td>
            <td width="96" bgcolor="#FFFFFF" class="list3">複價</td>
            <td width="184" bgcolor="#FFFFFF" class="list3">備註</td>
            <td width="75" bgcolor="#FFFFFF" class="list7">審核</td>
            <!-- <td width="58" bgcolor="#FFFFFF" class="list7">比率</td>
            <td width="57" bgcolor="#FFFFFF" class="list7">數量</td>
            <td width="93" bgcolor="#FFFFFF" class="list7">單價</td>-->
            <td width="99" bgcolor="#FFFFFF" class="list7">複價</td> 
            <td width="105" bgcolor="#FFFFFF" class="list3">              
              <input type="button" name="button3" class="button3" value="新增" data-id="0" />
            </td>
          </tr>
          <?php
          foreach ($rows as $key => $row) {
            $subs = sql_get($db, "SELECT * FROM {$tablename} where parent_id=? and class=2 ".$queryStr , array($row['id']));
          ?>
            <?php if (empty($subs)) { ?>
              <tr class="first" data-f="1">
                <!-- <td class="td_font"><input name="radio<?php echo $key; ?>" type="radio" id="radio<?php echo $key; ?>" value="radio<?php echo $key; ?>" /> </td> -->
                <td><div class="feat-btn2" data-sn="<?php echo $key;?>"> </div></td>
                <td bgcolor="#FFFFFF" class="td_01"><?php echo $str_no[1][$key]; ?></td>
                <td bgcolor="#FFFFFF" class="td_font">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="td_font">&nbsp;</td>
                <td class="td_font btn-title" data-id="<?php echo $row['id'];?>">
                  <?php echo $row['title']; ?>
                </td>
                <td class="list2">&nbsp;</td>
                <td class="list2">
                  <div align="right"></div>
                </td>
                <td class="list2">
                  <div align="right"></div>
                </td>
                <td class="list2">
                  <div align="right"></div>
                </td>
                <td class="list2">
                  <div align="right"></div>
                </td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">
                  <div align="center"></div>
                </td>
                <!-- <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>-->
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td> 
                <td class="list2 opera">                   
                  <input type="button" name="button3" class="button3" value="新增" data-id="<?php echo $row['id'];?>" />
                  <input type="button" name="button4" class="button4" value="刪除" data-id="<?php echo $row['id'];?>" />
                </td>
              </tr>
            <?php } else { ?>
              <tr class="first first<?php echo $key;?> feat-show"  data-f="1">
                <!-- <td class="td_font"><input name="radio<?php echo $key; ?>" type="radio" id="radio<?php echo $key; ?>" value="radio<?php echo $key; ?>" /> </td> -->
                <td><div class="feat-btn" data-sn="<?php echo $key;?>"  data-f="2">+</div></td>
                <td bgcolor="#FFFFFF" class="td_01"><?php echo $str_no[1][$key]; ?></td>
                <td bgcolor="#FFFFFF" class="td_font">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="td_font">&nbsp;</td>
                <td class="td_font btn-title" data-id="<?php echo $row['id'];?>">
                  <?php echo $row['title']; ?>
                </td>
                <td class="list2">&nbsp;</td>
                <td class="list2">
                  <div align="right"></div>
                </td>
                <td class="list2">
                  <div align="right"></div>
                </td>
                <td class="list2">
                  <div align="right"></div>
                </td>
                <td class="list2">
                  <div align="right"></div>
                </td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">
                  <div align="center"></div>
                </td>
                <!-- <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>-->
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td> 
                <td class="list2 opera">                   
                  <input type="button" name="button3" class="button3" value="新增" data-id="<?php echo $row['id'];?>" />
                  <input type="button" name="button4" class="button4" value="刪除" data-id="<?php echo $row['id'];?>" />
                </td>
              </tr>
              <?php
              foreach ($subs as $key2 => $sub) {
                $sql = "SELECT * FROM {$tablename} where parent_id=? and class=3 ".$queryStr;
                $exec = array($sub['id']);
                $subs2 = sql_get($db, $sql, $exec);
                
              ?>
                <?php if (empty($subs2)) { ?>
                  <tr  class="feat feat-show<?php echo $key;?>"  data-f="2">
                    <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key . $key2; ?>" id="radio<?php echo $key . $key2; ?>" value="radio<?php echo $key . $key2; ?>" /> </td> -->
                    <td  class="feat-btn2" data-sn="<?php echo $key.$key2;?>"> </td>
                    <td bgcolor="#FFFFFF" class="td_04">&nbsp;</td>
                    <td bgcolor="#FFFFFF" class="td_04"><?php echo $str_no[2][$key2]; ?></td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04 btn-title" data-id="<?php echo $sub['id'];?>">
                      <?php echo $sub['title']; ?>
                    </td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">
                      <div align="right"></div>
                    </td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">
                      <div align="center"></div>
                    </td>
                    <!-- <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>-->
                    <td class="td_04">&nbsp;</td> 
                    <td class="td_04 opera">                   
                      <input type="button" name="button3" class="button3" value="新增" data-id="<?php echo $sub['id'];?>" />
                      <input type="button" name="button4" class="button4" value="刪除" data-id="<?php echo $sub['id'];?>" />
                    </td>
                  </tr>
                <?php } else { ?>
                  <tr  class="feat feat-show<?php echo $key;?>"  data-f="2">
                    <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key . $key2; ?>" id="radio<?php echo $key . $key2; ?>" value="radio<?php echo $key . $key2; ?>" /> </td> -->
                    <td><div class="feat-btn" data-sn="<?php echo $key.$key2;?>"  data-f="3"> + </div></td>
                    <td bgcolor="#FFFFFF" class="td_04">&nbsp;</td>
                    <td bgcolor="#FFFFFF" class="td_04"><?php echo $str_no[2][$key2]; ?></td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04 btn-title" data-id="<?php echo $sub['id'];?>">
                      <?php echo $sub['title']; ?>
                    </td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">
                      <div align="right"></div>
                    </td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">
                      <div align="center"></div>
                    </td>
                    <!-- <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>-->
                    <td class="td_04">&nbsp;</td> 
                    <td class="td_04 opera">                   
                      <input type="button" name="button3" class="button3" value="新增" data-id="<?php echo $sub['id'];?>" />
                      <input type="button" name="button4" class="button4" value="刪除" data-id="<?php echo $sub['id'];?>" />
                    </td>
                  </tr>
                  <?php
                  foreach ($subs2 as $key3 => $sub2) {
                    $sql = "SELECT * FROM {$tablename} where parent_id=? and class=4 ".$queryStr;
                    $exec = array($sub2['id']);
                    $subs3 = sql_get($db, $sql, $exec);
                    ?>
                      <?php if (empty($subs3)) { ?>
                      <tr  class="feat feat-show<?php echo $key.$key2;?> feat-show<?php echo $key;?>"  data-f="3">
                        <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key.$key2.$key3;?>" id="radio<?php echo $key.$key2.$key3;?>" value="radio<?php echo $key.$key2.$key3;?>" /></td> -->
                        <td class="feat-btn2" data-sn="<?php echo $key.$key2.$key3;?>"> </td>
                        <td class="font_main">&nbsp;</td>
                        <td class="font_main">&nbsp;</td>
                        <td class="td_01"><?php echo $str_no[3][$key3]; ?></td>
                        <td class="list2 btn-title" data-id="<?php echo $sub2['id'];?>">
                          <?php echo $sub2['title']; ?>
                        </td>
                        <td class="td_04">&nbsp;</td>
                        <td class="td_04">&nbsp;</td>
                        <td class="td_04">&nbsp;</td>
                        <td class="td_04">&nbsp;</td>
                        <td class="td_04">
                          <div align="right"></div>
                        </td>
                        <td class="td_04">&nbsp;</td>
                        <td class="td_04">
                          <div align="center"></div>
                        </td>
                        <!-- <td class="td_04">&nbsp;</td>
                        <td class="td_04">&nbsp;</td>
                        <td class="td_04">&nbsp;</td>-->
                        <td class="td_04">&nbsp;</td> 
                          <td class="list2 opera">                   
                            <input type="button" name="button3" class="button3" value="新增" data-id="<?php echo $sub2['id'];?>" />
                            <input type="button" name="button4" class="button4" value="刪除" data-id="<?php echo $sub2['id'];?>" />
                          </td>
                      </tr>
                      <?php } else { ?>
                        <tr  class="feat feat-show<?php echo $key.$key2;?> feat-show<?php echo $key;?>"  data-f="3">
                          <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key.$key2.$key3;?>" id="radio<?php echo $key.$key2.$key3;?>" value="radio<?php echo $key.$key2.$key3;?>" /></td> -->
                          <td class="feat-btn" data-sn="<?php echo $key.$key2.$key3;?>"   data-f="4"> + </td>
                          <td class="font_main">&nbsp;</td>
                          <td class="font_main">&nbsp;</td>
                          <td class="td_01"><?php echo $str_no[3][$key3]; ?></td>
                          <td class="list2 btn-title" data-id="<?php echo $sub2['id'];?>">
                            <?php echo $sub2['title']; ?>
                          </td>
                          <td class="td_04">&nbsp;</td>
                          <td class="td_04">&nbsp;</td>
                          <td class="td_04">&nbsp;</td>
                          <td class="td_04">&nbsp;</td>
                          <td class="td_04">
                            <div align="right"></div>
                          </td>
                          <td class="td_04">&nbsp;</td>
                          <td class="td_04">
                            <div align="center"></div>
                          </td>
                          <!-- <td class="td_04">&nbsp;</td>
                          <td class="td_04">&nbsp;</td>
                          <td class="td_04">&nbsp;</td>-->
                          <td class="td_04">&nbsp;</td> 
                          <td class="list2 opera">                   
                            <input type="button" name="button3" class="button3" value="新增" data-id="<?php echo $sub2['id'];?>" />
                            <input type="button" name="button4" class="button4" value="刪除" data-id="<?php echo $sub2['id'];?>" />
                          </td>
                        </tr>
                        <?php
                        foreach ($subs3 as $key4 => $sub3) {           
                          //資料分開兩張表
                          // $sql = "SELECT * FROM `budgets` where class_id=? ";
                          // $budget = getSingleRow($sql, array($sub3['id']));     
                          
                          //資料放在一起表
                          $budget = $sub3;
      
                          ?>
                          <tr data-f="4" class="feat feat-show<?php echo $key.$key2.$key3;?>  feat-show<?php echo $key.$key2;?> feat-show<?php echo $key;?>">
                            <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key.$key2.$key3;?>" id="radio<?php echo $key.$key2.$key3;?>" value="radio<?php echo $key.$key2.$key3;?>" /></td> -->
                            <td class="feat-btn2" data-sn="<?php echo $key.$key2.$key3.$key4;?>"> </td>
                            <td class="font_main">&nbsp;</td>
                            <td class="font_main">&nbsp;</td>
                            <td class="td_02"><?php echo $str_no[4][$key4]; ?></td>
                            <td class="list1 btn-title" data-id="<?php echo $sub3['id'];?>">
                              <?php echo $sub3['title']; ?> 
                            </td>   
                            <td class="list2">
                              <div align="center"><?php echo $budget['unit']?></div>
                            </td>
                            <td class="list2">&nbsp;<?php echo $budget['ratio']?></td>
                            <td class="list2">
                              <div align="right"><?php echo sprintf("%01.2f", $budget['quantity'])?></div>
                            </td>
                            <td class="list2">
                              <div align="right"><?php echo sprintf("%01.2f", $budget['price'])?></div>
                            </td>
                            <td class="list2">
                              <div align="right"><?php echo sprintf("%01.2f", $budget['reprice'])?></div>
                            </td>
                            <td class="list2">&nbsp;<?php echo $budget['remarks']?></td>
                            <td class="list2">
                              <div align="center"><img src="images/right.png" width="16" height="17" /></div>
                            </td>
                            <!-- <td class="list2">&nbsp;</td>
                            <td class="list2">&nbsp;</td>
                            <td class="list2">&nbsp;</td>-->   
                            <td class="list2">&nbsp;</td>       
                            <td class="list2 opera">                   
                              <!-- <input type="button" name="button3" class="button3" value="新增" data-id="<?php echo $sub3['id'];?>" /> -->
                              <input type="button" name="button4" class="button4" value="刪除" data-id="<?php echo $sub3['id'];?>" />
                            </td>
                          </tr>
                          <?php
                        }
                        ?>
                      <?php
                      }
                      ?>
                  <?php
                  }
                  ?>
                <?php } ?>
              <?php
              }
              ?>
            <?php } ?>
          <?php } ?>

          <tr>
            <td class="font_main">&nbsp;</td>
            <td class="font_main">&nbsp;</td>
            <td class="font_main">&nbsp;</td>
            <td class="font_main">&nbsp;</td>
            <td class="list">小計</td>
            <td class="list">　
              <div align="center"></div>
            </td>
            <td class="list">&nbsp;</td>
            <td class="list">
              <div align="right"></div>
            </td>
            <td class="list">
              <div align="right"></div>
            </td>
            <td class="list">
              <div align="right">53,600.00</div>
            </td>
            <td class="list">&nbsp;</td>
            <td class="list">
              <div align="center"></div>
            </td>
            <td class="list">&nbsp;</td>
            <td class="list">&nbsp;</td>
            <td class="list">&nbsp;</td>
            <td class="list">&nbsp;</td>
          </tr>
          <tr>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">
              <div align="right"></div>
            </td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">
              <div align="center"></div>
            </td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
            <td class="td_font">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

<?php /*
</body>

</html>
*/ ?>