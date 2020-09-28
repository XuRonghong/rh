<?php
include_once dirname(__FILE__) . '/config.php';

$tablename = 'accounts';
// $queryStr = " AND status=1 ";
$orderStr = " ORDER BY rank ASC ";
$rs = $db->prepare("SELECT * FROM {$tablename} WHERE 1 " . $orderStr);
$rs->execute();
$rows = $rs->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="tw" dir="ltr">

<head id="Head1" runat="server">
  <title>建築工料分析系統</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="css/menu.css" rel="stylesheet" type="text/css" />
  <link href="css/tree.css" rel="stylesheet" type="text/css" />
  <link href="css/first.css" rel="stylesheet" type="text/css" />
  <link href="css/master.css" rel="stylesheet" type="text/css">

  <!-- Custom fonts for this template -->
  <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> --> -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->
  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style type="text/css">

  </style>
</head>

<body ">
  <table width=" 1200" height="" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
      <table width="100%" height="600" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <?php require_once dirname(__FILE__) . '/layouts/top.php'; ?>
        </tr>
        <tr>
          <?php require_once dirname(__FILE__) . '/layouts/menu.php'; ?>

          <td width="1118" valign="top" class="top_colr">
            <!-- InstanceBeginEditable name="EditRegion1" -->
            <table width="100%" align="center" cellpadding="0" cellspacing="1" class="main_sbar">
              <tr>
                <td height="276" align="right">
                  <table border="0" cellspacing="0" cellpadding="3" align="center" scrollbar-face-color:="scrollbar-face-color:" #b46868;>
                  </table>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table1">
                    <tr>
                      <td width="100%">
                        <table width="100%" align="center" cellpadding="1" cellspacing="0" class="top_tab">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="90%"><strong>帳號權限管理</strong></td>
                            <td width="7%">
                              <div align="right"><strong>&nbsp;<img src="images/document_alt_fill_16x16.png" width="24" height="16" border="0" />&nbsp;<img src="images/trash-empty16x16.png" width="16" height="16" border="0" />&nbsp;</strong></div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered" id="data_table" width="100%" cellspacing="0">
                      </table>
                    </div>
                  </div>

                </td>
              </tr>
            </table>
            <!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion2" -->
            <?php require_once dirname(__FILE__) . '/layouts/edit006.php'; ?>
            <!-- InstanceEndEditable -->
          </td>
        </tr>
      </table>
      <?php require_once dirname(__FILE__) . '/layouts/bottom.php'; ?>
    </td>
  </tr>
  </table>


  <?php require_once dirname(__FILE__) . '/layouts/script.php'; ?>

  <!-- Bootstrap core JavaScript-->
  <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="Scripts/sb-admin-2.min.js"></script>
  <!-- Page level plugins -->
  <!-- <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
  <script src="vendor/xtreme-admin/assets/extra-libs/DataTables/datatables.min.js"></script>
  <script src="vendor/xtreme-admin/dist/js/pages/datatable/datatable-basic.init.js"></script>

  <script src="Scripts/test1.js" type="text/javascript" defer></script>
  <script>
    $(document).ready(function() {

      // $('#dataTable').DataTable();
      var table = $('#data_table').dataTable({
        "bServerSide": true,
        // "stateSave": true,
        "scrollX": true,
        "scrollY": '40vh',
        'bProcessing': true,
        // 'sServerMethod': 'GET',
        // "sAjaxSource": 'ajax/api_datatable.php',
        "searching": true, //搜尋功能, 預設是開啟
        "paging": true, //分頁功能, 預設是開啟
        "ordering": true, //排序功能, 預設是開啟
        "pageLength": 10,
        "lengthMenu": [5, 10, 20, 50],
        "order": [
          [1, "desc"]
        ],
        "autoWidth": true,
        // "dom": `<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>
        //       <'row'<'col-sm-12'tr>>
        //       <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>`,
        // "oLanguage": {
        //   "sSearch": 'Search:<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        // },
        "language": {
          "processing": "處理中...",
          "loadingRecords": "載入中...",
          "lengthMenu": "顯示 _MENU_ 項結果",
          "zeroRecords": "沒有符合的結果",
          "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
          "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
          "infoFiltered": "(從 _MAX_ 項結果中過濾)",
          "infoPostFix": "",
          "search": "搜尋:",
          "paginate": {
            "first": "第一頁",
            "previous": "上一頁",
            "next": "下一頁",
            "last": "最後一頁"
          },
          "aria": {
            "sortAscending": ": 升冪排列",
            "sortDescending": ": 降冪排列"
          }
        },
        "ajax": {
          "headers": {
            'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
          },
          "url": "ajax/api_datatable.php", //要抓哪個地方的資料
          "type": "GET", //使用什麼方式抓
          "data": {
            'router': 'get',
            'table': 'accounts',
            // 'key': 'id',
            // 'value': id
          },
          "dataSrc": 'data',
          "dataType": 'json', //回傳資料的類型
          // "success": function() {
          //   console.log("你是右邊!!")
          // }, //成功取得回傳時的事件
          "error": function (XMLHttpRequest, textStatus, errorThrown) {
              // 通常情況下textStatus和errorThown只有其中一個有值 
              // console.log(XMLHttpRequest)
              console.error('('+XMLHttpRequest.status+') '+XMLHttpRequest.responseText+' ;'+textStatus)
          }
        },
        "columns": [{
            "title": "ID",
            "data": "id",
            "width": "5%",
            "bSortable": false,
            "bSearchable": false,
            "render": function(data, type, row, meta) {
              return data;
            }
          },{
            "title": "單位統編",
            "data": "Code1",
            "width": "15%",
            "bSortable": true,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "帳號",
            "data": "Account",
            "bSortable": false,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "使用人員",
            "data": "Name",
            "bSortable": false,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "系統權限",
            "data": "System",
            "bSortable": false,
            "bSearchable": false,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "專案權限",
            "data": "Project",
            "bSortable": false,
            "bSearchable": false,
            "render": function(data = 0, type, row, meta) {
              return data ? data : '';
            }
          },
          {
            "sTitle": "建立時間",
            "mData": "created_at",
            // "sName": "id",
            // "width": "40px",
            "bSortable": false,
            "bSearchable": false,
            "mRender": function(data = 0, type, row, meta) {
              return data ? data.substr(0, 4) + '/' + data.substr(5, 2) + '/' + data.substr(8, 2) : '';
            }
          },
        ],
      });
      $.fn.dataTable.ext.errMode = 'throw';


      //被選取效果(Jquery寫法)
      $('.feat').click(function() {
        $('.btn-title').parent('tr').find('td:not(.list1)').removeClass('td_point')
        $(this).find('td:not(.list1)').addClass('td_point')
      })


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
          headers: {
            'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
          },
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
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            // 通常情況下textStatus和errorThown只有其中一個有值 
            console.error('status:' + XMLHttpRequest.status + ';rs:' + XMLHttpRequest.readyState + ';ts:' + textStatus)
          }
        });
      });

      //切換修改功能
      $('.btn-title').closest('tr').find('td:not(.opera)').click(function() {
        var id = $(this).closest('tr').find('.btn-title').data('id') || ''
        var floor = $(this).closest('tr').data('f') || ''
        console.log(floor)
        //
        $('#router').val('update')
        $('#id').val(id)
        $('.form1_title').text('編輯項次')
        $(".btn-add").attr('disabled', false)
        $('.class_tree').parent('tr').hide()
        if (floor != 4) {
          $('#unit , #ratio ,#quantity ,#price ,#reprice, #nomore').closest('td').hide()
        } else {
          $('#unit , #ratio ,#quantity ,#price ,#reprice, #nomore').closest('td').show()
        }
        //
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
          },
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
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            // 通常情況下textStatus和errorThown只有其中一個有值 
            console.error('status:' + XMLHttpRequest.status + ';rs:' + XMLHttpRequest.readyState + ';ts:' + textStatus)
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
      $('.txt').click(function() {
        $('.txt').show()
        $(this).hide()
        $('.ipt').hide()
        $(this).siblings('.ipt').show()
      })

      //為了消除編輯模式
      $('.top_table1').mouseleave(function() {
        $('.txt').show()
        $('.ipt').hide()
      })

      //異動即更新
      $('.ipt').on('change', function() {
        var n = $(this).prop('name') || ''
        if (n == 'undefined' || n == '') {
          return null
        }
        var id = $(this).closest('tr').find('.btn-title').data('id') || ''
        var v = $(this).val() || 0
        var data = []
        data[n] = v
        ajax_crud('ajax/api_edit001.php', 'update', 'class', 'id', id, data)
      });
    })

    //非同步傳輸資料
    function ajax_crud(u, r, t, k, v, datas = []) {
      var data = {
        'router': r,
        'table': t,
        'key': k,
        'value': v
      }
      //假如還有資料就填充上去
      for (let key in datas) {
        // data.push({key : datas[key]})
        data[key] = datas[key]
      }
      var url = window.location.href
      url = url.split('?')[0] || ''
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
        },
        url: u,
        type: 'POST',
        data: data,
        cache: false,
        resetForm: true,
        success: function(rtndata) {
          rtndata = JSON.parse(rtndata)
          // console.log(rtndata)             
          location.href = url + '?show=' + rtndata.id

          // setTimeout(function () { location.href = data.redirectUrl }, 500)
          // toastr.error(data.message, "{{trans('web_alert.notice')}}").css("width","360px")
          // Swal.fire("{{trans('web_alert.error')}}", JSON.stringify(data.errors), "error");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // 通常情況下textStatus和errorThown只有其中一個有值 
          console.error('status:' + XMLHttpRequest.status + ';rs:' + XMLHttpRequest.readyState + ';ts:' + textStatus)
        }
      });
    }
  </script>

</body>

</html>