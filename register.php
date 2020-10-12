<?php
include_once dirname(__FILE__) . '/config.php';
?>
<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw" dir="ltr">

<head id="Head1" runat="server">
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>建築工料分析系統 -註冊使用</title>
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
                            <form class="form_register">
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
                                                                <td width="88%">新增使用者</td>
                                                                <td width="9%">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="list2" colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td class="list2"></td>
                                                    <td class="list2"></td>
                                                    <td class="list2">帳號</td>
                                                    <td width="25%" class="list2">
                                                        <label>
                                                            <input class="txtAccount" name="Account" maxLength="20" size="20" type="text" required>
                                                        </label>
                                                    </td>
                                                    <td width="7%" class="list2"></td>
                                                    <td width="29%" class="list2"></td>
                                                </tr>
                                                <tr>
                                                    <td width="7%" class="list2"></td>
                                                    <td width="25%" class="list2"></td>
                                                    <td width="7%" class="list2">密碼</td>
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
                                                    <td class="list2" colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td class="list2"></td>
                                                    <td class="list2"></td>
                                                    <td class="list2">單位統編</td>
                                                    <td width="25%" class="list2">
                                                        <label>
                                                            <input class="txtAccount" name="Code1" maxLength="20" size="20" type="text" required>
                                                        </label>
                                                    </td>
                                                    <td width="7%" class="list2"></td>
                                                    <td width="29%" class="list2"></td>
                                                </tr>
                                                <tr>
                                                    <td class="list2"></td>
                                                    <td class="list2"></td>
                                                    <td class="list2">名稱</td>
                                                    <td width="25%" class="list2">
                                                        <label>
                                                            <input class="txtAccount" name="Name" maxLength="20" size="20" type="text" required>
                                                        </label>
                                                    </td>
                                                    <td width="7%" class="list2"></td>
                                                    <td width="29%" class="list2"></td>
                                                </tr>
                                                <tr>
                                                    <td class="list2"></td>
                                                    <td class="list2"></td>
                                                    <td class="list2">Rank</td>
                                                    <td width="25%" class="list2">
                                                        <label>
                                                            <input type="text" name="rank" id="rank" value="" />
                                                        </label>
                                                    </td>
                                                    <td width="7%" class="list2"></td>
                                                    <td width="29%" class="list2"></td>
                                                </tr>
                                                <tr>
                                                    <td class="list2"></td>
                                                    <td class="list2"></td>
                                                    <td class="list2">系統權限</td>
                                                    <td class="list2">
                                                        <label>
                                                            <select name="System" id="System" class="optSystem">
                                                                <option value="3">填報人員</option>
                                                                <option value="2">審核人員</option>
                                                                <option value="1">系統人員</option>
                                                            </select>
                                                        </label>
                                                    </td>
                                                    <td width="7%" class="list2"></td>
                                                    <td width="29%" class="list2"></td>
                                                </tr>
                                                <tr>
                                                    <td class="list2"></td>
                                                    <td class="list2"></td>
                                                    <td width="6%" class="list2"></td>
                                                    <td width="18%" class="list2">
                                                        <input type="radio" name="active" class="active" value="1">啟用
                                                        <input type="radio" name="active" class="active" value="0" checked>未啟用
                                                    </td>
                                                    <td width="7%" class="list2"></td>
                                                    <td width="29%" class="list2"></td>
                                                </tr>
                                                <tr>
                                                    <td class="list2" colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" bgcolor="#FFFFFF">
                                                        <div align="center">
                                                            <input type="submit" name="btn-submit" class="btn btn-submit" value="確定" />
                                                            <input type="reset" name="btn-clear" class="btn btn-clear" value="清除" />
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

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                    url: "ajax/api_register.php",
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
</body>

</html>