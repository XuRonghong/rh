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

<head>
  <title>工程經費概算輔助系統</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
  <link href="css/first.css" rel="stylesheet" type="text/css">
  <style type="text/css">
  </style>

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
        if(/*account=='' ||*/ pw=='') {
          alert('Empty')
          $("[name~='password']").focus()
          return
        }
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
          },
          url: "ajax/api_login.php",
          type: "POST",
          data: {
            'type': 'login',
            // 'account': account,
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
        <td rowspan="2"><img src="images/index_01.jpg" width="190" height="184" alt=""></td>
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
                    <!-- <tr>
                      <td class="style1">
                        <div align="right" class="font_c_main">帳號</div>
                      </td>
                      <td width="242" class="style1">
                        <div align="left" class="style2">
                          <input id="txtAccount" name="account" maxLength="20" size="20" type="text">
                        </div>
                      </td>
                    </tr> -->
                    <tr>
                      <td class="style1">
                        <div align="right" class="font_c_main">密碼</div>
                      </td>
                      <td class="style1">
                        <div align="left" class="style2">
                          <input id="txtPassword" name="password" maxLength="20" size="20" type="password">
                        </div>
                      </td>
                    </tr>
                    <!-- <tr>
                      <td class="style1">
                        <div align="right" class="style2"></div>
                      </td>
                      <td class="style1">
                        <div align="left" class="style2">
                          <input type="checkbox" name="ckbRememberMe" id="ckbRememberMe">
                          <span class="font_c_main">記住我的登入狀態</span>
                        </div>
                      </td>
                    </tr> -->
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
              <td width="62">
                <div align="right">
                  <a class="btn-submit">
                    <img src="images/btn_ login.gif" alt="登入" width="49" height="23" border="0">
                  </a>
                </div>
              </td>
              <td width="64">
                <a class="btn-clear">
                  <img src="images/btn_clear.gif" alt="清除" width="49" height="23" border="0">
                </a>
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