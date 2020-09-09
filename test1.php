<?php
include_once dirname(__FILE__) . '/config.php';

$tablename = 'class';
$queryStr = " and open=1 ";
$rs = $db->prepare("SELECT * FROM {$tablename} where class=1 ".$queryStr);
$rs->execute();
$rows = $rs->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw" dir="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>建築工料分析系統</title>


    <link href="css/menu.css" rel="stylesheet" type="text/css" />
    <link href="css/tree.css" rel="stylesheet" type="text/css" />
    <link href="css/first.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
    .feat-btn {
        text-align: center;
        font-size: large;
    }
    .btn-title {
        cursor: pointer;
    }
    .td_01 {
        width: 30px;
        text-align: left;
    }
    .button4 {
        box-shadow:inset 0px 39px 0px -24px #e67a73;
        background-color:#e4685d;
        border-radius:4px;
        border:1px solid #ffffff;
        /* display:inline-block; */
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:12px;
        padding:4px 12px;
        text-decoration:none;
        text-shadow:0px 1px 0px #b23e35;
        
        float: right;
        right: 1px;
    }
    .button4:hover {
        background-color:#eb675e;
    }
    .button4:active {
        position:relative;
        top:1px;
    }
    </style>

</head>

<body>
    <table width="1200" height="" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top">
                <table width="100%" height="600" border="0" cellpadding="0" cellspacing="0" style=";">
                    <tr>
                        <td height="40" colspan="2" valign="top">
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="top_logo">
                                <tr>
                                    <td width="26%" class="top_bg">
                                        <asp:ImageButton ID="BMS51_ID" ImageUrl="~/IMAGES/top_01.gif" runat="server" onclick="BMS51_ID_Click" />
                                        <img src="images/CEC_top_01.gif" width="311" height="40" /></td>
                                    <td width="23%" class="top_font">&nbsp;</td>
                                    <td width="24%" class="top_font" style="text-align:right">&nbsp;</td>
                                    <td width="27%" align="right"><a href="#"></a><img src="images/CEC_top_04.gif" width="356" height="40" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="200" height="552" class="left_tab" style="vertical-align:top; text-align:center;">
                            <asp:Button ID="Button1" runat="server" Text="＜" onclick="Button1_Click" Height="28" />
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_colr_table">
                                            <tr>
                                                <td width="6%" rowspan="2">
                                                    <asp:Image ID="Image1" ImageUrl="~/IMAGES/user.png" runat="server" />
                                                </td>
                                                <td width="63%" height="26">編號：1234567890</td>
                                                <td width="31%" rowspan="2">
                                                    <div align="center"><a href="index.htm"><img src="IMAGES/logout.gif" alt="登出" border="0" /></a></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>姓名：鄭裕傳</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" height="55" border="0">
                                <tr>
                                    <td class="td_03_top"><strong>工程專案</strong></td>
                                </tr>
                                <tr>
                                    <td class="td_03">
                                        <p>20150604A1 <br />
                                            新北市三重區<br />
                                            <br />
                                            大陸建設住宅<br />
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <!-- begin class menu -->
                            <div id="navcontainer">
                                <ul id="navlist" style="list-style-type:none;padding-left:0px">
                                    <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="index01.htm">專 案 建 立</a>
                                        <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="11" id="22" align="center">
                                            <ul id="subnavlist" style="list-style-type:none;padding-left:0px">
                                                <li><a class="SubMenu" href="#" target="_parent"></a></li>
                                                <li><a class="SubMenu" href="#" target="_parent"></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="index02.htm">工 程 填 報</a>
                                        <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="33" id="44" align="left">
                                            <ul id="subnavlist" style="list-style-type:none;padding-left:0px">
                                                <li><a class="SubMenu" href=" ../index05.htm" target="_top"></a></li>
                                                <li><a class="SubMenu" href="#" target="_top"></a> </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="index03.htm">工 程 分 析</a>
                                        <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="55" id="66" align="left">
                                            <ul id="subnavlist" style="list-style-type:none;padding-left:0px">
                                                <li><a class="SubMenu" href="#" target="_top"></a></li>
                                                <li><a class="SubMenu" href="#" target="_top"></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a style="background-repeat: no-repeat;background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="JavaScript:showOnOff('yes','7','8');">料 號 編 碼</a>
                                        <div name="submenu" class="SubMenu" style="display:none" root="yes" pid="7" id="8">
                                            <ul id="subnavlist2" style="list-style-type:none;padding-left:0px">
                                                <li><a class="SubMenu" href="index05.htm" target="_parent">工 項 範 圍</a></li>
                                                <li><a class="SubMenu" href="#" target="_parent">工 料 範 圍</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a style="background-repeat: no-repeat; background-image: url(images/r_btn_01.gif); background-position:center" class="MainMenu" href="index06.htm">系 統 維 護</a></li>
                                </ul>
                            </div>
                            <p>&nbsp;</p>
                            <p><br />
                            </p>
                            <div>
                                <ul id="navlist3" style="list-style-type:none;padding-left:0px">
                                    <li><span class="left_font">11月13日星期四</span>
                                        <br />
                                        <span class="left_font1">PM 3:37</span></li>
                                </ul>
                            </div>
                            <div><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image7','','images/service_1.png',1)"><img src="images/service.png" name="Image7" width="150" height="53" border="0" id="Image7" /></a></div>
                        </td>
                        <td width="1118" valign="top" class="top_colr">
                            <!-- InstanceBeginEditable name="EditRegion1" -->
                            <div style="width:100%; height:528px; overflow: auto;">
                                <table style="width:100%; height:348;" align="center" cellpadding="0" cellspacing="1" class="main_sbar">
                                    <tr>
                                        <td align="center">
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table1">
                                                <tr>
                                                    <td width="100%">
                                                        <table width="100%" align="center" cellpadding="1" cellspacing="0" class="top_tab">
                                                            <tr>
                                                                <td width="3%">&nbsp;</td>
                                                                <td width="90%"><strong>預算填報</strong></td>
                                                                <td width="7%">
                                                                    <div align="right">
                                                                        <strong>
                                                                            <img src="images/document_alt_fill_16x16.png" width="24" height="16" border="0" />&nbsp;
                                                                            <img src="images/trash-empty16x16.png" width="16" height="16" border="0" />&nbsp;
                                                                        </strong>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <?php require_once dirname(__FILE__) . '/p002.php'; ?>
                                            <!-- <iframe src="p002.php" name="list1" width="100%" height="352" id="list1" scrolling="Yes" frameborder="no" border="0 framespacing=" 0"></iframe> -->

                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bottom_table">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="1" cellspacing="0">
                                            <tr>
                                                <td width="77" bgcolor="#FFFFFF" class="bottom">
                                                    <div align="center">總計</div>
                                                </td>
                                                <td width="329" class="bottom">1,530,330.00</td>
                                                <td width="48" class="bottom">&nbsp;</td>
                                                <td width="50" class="bottom">&nbsp;</td>
                                                <td width="49" class="bottom">　 </td>
                                                <td width="84" class="bottom">&nbsp;</td>
                                                <td width="84" class="bottom">&nbsp;</td>
                                                <td width="75" class="bottom">&nbsp;</td>
                                                <td width="113" class="bottom">&nbsp;</td>
                                                <td width="76" class="bottom">&nbsp;</td>
                                                <td width="52" class="bottom">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!-- InstanceEndEditable -->
                            <!-- InstanceBeginEditable name="EditRegion2" -->
                            <?php require_once dirname(__FILE__) . '/edit001.php'; ?>
                            <!-- InstanceEndEditable -->                            
                        </td>
                    </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td bgcolor="#303f5e" class="bottom1">&nbsp;達義資訊整合有限公司<strong> reach right Information Co.,Ltd.</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="Scripts/switchmenu.js" type="text/javascript"></script>
    <script src="Scripts/script.js" type="text/javascript"></script>
    <script>
        var tr_bg_color = '';
        $(document).ready(function() {
            // $('.btn').toggleClass("click");
            // $('.sidebar').toggleClass("show");

            // $('.feat').css("display", "none");
            $('.feat').show();
            $('.feat-btn').text(' - ')

            tr_bg_color = $('.btn-title').parent('tr').find('td').css('background-color');
            console.log(tr_bg_color)
        })

        // $('.btn').click(function() {
        //   $(this).toggleClass("click");
        //   $('.sidebar').toggleClass("show");
        // });

        $('.feat-btn').click(function() {
            $(this).text(' - ')

            var sn = $(this).data('sn');
            var el = $('.feat-show' + sn);

            /* ul元件顯示或隱藏 */
            if (el.css("display") == 'none') {
                // el.css("display", "block");
                el.show();
                el.find('.feat-btn').text(' - ')
                $(this).text(' - ')
            } else {
                // el.css("display", "none");
                el.hide();
                el.find('.feat-btn').text(' + ')
                $(this).text(' + ')

            }
            // $('.first' + sn).toggleClass("rotate");
        });

        $('.btn-title').click(function() {
            var id = $(this).data('id');

            $('.btn-title').parent('tr').find('td:not(.list1)').css('background-color', tr_bg_color)
            $(this).parent('tr').find('td:not(.list1)').css('background-color', '#eeeeee')

            $('#router').val('update')
            $('#id').val(id)
            $('.form1_title').text('編輯項次')
            $(".button3").attr('disabled', false)

            $('.class_tree').parent('tr').hide();
            //
            $.ajax({
                headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                url: 'ajax/api_crud.php',
                type: "POST",
                data: {'router': 'get', 'table': 'class', 'key': 'id', 'value': id },
                cache: false,
                resetForm: true,
                success: function(rtndata) {
                    rtndata = JSON.parse(rtndata);
                    if (rtndata.status > 0) {
                        var datas = rtndata.data;
                        for (key in datas) {
                            $('#title').val(datas[key].title);
                            $('#unit').val(datas[key].unit);
                            $('#ratio').val(datas[key].ratio);
                            $('#quantity').val(datas[key].quantity);
                            $('#price').val(datas[key].price);
                            $('#remark').val(datas[key].remark);

                            $('#floor').val(datas[key].class);
                        }
                    } else {
                        console.log(JSON.stringify(rtndata));
                    }
                }
            });
        });
        
        $(".button3").click(function() {
            var id = $(this).data('id');

            $('#router').val('create')
            $('#id').val(id)
            $('.form1_title').text('新增項次')
            $(".button3").attr('disabled', false)
            $(this).attr('disabled', true);

            $('.class_tree').parent('tr').show();
            
            current_modal = $('#form_edit1');
            current_modal.find('input[type=text]').val('')
            //
            $.ajax({
                headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                url: 'ajax/get_class_tree.php',
                type: 'GET',
                data: {'router': 'get', 'table': 'class', 'key': 'id', 'value': id },
                cache: false,
                resetForm: true,
                success: function(rtndata) {
                    rtndata = JSON.parse(rtndata);
                    if (rtndata.status > 0) {
                        $('.class_tree').text(rtndata.data);
                        $('#floor').val( rtndata.floor);
                    } else {
                        console.log(JSON.stringify(rtndata));
                    }
                }
            });
        });
        
        $(".button4").click(function() {
            var msg = "您真的確定要刪除嗎？"; 
            if (confirm(msg)!=true){ 
                return false; 
            } 
            var id = $(this).data('id');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                url: 'ajax/api_edit001.php',
                type: 'GET',
                data: {'router': 'delete', 'table': 'class', 'key': 'id', 'value': id },
                cache: false,
                resetForm: false,
                success: function(rtndata) {
                    rtndata = JSON.parse(rtndata);
                    if (rtndata.status > 0) {
                        // alert(rtndata.message)

                        window.location.reload();
                    } else {
                        console.log(JSON.stringify(rtndata));
                    }
                }
            });
        });

        // $('nav ul li').click(function() {
        //   $(this).addClass("active").siblings().removeClass("active");
        // });

        $("#btn-search1").click(function() {
            current_modal = $('#form_edit1');
            //
            var data = {
                "_token": "<?php echo csrf_token() ?>"
            };
            data.router = 'get';
            data.table = 'materials';
            data.key = 'no';
            data.value = current_modal.find("#material_no").val(); //料號編碼
            data.title = 'hello world';
            //
            $.ajax({
                url: 'ajax/api_crud.php',
                type: "POST",
                data: data,
                cache: false,
                resetForm: true,
                success: function(rtndata) {
                    rtndata = JSON.parse(rtndata);
                    if (rtndata.status > 0) {

                        var datas = rtndata.data;
                        for (key in datas) {
                            console.log(datas[key].no);
                        }

                    } else {
                        console.log(JSON.stringify(rtndata));

                        // setTimeout(function () {
                        //     location.href = data.redirectUrl
                        // }, 500)
                        // toastr.error(data.message, "{{trans('web_alert.notice')}}").css("width","360px")
                        // Swal.fire("{{trans('web_alert.error')}}", JSON.stringify(data.errors), "error");
                    }
                }
            });
        });

        $("#button1").click(function() {
            current_modal = $('#form_edit1');
            //
            var data = { "_token": "<?php echo csrf_token() ?>" };
            data.router = current_modal.find("#router").val();
            data.table = 'class';
            data.key = 'id';
            data.value = current_modal.find('#id').val()
            data.class = current_modal.find('#floor').val(); 
            data.title = current_modal.find("#title").val(); 
            data.unit = current_modal.find("#unit").val(); 
            data.quantity = current_modal.find("#quantity").val(); //項目說明
            data.price = current_modal.find("#price").val(); //項目說明
            //
            console.log(data);

            $.ajax({
                headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                url: 'ajax/api_edit001.php',
                type: 'POST',
                data: data,
                cache: false,
                resetForm: true,
                success: function(rtndata) {
                    console.log(rtndata);

                    window.location.reload();

                    // setTimeout(function () {
                    //     location.href = data.redirectUrl
                    // }, 500)
                    // toastr.error(data.message, "{{trans('web_alert.notice')}}").css("width","360px")
                    // Swal.fire("{{trans('web_alert.error')}}", JSON.stringify(data.errors), "error");
                }
            });
        });
    </script>

</body>

</html>