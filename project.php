<?php
include_once dirname(__FILE__) . '/config.php';

$tablename = 'projects';
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
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
              <!-- InstanceBeginEditable name="EditRegion1" -->
              <table width="100%" height="348" align="center" cellpadding="0" cellspacing="1" class="main_sbar">
                <tr>
                  <td align="center">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table1">
                      <tr>
                        <td width="100%">
                          <table width="100%" align="center" cellpadding="1" cellspacing="0" class="top_tab">
                            <tr>
                              <td width="3%">&nbsp;</td>
                              <td width="90%">專案選擇</td>
                              <td width="7%">
                                <div align="right">&nbsp;</span></div>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="data_table">
                        </table>
                      </div>
                    </div>

                  </td>
                </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="15">
                    <!-- <form id="form1" name="form1" method="post" action="index03_1.htm">
                      <div align="center">
                        <input type="submit" name="button4" id="button4" value="選擇" />
                        <input type="reset" name="清除" id="清除" value="取消" />
                      </div>
                    </form> -->
                  </td>
                </tr>
              </table>
              <!-- InstanceEndEditable -->
              <!-- InstanceBeginEditable name="EditRegion2" -->
              <?php require_once dirname(__FILE__) . '/layouts/edit003.php'; ?>
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
  <script>
    $(document).ready(function() {
      tablename = 'projects';

      // $('#dataTable').DataTable();
      let table = $('#data_table').dataTable({
        "bServerSide": true,
        // "stateSave": true,
        "scrollX": true,
        "scrollY": '40vh',
        'bProcessing': true,
        "searching": true, //搜尋功能, 預設是開啟
        "paging": true, //分頁功能, 預設是開啟
        "ordering": true, //排序功能, 預設是開啟
        "pageLength": 10,
        "lengthMenu": [5, 10, 20, 50],
        "order": [
          [1, "asc"]
        ],
        "autoWidth": true,
        "dom": `<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-10'f>>
              <'row'<'col-sm-12'tr>>
              <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>`,
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
        // 'sServerMethod': 'GET',
        // "sAjaxSource": 'ajax/api_datatable.php',
        "ajax": {
          "headers": {
            'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
          },
          "url": "ajax/api_datatable.php", //要抓哪個地方的資料
          "type": "GET", //使用什麼方式抓
          "data": {
            'router': 'get',
            'table': tablename,
            // 'key': 'id',
            // 'value': id
          },
          "dataSrc": 'data',
          "dataType": 'json', //回傳資料的類型
          // "success": function() {
          //   console.log("你是右邊!!")
          // }, //成功取得回傳時的事件
          "error": function(XMLHttpRequest, textStatus, errorThrown) {
            // 通常情況下textStatus和errorThown只有其中一個有值 
            // console.log(XMLHttpRequest)
            console.error('(' + XMLHttpRequest.status + ') ' + XMLHttpRequest.responseText + ' ;' + textStatus)
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
          },
          {
            "sTitle": "Rank",
            "mData": "rank",
            "sName": "rank",
            "bSearchable": false,
            "width": "5%",
            "mRender": function(data, type, row) {
              let btn = '';
              btn += '<div class="txt txtRank" >' + data + '</div>';
              btn += '<input class="ipt iptRank" name="rank" size="1" type="text" value="' + data + '"></input>';
              return btn;
            }
          },
          {
            "title": "工程編號",
            "data": "ECode1",
            "width": "15%",
            "bSortable": true,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "工程名稱",
            "data": "Name",
            "bSortable": false,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "工程區域",
            "data": "area",
            "bSortable": false,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "sTitle": "建立時間",
            "mData": "created_at",
            "width": "15%",
            "bSortable": false,
            "bSearchable": false,
            "mRender": function(data = 0, type, row, meta) {
              // return data ? data.substr(0, 4) + '/' + data.substr(5, 2) + '/' + data.substr(8, 2) : '';
              return data;
            }
          },
          {
            "sTitle": '<input type="button" name="btn-add" class="btn-add" value="新增" data-id="0" />',
            "bSortable": false,
            "bSearchable": false,
            "width": "12%",
            "mRender": function(data, type, row) {
              // current_data[row.iId] = row;
              let btn = '';
              btn += '<input type="button" name="btn-edit" class="btn-edit" value="修改" data-id="' + row.id + '" />';
              btn += '<input type="button" name="btn-rm" class="btn-rm" value="刪除" data-id="' + row.id + '" />';
              return btn;
            }
          },
        ],
      });
      $.fn.dataTable.ext.errMode = 'throw';


      //點擊即編輯
      table.on('click', '.txt', function() {
        $('.txt').show()
        $(this).hide()
        $('.ipt').hide()
        $(this).siblings('.ipt').show()
      })

      //為了消除編輯模式
      table.mouseleave(function() {
        $('.txt').show()
        $('.ipt').hide()
      })

      //異動即更新
      table.on('change', '.ipt', function() {
        let n = $(this).prop('name') || ''
        if (n == 'undefined' || n == '') {
          return null
        }
        let id = $(this).closest('tr').find('td').first().text();
        let v = $(this).val() || 0
        let data = []
        data[n] = v
        ajax_crud('ajax/api_crud.php', 'update', tablename, 'id', id, data)
      });

      //新增
      $(".btn-add").click(function() {
        let id = $(this).data('id') || '';

        $('#router').val('create')
        $('#id').val(id)
        $('.form1_title').text('新增項次')

        let current_modal = $('#form_edit1')
        current_modal.find('input[type=text]').val('')
      });

      //修改
      table.on('click', '.btn-edit', function() {
        //let id = $(this).closest('tr').attr('id');
        let id = $(this).closest('tr').find('td').first().text() || 0;

        $('#router').val('update')
        $('#id').val(id)
        $('.form1_title').text('編輯內容')
        //
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"
          },
          url: 'ajax/api_crud.php',
          type: "POST",
          data: {
            'router': 'get',
            'table': tablename,
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
                $('#Code1').val(datas[key].Code1)
                $('#Name').val(datas[key].Name)

                if (datas[key].active == 1) {
                  $('.active[value="1"]').prop('checked', true)
                } else {
                  $('.active[value="0"]').prop('checked', true)
                }

                $('.optStatus').find('option[value="' + datas[key].status + '"]').prop('selected', true)
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
      table.on('click', '.btn-rm', function() {
        let msg = "您真的確定要刪除嗎？"
        if (confirm(msg) != true) {
          return false
        }
        let id = $(this).data('id') || 0
        let data = []
        data['status'] = 0
        ajax_crud('ajax/api_crud.php', 'delete', tablename, 'id', id, data)
      });

      //表單送出
      $("#btn-submit").click(function() {
        let current_modal = $('#form_edit1')
        let r = current_modal.find('#router').val() || ''
        let v = current_modal.find('#id').val() || 0
        console.log(r + ':' + v)
        if (r == '') return false;

        let datas = current_modal.serializeArray()
        let newdata = {}
        datas.forEach(function(data, key) {
          newdata[data['name']] = data['value'];
        });

        ajax_crud('ajax/api_crud.php', r, tablename, 'id', v, newdata)
      });

    });
  </script>


</body>
<!-- InstanceEnd -->

</html>