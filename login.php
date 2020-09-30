<?php
include_once dirname(__FILE__) . '/config.php';

$tablename = 'units';
$queryStr = " AND status=1 ";
$orderStr = " ORDER BY rank ASC ";
$rs = $db->prepare("SELECT * FROM {$tablename} WHERE id=:id ". $queryStr. $orderStr);
$rs->execute( array('id'=> data_get($_SESSION, 'admin_unit', 1)) );
$row = $rs->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="tw">

<head>
  <title>工程經費概算輔助系統 -登入</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
  <link href="css/master.css" rel="stylesheet" type="text/css">
  <link href="css/first.css" rel="stylesheet" type="text/css">
  <style type="text/css">
  </style>

  <?php require_once dirname(__FILE__) . '/layouts/script.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
  <script>
    $(document).ready(function() {
      //用JavaScript抓取Enter事件並按下按鈕
      $("[name~='password']").keypress(function(e) {
        let key = window.event ? e.keyCode : e.which
        if (key == 13) $('.btn-submit').click()
      })


      //b、 讀取cookie  
      let account = Cookies.get('account') || '' //獲取cookie
      let pw = Cookies.get('pw') || '' //獲取cookie
      //Cookies.get(); //#讀取所有的cookie
      if (account != '' && pw != '') {
        $("[name~='account']").val('' + account)
        $("[name~='password']").val('' + pw)
        $("[class~='ckbRememberMe']").prop('checked', true)
      }

    })

    //DOM讀取完後做..
    document.addEventListener("DOMContentLoaded", function() {
      $("[name~='account']").focus()

      $(".btn-clear").click(function() {
        $("[name~='account']").val('')
        $("[name~='password']").val('')
        $("[class~='ckbRememberMe']").prop('checked', false)
      })

      $(".btn-submit").click(function() {
        var account = $("[name~='account']").val() || ''
        var pw = $("[name~='password']").val() || ''
        var chk = $("[class~='ckbRememberMe']").prop('checked') || false
        if (account == '' || pw == '') {
          alert('帳號或密碼為空')
          return
        }

        if (chk) {
          //a、設定cookie
          Cookies.set('account', account, {
            expires: 7,
            path: ''
          }); //7天過期
          Cookies.set('pw', pw, {
            expires: 7,
            path: ''
          });
        } else {
          //c、 刪除cookie
          Cookies.remove('account', {
            path: ''
          }); //#刪除cookie時必須是同一個路徑。
          Cookies.remove('pw', {
            path: ''
          }); //#刪除cookie時必須是同一個路徑。
        }

        $.ajax({
          headers: {
            'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
          },
          url: "ajax/api_login.php",
          type: "POST",
          data: {
            'router': 'accounts',
            'type': 'login',
            'account': account,
            'password': pw
          },
          cache: false,
          // resetForm: true,
          success: function(rtndata) {
            rtndata = JSON.parse(rtndata)
            if (rtndata.status > 0) {
              location.href = rtndata.url
            } else {
              alert(rtndata.message)
              console.log(JSON.stringify(rtndata))
              $("[name~='password']").focus()
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

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <!-- ImageReady Slices (工程經費概算系統index.psd) -->
  <br>

  <form id="form_login1" method="POST">

    <table width="800" height="486" border="0" align="center" cellpadding="0" cellspacing="0" id="___01">
      <tr>
        <td rowspan="2">
          <img src="storage/<?php echo $tablename.'/'.data_get($row, 'Logo', '../images/index_01.jpg'); ?>" width="190" height="184" alt="logo">
        </td>
        <td><img src="images/index_02.jpg" width="125" height="145" alt=""></td>
        <td><img src="images/index_03.jpg" width="296" height="145" alt=""></td>
        <td rowspan="2"><img src="images/index_04.jpg" width="189" height="184" alt=""></td>
      </tr>
      <tr>
        <td colspan="2"><img src="images/index_05.jpg" width="421" height="39" alt=""></td>
      </tr>
      <tr>
        <td rowspan="2"><img src="images/index_06.jpg" width="190" height="207" alt=""></td>
        <td colspan="2" background="images/index_07.jpg">
          <table width="421" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="413" height="122">
                <table width="355" height="109" align="center">
                  <tbody>
                    <tr>
                      <td class="style1">
                        <div align="right" class="font_c_main">帳號</div>
                      </td>
                      <td class="style1">
                        <div align="left" class="style2">
                          <input class=" iptAccount" name="account" maxLength="20" size="20" type="text">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="style1">
                        <div align="right" class="font_c_main">密碼</div>
                      </td>
                      <td class="style1">
                        <div align="left" class="style2">
                          <input class=" iptPassword" name="password" maxLength="20" size="20" type="password">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="style1">
                        <div align="right" class="style2"></div>
                      </td>
                      <td class="style1">
                        <div align="left" class="style2">
                          <input type="checkbox" name="ckbRememberMe" class="ckbRememberMe">
                          <span class="font_c_main">記住我的登入狀態</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </table>
        </td>
        <td rowspan="2"><img src="images/index_08.jpg" width="189" height="207" alt=""></td>
      </tr>
      <tr>
        <td><img src="images/index_09.jpg" width="125" height="85" alt=""></td>
        <td valign="top" background="images/index_10.jpg">
          <table width="132" border="0" cellpadding="0" cellspacing="2">
            <tr>
              <td width="62" style="text-align: right;">
                <img src="images/btn_ login.gif" class="btn btn-submit" alt="登入" width="49" height="23" border="0">
              </td>
              <td width="64">
                <img src="images/btn_clear.gif" class="btn btn-clear" alt="清除" width="49" height="23" border="0">
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <img src="images/index_11.jpg" width="190" height="95" alt=""></td>
        <td colspan="2">
          <img src="images/index_12.jpg" width="421" height="95" alt=""></td>
        <td>
          <img src="images/index_13.jpg" width="189" height="95" alt=""></td>
      </tr>
    </table>

  </form>

  <!-- End ImageReady Slices -->
</body>

</html>