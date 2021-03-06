<?php
include_once dirname(__FILE__) . '/config.php';

$tablename = 'projects';
$queryStr = " AND status=1 ";
$orderStr = " ORDER BY rank ASC ";
$rs = $db->prepare("SELECT * FROM {$tablename} WHERE 1 " . $queryStr . $orderStr);
$rs->execute();
$rows = $rs->fetchAll(PDO::FETCH_ASSOC);
$row = $rows[0];
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

  <?php require_once dirname(__FILE__) . '/layouts/style.php'; ?>
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
  <link href="vendor/datatables/DataTables-1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style type="text/css">
    .card-body {
      padding: 5px;
    }

    td.list {
      width: 2%;
    }

    td.list2 {
      width: 7%;
    }

    td.list4 {
      width: 7%;
    }

    .td_title {
      text-align: right;
    }
  </style>
</head>

<body>
  <table width="1260" height="" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top">
        <table width="100%" height="640" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <?php require_once dirname(__FILE__) . '/layouts/top.php'; ?>
          </tr>

          <tr>
            <?php require_once dirname(__FILE__) . '/layouts/menu.php'; ?>

            <td width="100%" valign="top" class="top_colr">
              <!-- InstanceBeginEditable name="EditRegion1" -->
              <table width="100%" height="480" align="center" cellpadding="0" cellspacing="1" class="main_sbar">
                <tr>
                  <td align="center">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table1">
                      <tr>
                        <td width="100%">
                          <table width="100%" align="center" cellpadding="1" cellspacing="0" class="top_tab">
                            <tr>
                              <td width="5%">
                                <div align="left">

                                  <input type="button" class="btn-goto1 btn-add" value="新增" data-id="0" data-url="" />

                                </div>
                              </td>
                              <td width="60%">專案選擇</td>
                              <td width="35%">
                                <div align="right">

                                  <input type="button" class="btn-show" value="內容" data-url="" />
                                  <input type="button" class="btn-edit" value="修改" data-url="" />
                                  <input type="button" class="btn-rm" value="刪除" data-id="" />

                                </div>
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
      var table = $('#data_table').dataTable({
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
            "bSortable": true,
            "bSearchable": false,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          // {
          //   "sTitle": "Rank",
          //   "mData": "rank",
          //   "sName": "rank",
          //   "bSearchable": false,
          //   "width": "5%",
          //   "mRender": function(data, type, row) {
          //     let btn = '';
          //     btn += '<div class="txt txtRank" >' + data + '</div>';
          //     btn += '<input class="ipt iptRank" name="rank" size="1" type="text" value="' + data + '"></input>';
          //     return btn;
          //   }
          // },
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
            "title": "縣市",
            "data": "area",
            "bSortable": false,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "區域地號",
            "data": "Location",
            "bSortable": false,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "建物用途",
            "data": "Building_use",
            "bSortable": false,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "結構形式",
            "data": "Structure2",
            "bSortable": false,
            "bSearchable": true,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "基地面積",
            "data": "Base_area",
            "bSortable": true,
            "bSearchable": false,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "title": "樓板面積",
            "data": "total_floor_area",
            "bSortable": true,
            "bSearchable": false,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          {
            "sTitle": "建檔日期",
            "mData": "created_at",
            // "width": "15%",
            "bSortable": true,
            "bSearchable": true,
            "mRender": function(data = 0, type, row, meta) {
              return data ? data.substr(0, 4) + '/' + data.substr(5, 2) + '/' + data.substr(8, 2) : '';
              // return data;
            }
          },
          {
            "sTitle": "鎖定",
            "mData": "Lock",
            "bSortable": false,
            "bSearchable": false,
            "render": function(data, type, row, meta) {
              return data;
            }
          },
          // {
          //   "sTitle": '<input type="button" name="btn-add" class="btn-add" value="新增" data-id="0" />',
          //   "bSortable": false,
          //   "bSearchable": false,
          //   "width": "12%",
          //   "mRender": function(data, type, row) {
          //     // current_data[row.iId] = row;
          //     let btn = '';
          //     btn += '<input type="button" name="btn-edit" class="btn-edit" value="修改" data-id="' + row.id + '" />';
          //     btn += '<input type="button" name="btn-rm" class="btn-rm" value="刪除" data-id="' + row.id + '" />';
          //     return btn;
          //   }
          // },
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


      $('.btn-edit, .btn-show, .btn-rm').prop('disabled', true)
      //修改
      table.on('click', 'td', function() {
        //被選取效果(Jquery寫法)
        table.find('td:not(.list1)').removeClass('td_point')
        $(this).parent('tr').find('td:not(.list1)').addClass('td_point')

        //let id = $(this).closest('tr').attr('id');
        let id = $(this).closest('tr').find('td').first().text() || 0;
        let go = encodeURIComponent(location.href);

        // $('.btn-edit').data('url', 'modify.php?u=' + id + '&go=' + go + '');
        $('.btn-edit, .btn-show, .btn-rm').data('id', id);
        $('.btn-edit, .btn-show, .btn-rm').prop('disabled', false)

        $('#router').val('update')
        $('#id').val(id)
        $('#table').val(tablename)
        $('.form1_title').text('編輯內容')
        //
        $.ajax({
          headers: {'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"},
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
                for (col in datas[key]) {
                  $("[name~='" + col + "']").val(datas[key][col])
                }
                // $('.optStatus').find('option[value="' + datas[key].status + '"]').prop('selected', true)
                if (datas[key].Photo1_5) {
                  $('#blah').attr('src', 'storage/' + tablename + '/img/' + datas[key].Photo1_5);
                } else {
                  $('#blah').attr('src', 'images/246x0w.png');
                }
                if (datas[key].Pdf1_3) {
                  $('#blah2').text(datas[key].Pdf1_3).prop('href', 'storage/' + tablename + '/file/' + datas[key].Pdf1_3);
                } else {
                  $('#blah2').hide()
                }
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
      }).on('dblclick', 'td', function() {
        $('.btn-show').click()
      });

      $(".btn-add").click(function() {
        $(".main_sbar").hide();
        $('#form_edit1').slideDown();

        $('#router').val('create')
        $('.form1_title').text('新增項次')
        $('.btn-clear').click(); //清空輸入欄位
        $('#table').val(tablename)
        $('#blah').attr('src', 'images/246x0w.png');
      });
      $('.btn-edit').click(function() {
        $(".main_sbar").hide();
        $('#form_edit1').slideDown();
        $('#form_edit1 input,select').prop('disabled', false);
        $('.btn-submit, .btn-clear, .btn-cancel').show()
      });
      $('.btn-show').click(function() {
        $(".main_sbar").hide();
        $('#form_edit1').slideDown();
        $('.form1_title').text('顯示內容')
        $('#form_edit1 input,select').prop('disabled', true);
        $('.btn-submit, .btn-clear, .btn-cancel').hide()
      });
      $('.doCloseModal').click(function() {
        $('.main_sbar').slideDown();
        $('#form_edit1').hide();
        table.DataTable().ajax.reload();
        $('.btn-edit, .btn-show').prop('disabled', true)
      });
      $('.main_sbar').slideDown();
      $('#form_edit1').hide();

      //刪除項目
      $(".btn-rm").on('click', function() {
        let id = $(this).data('id') || 0
        let msg = "您真的確定要刪除嗎？"
        if (id == 0 /*|| confirm(msg) != true*/ ) {
          return false
        }
        let data = []
        data['status'] = 0
        swal({
          title: msg,
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "確定删除",
          cancelButtonText: "取消",
          closeOnConfirm: false,
          // closeOnCancel: false,
          // imageUrl: "images/thumbs-up.jpg",  //自定義圖
          // html: true, //自定义<span style="color:#F8BB86">html<span>信息。
          // animation: "slide-from-top",
        }, function() {
          ajax_crud('ajax/api_crud.php', 'delete', tablename, 'id', id, data)
        });
      });

      //表單送出
      $('form').on('submit', function(e) {
        e.preventDefault();

        var form = $('form')[0];
        var formData = new FormData(form);
        $.ajax({
          headers: { 'X-CSRF-TOKEN': "<?php echo csrf_token() ?>"},
          url: "ajax/api_project.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          cache: false,
          resetForm: true,
          success: function(rtndata) {
            rtndata = JSON.parse(rtndata)
            if (rtndata.status > 0) {
              $('.main_sbar').slideDown();
              $('#form_edit1').hide();
              table.DataTable().ajax.reload();
              $('.btn-edit, .btn-show, .btn-rm').prop('disabled', true)
              swal({
                title: ''+rtndata.message,
                timer: 1000,
                showConfirmButton: false,
                type: "success",
                html: true, //自定义<span style="color:#F8BB86">html<span>信息。
              });
            } else {
              swal({
                title: rtndata.message,
                timer: 1000,
                showConfirmButton: false,
                type: "error",
              });
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            // 通常情況下textStatus和errorThown只有其中一個有值 
            console.error('status:' + XMLHttpRequest.status + ';rs:' + XMLHttpRequest.readyState + ';ts:' + textStatus)
          }
        });
      });

      //用JavaScript抓取Enter事件並按下按鈕
      $("#form_edit1").keypress(function(e) {
        let key = window.event ? e.keyCode : e.which
        if (key == 13) $('.btn-submit').click()
      });
      document.onkeydown = function(e) {
        let key = e.key || window.event
        if (key === "Escape" || key === "Esc" || key.keyCode === 27) {
          table.find('td').removeClass('td_point')
          $('.btn-edit, .btn-show, .btn-rm').prop('disabled', true)
        }
      };
    });
  </script>
</body>
<!-- InstanceEnd -->

</html>