
<table width="1500" border="0" cellpadding="0" cellspacing="0" class="top_table1">
  <tr>
    <td width="1235">
      <table width="100%" cellpadding="1" cellspacing="0" id="table1">
        <tr>
          <td width="24" bgcolor="#FFFFFF" class="list3">&nbsp;</td>
          <td width="44" colspan="3" bgcolor="#FFFFFF" class="list3"><strong>項次</strong></td>
          <td width="360" bgcolor="#FFFFFF" class="list3">項目說明</td>
          <td width="55" bgcolor="#FFFFFF" class="list3">Rank</td>
          <td width="54" bgcolor="#FFFFFF" class="list3">單位</td>
          <td width="52" bgcolor="#FFFFFF" class="list3">比率</td>
          <td width="72" bgcolor="#FFFFFF" class="list3">數量</td>
          <td width="105" bgcolor="#FFFFFF" class="list3">單價</td>
          <td width="106" bgcolor="#FFFFFF" class="list3">複價</td>
          <td width="278" bgcolor="#FFFFFF" class="list3">備註</td>
          <!-- <td width="65" bgcolor="#FFFFFF" class="list7">審核</td> -->
          <!-- <td width="58" bgcolor="#FFFFFF" class="list7">比率</td>
            <td width="57" bgcolor="#FFFFFF" class="list7">數量</td>
            <td width="93" bgcolor="#FFFFFF" class="list7">單價</td>-->
          <!-- <td width="99" bgcolor="#FFFFFF" class="list7">複價</td> -->
          <td width="105" bgcolor="#FFFFFF" class="list3">
            <input type="button" name="btn-add" class="btn-add" value="新增" data-id="0" />
          </td>
        </tr>
        <?php
        foreach ($rows as $key => $row) {
          $subs = sql_get($db, "SELECT * FROM {$tablename} where parent_id=? and class=2 " . $queryStr. $orderStr, array($row['id']));
        ?>
          <?php if (empty($subs)) { ?>
            <tr class="first" data-f="1">
              <!-- <td class="td_font"><input name="radio<?php echo $key; ?>" type="radio" id="radio<?php echo $key; ?>" value="radio<?php echo $key; ?>" /> </td> -->
              <td>
                <div class="more-btn2" data-sn="<?php echo $key; ?>"> </div>
              </td>
              <td bgcolor="#FFFFFF" class="td_01"><?php echo $str_no[1][$key]; ?></td>
              <td bgcolor="#FFFFFF" class="td_font">&nbsp;</td>
              <td bgcolor="#FFFFFF" class="td_font">&nbsp;</td>
              <td class="td_font btn-title" data-id="<?php echo $row['id']; ?>">
                <?php echo $row['title']; ?>
              </td>
              <td class="list2">
                <div class="txt"><?php echo $row['rank'] ?></div>
                <input type="text" class="ipt" name="rank" value="<?php echo $row['rank'] ?>">
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
              <!-- <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>-->
              <td class="list2 opera">
                <input type="button" name="btn-add" class="btn-add" value="新增" data-id="<?php echo $row['id']; ?>" />
                <input type="button" name="btn-rm" class="btn-rm" value="刪除" data-id="<?php echo $row['id']; ?>" />
              </td>
            </tr>
          <?php } else { ?>
            <tr class="first first<?php echo $key; ?> feat-show" data-f="1">
              <!-- <td class="td_font"><input name="radio<?php echo $key; ?>" type="radio" id="radio<?php echo $key; ?>" value="radio<?php echo $key; ?>" /> </td> -->
              <td>
                <div class="more-btn" data-sn="<?php echo $key; ?>" data-f="2">+</div>
              </td>
              <td bgcolor="#FFFFFF" class="td_01"><?php echo $str_no[1][$key]; ?></td>
              <td bgcolor="#FFFFFF" class="td_font">&nbsp;</td>
              <td bgcolor="#FFFFFF" class="td_font">&nbsp;</td>
              <td class="td_font btn-title" data-id="<?php echo $row['id']; ?>">
                <?php echo $row['title']; ?>
              </td>
              <td class="list2">
                <div class="txt"><?php echo $row['rank'] ?></div>
                <input type="text" class="ipt" name="rank" value="<?php echo $row['rank'] ?>">
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
              <!-- <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>
                <td bgcolor="#FFFFFF" class="list2">&nbsp;</td>-->
              <td class="list2 opera">
                <input type="button" name="btn-add" class="btn-add" value="新增" data-id="<?php echo $row['id']; ?>" />
                <input type="button" name="btn-rm" class="btn-rm" value="刪除" data-id="<?php echo $row['id']; ?>" />
              </td>
            </tr>
            <?php
            foreach ($subs as $key2 => $sub) {
              $sql = "SELECT * FROM {$tablename} where parent_id=? and class=3 " . $queryStr. $orderStr;
              $exec = array($sub['id']);
              $subs2 = sql_get($db, $sql, $exec);

            ?>
              <?php if (empty($subs2)) { ?>
                <tr class="feat feat-show<?php echo $key; ?>" data-f="2">
                  <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key . $key2; ?>" id="radio<?php echo $key . $key2; ?>" value="radio<?php echo $key . $key2; ?>" /> </td> -->
                  <td class="more-btn2" data-sn="<?php echo $key . $key2; ?>"> </td>
                  <td bgcolor="#FFFFFF" class="td_04">&nbsp;</td>
                  <td bgcolor="#FFFFFF" class="td_04"><?php echo $str_no[2][$key2]; ?></td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04 btn-title" data-id="<?php echo $sub['id']; ?>">
                    <?php echo $sub['title']; ?>
                  </td>
                  <td class="list2">
                    <div class="txt"><?php echo $sub['rank'] ?></div>
                    <input type="text" class="ipt" name="rank" value="<?php echo $sub['rank'] ?>">
                  </td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04">
                    <div align="right"></div>
                  </td>
                  <td class="td_04">&nbsp;</td>
                  <!-- <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>-->
                  <td class="td_04 opera">
                    <input type="button" name="btn-add" class="btn-add" value="新增" data-id="<?php echo $sub['id']; ?>" />
                    <input type="button" name="btn-rm" class="btn-rm" value="刪除" data-id="<?php echo $sub['id']; ?>" />
                  </td>
                </tr>
              <?php } else { ?>
                <tr class="feat feat-show<?php echo $key; ?>" data-f="2">
                  <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key . $key2; ?>" id="radio<?php echo $key . $key2; ?>" value="radio<?php echo $key . $key2; ?>" /> </td> -->
                  <td>
                    <div class="more-btn" data-sn="<?php echo $key . $key2; ?>" data-f="3"> + </div>
                  </td>
                  <td bgcolor="#FFFFFF" class="td_04">&nbsp;</td>
                  <td bgcolor="#FFFFFF" class="td_04"><?php echo $str_no[2][$key2]; ?></td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04 btn-title" data-id="<?php echo $sub['id']; ?>">
                    <?php echo $sub['title']; ?>
                  </td>
                  <td class="list2">
                    <div class="txt"><?php echo $sub['rank'] ?></div>
                    <input type="text" class="ipt" name="rank" value="<?php echo $sub['rank'] ?>">
                  </td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04">&nbsp;</td>
                  <td class="td_04">
                    <div align="right"></div>
                  </td>
                  <td class="td_04">&nbsp;</td>
                  <!-- <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>
                    <td class="td_04">&nbsp;</td>-->
                  <td class="td_04 opera">
                    <input type="button" name="btn-add" class="btn-add" value="新增" data-id="<?php echo $sub['id']; ?>" />
                    <input type="button" name="btn-rm" class="btn-rm" value="刪除" data-id="<?php echo $sub['id']; ?>" />
                  </td>
                </tr>
                <?php
                foreach ($subs2 as $key3 => $sub2) {
                  $sql = "SELECT * FROM {$tablename} where parent_id=? and class=4 " . $queryStr. $orderStr;
                  $exec = array($sub2['id']);
                  $subs3 = sql_get($db, $sql, $exec);
                ?>
                  <?php if (empty($subs3)) { ?>
                    <tr class="feat feat-show<?php echo $key . $key2; ?> feat-show<?php echo $key; ?>" data-f="3">
                      <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key . $key2 . $key3; ?>" id="radio<?php echo $key . $key2 . $key3; ?>" value="radio<?php echo $key . $key2 . $key3; ?>" /></td> -->
                      <td class="more-btn2" data-sn="<?php echo $key . $key2 . $key3; ?>"> </td>
                      <td class="font_main">&nbsp;</td>
                      <td class="font_main">&nbsp;</td>
                      <td class="td_01"><?php echo $str_no[3][$key3]; ?></td>
                      <td class="list2 btn-title" data-id="<?php echo $sub2['id']; ?>">
                        <?php echo $sub2['title']; ?>
                      </td>
                      <td class="list2">
                        <div class="txt"><?php echo $sub2['rank'] ?></div>
                        <input class="ipt" type="text" name="rank" value="<?php echo $sub2['rank'] ?>">
                      </td>
                      <td class="td_04">&nbsp;</td>
                      <td class="td_04">&nbsp;</td>
                      <td class="td_04">&nbsp;</td>
                      <td class="td_04">&nbsp;</td>
                      <td class="td_04">
                        <div align="right"></div>
                      </td>
                      <td class="td_04">&nbsp;</td>
                      <!-- <td class="td_04">&nbsp;</td>
                        <td class="td_04">&nbsp;</td>
                        <td class="td_04">&nbsp;</td>-->
                      <td class="list2 opera">
                        <input type="button" name="btn-add" class="btn-add" value="新增" data-id="<?php echo $sub2['id']; ?>" />
                        <input type="button" name="btn-rm" class="btn-rm" value="刪除" data-id="<?php echo $sub2['id']; ?>" />
                      </td>
                    </tr>
                  <?php } else { ?>
                    <tr class="feat feat-show<?php echo $key . $key2; ?> feat-show<?php echo $key; ?>" data-f="3">
                      <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key . $key2 . $key3; ?>" id="radio<?php echo $key . $key2 . $key3; ?>" value="radio<?php echo $key . $key2 . $key3; ?>" /></td> -->
                      <td class="more-btn" data-sn="<?php echo $key . $key2 . $key3; ?>" data-f="4"> + </td>
                      <td class="font_main">&nbsp;</td>
                      <td class="font_main">&nbsp;</td>
                      <td class="td_01"><?php echo $str_no[3][$key3]; ?></td>
                      <td class="list2 btn-title" data-id="<?php echo $sub2['id']; ?>">
                        <?php echo $sub2['title']; ?>
                      </td>
                      <td class="list2">
                        <div class="txt"><?php echo $sub2['rank'] ?></div>
                        <input class="ipt" type="text" name="rank" value="<?php echo $sub2['rank'] ?>">
                      </td>
                      <td class="td_04">&nbsp;</td>
                      <td class="td_04">&nbsp;</td>
                      <td class="td_04">&nbsp;</td>
                      <td class="td_04">&nbsp;</td>
                      <td class="td_04">
                        <div align="right"></div>
                      </td>
                      <td class="td_04">&nbsp;</td>
                      <!-- <td class="td_04">&nbsp;</td>
                          <td class="td_04">&nbsp;</td>
                          <td class="td_04">&nbsp;</td>-->
                      <td class="list2 opera">
                        <input type="button" name="btn-add" class="btn-add" value="新增" data-id="<?php echo $sub2['id']; ?>" />
                        <input type="button" name="btn-rm" class="btn-rm" value="刪除" data-id="<?php echo $sub2['id']; ?>" />
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
                      <tr data-f="4" class="feat feat-show<?php echo $key . $key2 . $key3; ?>  feat-show<?php echo $key . $key2; ?> feat-show<?php echo $key; ?>">
                        <!-- <td class="font_main"> <input type="radio" name="radio<?php echo $key . $key2 . $key3; ?>" id="radio<?php echo $key . $key2 . $key3; ?>" value="radio<?php echo $key . $key2 . $key3; ?>" /></td> -->
                        <td class="more-btn2" data-sn="<?php echo $key . $key2 . $key3 . $key4; ?>"> </td>
                        <td class="font_main">&nbsp;</td>
                        <td class="font_main">&nbsp;</td>
                        <td class="td_02"><?php echo $str_no[4][$key4]; ?></td>
                        <td class="list1 btn-title" data-id="<?php echo $sub3['id']; ?>">
                          <?php echo $sub3['title']; ?>
                        </td>
                        <td class="list2">
                          <div class="txt"><?php echo $sub3['rank'] ?></div>
                          <input type="text" class="ipt" name="rank" value="<?php echo $sub3['rank'] ?>">
                        </td>
                        <td class="list2">
                          <div class="txt"><?php echo $budget['unit'] ?></div>
                          <input class="ipt" type="text" name="unit" value="<?php echo $budget['unit'] ?>" >
                        </td>
                        <td class="list2">&nbsp;<?php echo $budget['ratio'] ?></td>
                        <td class="list2">
                          <div class="txt"><?php echo sprintf("%01.1f", $budget['quantity']) ?></div>
                          <input class="ipt" type="text" name="quantity" value="<?php echo sprintf("%01.1f", $budget['quantity']) ?>" >
                        </td>
                        <td class="list2">
                          <div class="txt"><?php echo sprintf("%01.1f", $budget['price']) ?></div>
                          <input class="ipt" type="text" name="price" value="<?php echo sprintf("%01.1f", $budget['price']) ?>" >
                        </td>
                        <td class="list2">&nbsp;<?php echo sprintf("%01.1f", $budget['reprice']) ?></td>
                        <td class="list2">&nbsp;<?php echo $budget['remarks'] ?></td>
                        <!-- <td class="list2">&nbsp;</td>
                            <td class="list2">&nbsp;</td>
                            <td class="list2">&nbsp;</td>-->
                        <td class="list2 opera">
                          <!-- <input type="button" name="btn-add" class="btn-add" value="新增" data-id="<?php echo $sub3['id']; ?>" /> -->
                          <input type="button" name="btn-rm" class="btn-rm" value="刪除" data-id="<?php echo $sub3['id']; ?>" />
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
