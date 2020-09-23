<?php
include_once dirname(__FILE__) . '/config.php';
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

    <?php require_once dirname(__FILE__) . '/layouts/script.php'; ?>
    <script src="Scripts/switchmenu.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            //用JavaScript抓取Enter事件並按下按鈕
            $(".txtPassword").keypress(function(e) {
                let key = window.event ? e.keyCode : e.which
                if (key == 13) $('.btn-submit').click()
            })
        })

        document.addEventListener("DOMContentLoaded", function() {

            $(".btn-clear").click(function() {
                $(".txtPassword").val('')
            })

            $(".btn-submit").click(function() {
                var pw = $("[name~='password']").val() || ''
                var pw1 = $("[name~='password_1']").val() || ''
                var pw2 = $("[name~='password_2']").val() || ''
                if (pw == '' || pw1 == '' || pw2 == '') {
                    alert('Empty')
                    return
                }
                if (pw1 !== pw2) {
                    alert('密碼確認有誤')
                    $("[name~='password_2']").focus()
                    return
                }
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                    url: "ajax/api_login.php",
                    type: "POST",
                    data: {
                        'router': 'accounts',
                        'type': 'update',
                        'password': pw,
                        'password1': pw1
                    },
                    cache: false,
                    resetForm: true,
                    success: function(rtndata) {
                        rtndata = JSON.parse(rtndata)
                        if (rtndata.status > 0) {
                            alert(rtndata.message)
                            location.href = rtndata.url
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
                                        <table width="100%" cellpadding="2" cellspacing="0">
                                            <tr>
                                                <td colspan="6" bgcolor="#FFFFFF" class="form1_td">
                                                    <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td width="3%"><img src="images/document_alt_fill_16x16.png" width="24" height="16" border="0" /></td>
                                                            <td width="88%">變更密碼</td>
                                                            <td width="9%">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="list2"></td>
                                                <td class="list2"></td>
                                                <td class="list2">舊密碼</td>
                                                <td width="25%" class="list2">
                                                    <form id="form5" name="form5" method="post" action="">
                                                        <label>
                                                            <input class="txtPassword" name="password" maxLength="20" size="20" type="password">
                                                        </label>
                                                    </form>
                                                </td>
                                                <td width="7%" class="list2"></td>
                                                <td width="29%" class="list2"></td>
                                            </tr>
                                            <tr>
                                                <td width="7%" class="list2"></td>
                                                <td width="25%" class="list2"></td>
                                                <td width="7%" class="list2">新密碼</td>
                                                <td class="list2">
                                                    <form id="form5" name="form5" method="post" action="">
                                                        <label>
                                                            <input class="txtPassword" name="password_1" maxLength="20" size="20" type="password">
                                                        </label>
                                                    </form>
                                                </td>
                                                <td class="list2"></td>
                                                <td class="list2"></td>
                                            </tr>
                                            <tr>
                                                <td class="list2"></td>
                                                <td class="list2"></td>
                                                <td class="list2">密碼確認</td>
                                                <td class="list2">
                                                    <form id="form8" name="form8" method="post" action="">
                                                        <label>
                                                            <input class="txtPassword" name="password_2" maxLength="20" size="20" type="password">
                                                        </label>
                                                    </form>
                                                </td>
                                                <td class="list2"></td>
                                                <td class="list2"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" bgcolor="#FFFFFF">
                                                    <div align="center">
                                                        <form id="form11" name="form11" method="post" action="#">
                                                            <input type="button" name="btn-submit" class="btn btn-submit" value="確定" />
                                                            <input type="button" name="btn-clear" class="btn btn-clear" value="清除" />
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
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
</body>

</html>