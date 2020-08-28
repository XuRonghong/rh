<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw">

<head>
        <!-- <meta charset=" utf-8"> -->
    <title>工程經費概算輔助系統</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="stylesheet" href="resources/css/first.css" type="text/css">

    <style type="text/css">
    </style>
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <!-- ImageReady Slices (工程經費概算系統index.psd) -->
  <br>
  <table width="800" height="486" border="0" align="center" cellpadding="0" cellspacing="0" id="___01">
    <tr>
      <td rowspan="2">
        <img src="images/index_01.jpg" width="190" height="184" alt=""></td>
      <td>
        <img src="images/index_02.jpg" width="125" height="145" alt=""></td>
      <td>
        <img src="images/index_03.jpg" width="296" height="145" alt=""></td>
      <td rowspan="2">
        <img src="images/index_04.jpg" width="189" height="184" alt=""></td>
    </tr>
    <tr>
      <td colspan="2">
        <img src="images/index_05.jpg" width="421" height="39" alt=""></td>
    </tr>

    <form action="index.php?r=login&f=signin" method="post" id="form_login">

    <tr>
      <td rowspan="2">
        <img src="images/index_06.jpg" width="190" height="207" alt=""></td>
      <td colspan="2" background="images/index_07.jpg">
        <table width="421" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="413" height="122">

              <TABLE width="355" height="109" align="center">
                <TBODY>

                  <TR>
                    <TD class="style1">
                      <div align="right" class="font_c_main">帳號</div>
                    </TD>
                    <TD width="242" class="style1">
                      <div align="left" class="style2">
                        <INPUT id="txtAccount2" name="account" maxLength="10" size="20" type="text" required="required">
                      </div>
                    </TD>
                  </TR>
                  <TR>
                    <TD class="style1">
                      <div align="right" class="font_c_main">密碼</div>
                    </TD>
                    <TD class="style1">
                      <div align="left" class="style2">
                        <INPUT id="txtPassword2" name="password" maxLength="30" size="21" type="password" required="required">
                      </div>
                    </TD>
                  </TR>
                  <TR>
                    <TD class="style1">
                      <div align="right" class="style2"></div>
                    </TD>
                    <TD class="style1">
                      <div align="left" class="style2">
                        <input type="checkbox" name="checkbox" id="checkbox">
                        <span class="font_c_main">記住我的登入狀態</span></div>
                    </TD>
                  </TR>
                </TBODY>
              </TABLE>

            </td>
          </tr>
        </table>
      </td>
      <td rowspan="2">
        <img src="images/index_08.jpg" width="189" height="207" alt=""></td>
    </tr>
    <tr>
      <td>
        <img src="images/index_09.jpg" width="125" height="85" alt="">
      </td>
      <td valign="top" background="images/index_10.jpg">
        <table width="132" border="0" cellpadding="0" cellspacing="2">
          <tr>
            <td width="62">
              <div align="right">
                <a href="#" id="a_submit">
                  <img src="images/btn_ login.gif" alt="登入" width="49" height="23" border="0">
                </a>         
              </div>
            </td>
            <td width="64"><img src="images/btn_clear.gif" alt="清除" width="49" height="23" border="0"></td>
          </tr>
        </table>
      </td>
    </tr>

    </form>

    <tr>
      <td>
        <img src="images/index_11.jpg" width="190" height="95" alt=""></td>
      <td colspan="2">
        <img src="images/index_12.jpg" width="421" height="95" alt=""></td>
      <td>
        <img src="images/index_13.jpg" width="189" height="95" alt=""></td>
    </tr>
  </table>
  <!-- End ImageReady Slices -->
  
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script type="text/javascript">
    $(function () {

      $('#a_submit').click(function(){
        var form = $('#form_login');
        if ($('#txtAccount2').val() == '') {
          alert('帳號為空');        
        } else if ($('#txtPassword2').val() =='') {
          alert('密碼為空');
        } else {
          form.submit();
        }
      });

        // $(':input[type="submit"]').prop('disabled', true);
        // form = "";
        // var data = {"_token": "{{ csrf_token() }}"};
        // data.vAccount = $("#vAccount").val();
        // // data.vPassword = CryptoJS.MD5($("#vPassword").val()).toString(CryptoJS.enc.Base64);
        // $.ajax({
        //     url: 'index.php?r=login',
        //     data: data,
        //     type: "POST",
        //     resetForm: true,
        //     success: function (rtndata) {
                // if (rtndata.status) {
                    // Swal.fire("{{trans('web_alert.notice')}}", rtndata.message, "success");

                    // if ($('input[name=remember]').prop("checked")) {
                    //     localStorage.setItem('account', $("#vAccount").val());
                    //     localStorage.setItem('password', $("#vPassword").val());
                    //     localStorage.setItem('remember', true);
                    // } else {
                    //     localStorage.setItem('account', '');
                    //     localStorage.setItem('password', '');
                    //     localStorage.setItem('remember', false);
                    // }
        //             setTimeout(function () {
        //                 location.href = rtndata.rtnurl;
        //             }, 1000)
        //         } else {
        //             // Swal.fire("{{trans('web_alert.notice')}}", rtndata.message, "error");
        //             // $(':input[type="submit"]').prop('disabled', false);
        //             console.log( rtndata.message);
        //         }
        //     }
        // });
    });
  </script>

</body>

</html>