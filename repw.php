<?php
include_once dirname(__FILE__) . '/config.php';

$gets = filterVar($_GET);

if (isset($gets['u'])) {
    if (data_get($_SESSION, 'admin_auth1') != 1) {
        header("location: 401.php");
    }
    
    $row = getSingleRow("SELECT * FROM `accounts` WHERE `id`=? ", array($gets['u']));
}
?>
<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw" dir="ltr">

<head id="Head1" runat="server">
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>建築工料分析系統 -更改密碼</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <!-- InstanceEndEditable -->

    <link href="css/master.css" rel="stylesheet" type="text/css">
    <link href="css/menu.css" rel="stylesheet" type="text/css" />
    <link href="css/tree.css" rel="stylesheet" type="text/css" />
    <link href="css/first.css" rel="stylesheet" type="text/css" />
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

                            <form class="form_repw">
                                <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#003333">
                                    <tr>
                                        <td width="100%">
                                            <table width="100%" cellpadding="2" cellspacing="0">
                                                <tr>
                                                    <td colspan="6" bgcolor="#FFFFFF" class="form1_td">
                                                        <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td width="3%">
                                                                    <a onclick="history.go(-1)" style="cursor: pointer;"><img src="images/Previous_01.gif" width="24" height="16" border="0" /></a>
                                                                </td>
                                                                <td width="88%">變更密碼</td>
                                                                <td width="9%">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <?php if (isset($gets['u'])) { ?>
                                                    <tr>
                                                        <td class="list2"></td>
                                                        <td class="list2"></td>
                                                        <td class="list2">帳號</td>
                                                        <td width="25%" class="list2">
                                                            <label>
                                                                <input type="text" name="Account" maxLength="20" size="20" value="<?php echo $row['Account'];?>" disabled>
                                                                <input type="hidden" name="id" value="<?php echo $gets['u']; ?>" />
                                                            </label>
                                                        </td>
                                                        <td width="7%" class="list2"></td>
                                                        <td width="29%" class="list2"></td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td class="list2"></td>
                                                        <td class="list2"></td>
                                                        <td class="list2">舊密碼</td>
                                                        <td width="25%" class="list2">
                                                            <label>
                                                                <input class="txtPassword" name="password" maxLength="20" size="20" type="password" required>
                                                            </label>
                                                        </td>
                                                        <td width="7%" class="list2"></td>
                                                        <td width="29%" class="list2"></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td width="7%" class="list2"></td>
                                                    <td width="25%" class="list2"></td>
                                                    <td width="7%" class="list2">新密碼</td>
                                                    <td class="list2">
                                                        <label>
                                                            <input class="txtPassword" name="PSWord" maxLength="20" size="20" type="password" required>
                                                        </label>
                                                    </td>
                                                    <td class="list2"></td>
                                                    <td class="list2"></td>
                                                </tr>
                                                <tr>
                                                    <td class="list2"></td>
                                                    <td class="list2"></td>
                                                    <td class="list2">密碼確認</td>
                                                    <td class="list2">
                                                        <label>
                                                            <input class="txtPassword" name="password_2" maxLength="20" size="20" type="password" required>
                                                        </label>
                                                    </td>
                                                    <td class="list2"></td>
                                                    <td class="list2"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" bgcolor="#FFFFFF">
                                                        <div align="center">
                                                            <input type="submit" name="btn-submit" class="btn btn-submit" value="確定" />
                                                            <input type="reset" name="btn-clear" class="btn btn-clear" value="清除" />
                                                            <input type="hidden" name="router" value="accounts" />
                                                            <input type="hidden" name="type" value="update" />
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </form>

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
            //用JavaScript抓取Enter事件並按下按鈕
            $(".txtPassword").keypress(function(e) {
                let key = window.event ? e.keyCode : e.which
                if (key == 13) $('.btn-submit').click()
            })
        })

        document.addEventListener("DOMContentLoaded", function() {

            $('form').on('submit', function(e) {
                e.preventDefault();

                var pw = $("[name~='PSWord']").val() || ''
                var pw2 = $("[name~='password_2']").val() || ''
                if (pw !== pw2) {
                    alert('密碼確認有誤')
                    $("[name~='password_2']").focus()
                    return
                }

                var form = $('form')[0];
                var formData = new FormData(form);
                let gotoUrl = '<?php echo data_get($gets,'go');?>';
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                    url: "ajax/api_login.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    resetForm: true,
                    success: function(rtndata) {
                        rtndata = JSON.parse(rtndata)
                        if (rtndata.status > 0) {
                            alert(rtndata.message)
                            // location.href = rtndata.url
                            location.href = decodeURIComponent(gotoUrl)//rtndata.url
                        } else {
                            alert(rtndata.message)
                            if (rtndata.code == 1) {
                                $("[name~='password']").focus()
                            } else if (rtndata.code == 2) {
                                $("[name~='password1']").focus()
                            }
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
</body>

</html>