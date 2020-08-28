<?php
  require_once 'sys/db.php';

  echo (isset($db))? 'y': 'n';
  $rs = $db->prepare("SELECT * FROM class");
  $rs->execute();
  $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
  // foreach($rows as $row){
  //   echo $row['class'];
  //   echo ' ';
  //   echo $row['title'];
  //   echo '<br>';
  // }
  // echo 'hello world';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Basic SideMenu - jQuery EasyUI Demo</title>
	<link rel="stylesheet" type="text/css" href="resources/jquery-easyui-1.9.7/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="resources/jquery-easyui-1.9.7/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="resources/jquery-easyui-1.9.7/demo/demo.css">
	<script type="text/javascript" src="resources/jquery-easyui-1.9.7/jquery.min.js"></script>
	<script type="text/javascript" src="resources/jquery-easyui-1.9.7/jquery.easyui.min.js"></script>
</head>
<body>
	<h2>Basic SideMenu</h2>
	<p>Collapse the side menu to display the main icon.</p>
	<!-- <div style="margin:20px 0;"> -->
		<!-- <a href="javascript:;" class="easyui-linkbutton" onclick="toggle()">Toggle</a> -->
	<!-- </div> -->
	<div id="sm" class="easyui-sidemenu" data-options="data:data"></div>
	<script type="text/javascript">
		var data = [{
	        text: 'Item1',
	        // iconCls: 'icon-sum',
	        // state: 'open',
	        children: [{
	            text: 'Option1'
	        },{
	            text: 'Option2'
	        },{
	            text: 'Option3',
	            children: [{
	                text: 'Option31'
	            },{
	                text: 'Option32'
	            }]
	        }]
	    },{
	        text: 'Item2',
	        // iconCls: 'icon-more',
	        children: [{
	            text: 'Option4'
	        },{
	            text: 'Option5'
	        },{
	            text: 'Option6'
	        }]
	    }];

		function toggle(){
			var opts = $('#sm').sidemenu('options');
			$('#sm').sidemenu(opts.collapsed ? 'expand' : 'collapse');
			opts = $('#sm').sidemenu('options');
			$('#sm').sidemenu('resize', {
				width: opts.collapsed ? 60 : 200
			})
		}
	</script>
</body>
</html>