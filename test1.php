<?php
include_once dirname(__FILE__) . '/config.php';

$tablename = 'class';
$queryStr = " AND open=1 ";
$orderStr = " ORDER BY rank ASC ";
$rs = $db->prepare("SELECT * FROM {$tablename} WHERE class=1 ". $queryStr. $orderStr);
$rs->execute();
$rows = $rs->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="tw" dir="ltr">

<head>
    <title>建築工料分析系統</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="css/menu.css" rel="stylesheet" type="text/css" />
    <link href="css/tree.css" rel="stylesheet" type="text/css" />
    <link href="css/first.css" rel="stylesheet" type="text/css" />
    <link href="css/test1.css" rel="stylesheet" type="text/css" />
    <link href="css/master.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    </style>

</head>

<body>
    <table width="1200" height="" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top">
                <table width="100%" height="600" border="0" cellpadding="0" cellspacing="0" >
                    <tr>
                        <?php require_once dirname(__FILE__) . '/layouts/top.php'; ?>
                    </tr>
                    <tr>
                        <?php require_once dirname(__FILE__) . '/layouts/menu.php'; ?>

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

                                            <?php require_once dirname(__FILE__) . '/layouts/p002.php'; ?>
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
                            <?php require_once dirname(__FILE__) . '/layouts/edit002.php'; ?>
                            <!-- InstanceEndEditable -->
                        </td>
                    </tr>
                </table>
                <?php require_once dirname(__FILE__) . '/layouts/bottom.php'; ?>
            </td>
        </tr>
    </table>
    

    <?php require_once dirname(__FILE__).'/layouts/script.php'; ?>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="Scripts/test1.js" type="text/javascript" defer ></script>
    <script>
        // $(document).ready(function() {
        document.addEventListener("DOMContentLoaded", function() {
            var params = {}
            var show_id = ''
            var classStr = ''
            var classArr = []

            $('.feat').hide();
            $('.more-btn').text(' + ')

            //直接顯示修改中資料
            params = getSearchParameters();
            show_id = atob( params.show || null )
            classStr = $(".btn-title[data-id="+show_id+"]").closest('tr').prop('className') || ''
            classArr = classStr.split(' ')        
            //循環找有階層關係才顯示    
            $.each(classArr, function(i, item) { 
                if( item.indexOf("feat-show") != -1 ) {
                     $("[class~='"+item+"']").show()
                     $("[class~='"+item+"']").find('.more-btn').text(' - ')
                }
            })    

            //被選取效果(非Jquery寫法)
            // var threads = document.querySelectorAll('.feat')
            // threads.forEach( function(thread, i) {
            //     thread.addEventListener('click', function() {
            //         $('.btn-title').parent('tr').find('td:not(.list1)').removeClass('td_point')
            //         $(this).find('td:not(.list1)').addClass('td_point')
            //     });
            // })
            //被選取效果(Jquery寫法)
            $('.feat').click(function() {
                $('.btn-title').parent('tr').find('td:not(.list1)').removeClass('td_point')
                $(this).find('td:not(.list1)').addClass('td_point')
            })

            //+功能-
            $('.more-btn').click(function() {
                let my = $(this)
                let sn = my.data('sn')
                let tr = $('.feat-show' + sn)

                my.text(' - ')

                /* ul元件顯示或隱藏 */
                if (tr.css("display") == 'none') {
                    tr.each( function(i, item) {
                        let tr = $(this)
                        if (tr.data('f') == my.data('f')) {
                            tr.show()
                        }
                    });
                } else {
                    tr.hide()
                    tr.find('.more-btn').text(' + ')
                    my.text(' + ')
                }
            });

            //切換新增功能
            $(".btn-add").click(function() {
                var id = $(this).data('id') || ''

                $('#router').val('create')
                $('#id').val(id)
                $('.form1_title').text('新增項次')
                $(".btn-add").attr('disabled', false)
                $(this).attr('disabled', true)
                $('.class_tree').parent('tr').show()

                var current_modal = $('#form_edit1')
                current_modal.find('input[type=text]').val('')
                //
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                    url: 'ajax/get_class_tree.php',
                    type: 'POST',
                    data: {
                        'router': 'get',
                        'table': 'class',
                        'key': 'id',
                        'value': id
                    },
                    cache: false,
                    resetForm: true,
                    success: function(rtndata) {
                        rtndata = JSON.parse(rtndata)
                        if (rtndata.status > 0) {
                            $('.class_tree').text(rtndata.data)
                            $('#floor').val(rtndata.floor)
                        } else {
                            console.log(JSON.stringify(rtndata))
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // 通常情況下textStatus和errorThown只有其中一個有值 
                        console.error('status:'+XMLHttpRequest.status+';rs:'+XMLHttpRequest.readyState+';ts:'+textStatus)
                    }
                });
            });

            //切換修改功能
            $('.btn-title').closest('tr').find('td:not(.opera)').click(function() {
                var id = $(this).closest('tr').find('.btn-title').data('id') || ''  
                var floor = $(this).closest('tr').data('f') || '' 
                //
                $('#router').val('update')
                $('#id').val(id)
                $('.form1_title').text('編輯項次')
                $(".btn-add").attr('disabled', false)
                $('.class_tree').parent('tr').hide()
                if(floor!=4) {
                    $('#unit , #ratio ,#quantity ,#price ,#reprice, #nomore').closest('td').hide()
                } else {
                    $('#unit , #ratio ,#quantity ,#price ,#reprice, #nomore').closest('td').show()
                }
                //
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>" },
                    url: 'ajax/api_crud.php',
                    type: "POST",
                    data: {
                        'router': 'get',
                        'table': 'class',
                        'key': 'id',
                        'value': id
                    },
                    cache: false,
                    resetForm: true,
                    success: function(rtndata) {
                        rtndata = JSON.parse(rtndata)
                        if (rtndata.status > 0) {
                            var datas = rtndata.data
                            for (key in datas) {
                                $('#rank').val(datas[key].rank)
                                $('#title').val(datas[key].title)
                                $('#unit').val(datas[key].unit)
                                $('#ratio').val(datas[key].ratio)
                                $('#quantity').val(datas[key].quantity)
                                $('#price').val(datas[key].price)
                                $('#reprice').val(datas[key].reprice)
                                $('#remark').val(datas[key].remark)

                                $('#floor').val(datas[key].class)
                            }
                        } else {
                            console.log(JSON.stringify(rtndata))
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // 通常情況下textStatus和errorThown只有其中一個有值 
                        console.error('status:'+XMLHttpRequest.status+';rs:'+XMLHttpRequest.readyState+';ts:'+textStatus)
                    }
                });
            });

            //刪除項目
            $(".btn-rm").click(function() {
                let msg = "您真的確定要刪除嗎？"
                if (confirm(msg) != true) {
                    return false
                }
                let id = $(this).data('id') || ''
                ajax_crud('ajax/api_edit001.php', 'delete', 'class', 'id', id)
            });

            //表單送出
            $("#btn-submit").click(function() {
                var current_modal = $('#form_edit1')
                //
                var data = {
                    "_token": "<?php echo csrf_token() ?>"
                }
                data.class = current_modal.find('#floor').val()
                data.rank = current_modal.find('#rank').val()
                data.title = current_modal.find("#title").val()
                data.unit = current_modal.find("#unit").val()
                data.ratio = current_modal.find("#ratio").val()
                data.quantity = current_modal.find("#quantity").val() 
                data.price = current_modal.find("#price").val() 
                data.reprice = current_modal.find("#reprice").val() 
                //
                r = current_modal.find("#router").val()
                v = current_modal.find('#id').val()
                ajax_crud('ajax/api_edit001.php', r, 'class', 'id', v, data)
            });

            //點擊即編輯
            $('.txt').click(function(){
                $('.txt').show()
                $(this).hide()
                $('.ipt').hide()
                $(this).siblings('.ipt').show()
            })

            //為了消除編輯模式
            $('.top_table1').mouseleave(function(){
                $('.txt').show()
                $('.ipt').hide()
            })

            //異動即更新
            $('.ipt').on('change', function () {     
                var n = $(this).prop('name') || ''
                if(n=='undefined' || n=='') {
                    return null
                }
                var id = $(this).closest('tr').find('.btn-title').data('id') || ''      
                var v = $(this).val() || 0   
                var data = []
                data[n] = v
                ajax_crud('ajax/api_edit001.php', 'update', 'class', 'id', id, data)
            });
        })

    </script>
</body>

</html>