/*!
 * jQuery Input Plugin (with Agi)
 * Copyright (c) 2015
 * Version: 1.0.5 (2019-12-16)
 * Need jquery-1.10.1.min.js,jquery-ui.min.js
 *
 * 2018/8/31 inputtinymce
 * 2018/9/16 inputlist
 * 2018/9/16 inputtinymce add toolbar
 */

(function($){
	/*==========================
        Input Plugin Data API
        Update: 2017-11-5
    ==========================*/
    $.fn.inputapi=function(options){
        return this.each(function() {
            var $this=$(this);
            var api=$this.data('api');
            var set=$this.data('set');

            if(set==''||set==undefined){
            	set={}
            	for(var i in $.fn[api].defaults){
            		if($this.data(i)!=''&&$this.data(i)!=undefined){
            			set[i]=JSON.stringify($this.data(i));
            		}
            	}
            }
            if(api&&typeof($.fn[api]=='function')){
                $.fn[api].call($this,set);        
            }
        });
    };

	/*============================================
        Input Plugin Select Mix Text Or Select
        Update: 2016-3-30
    ============================================*/
	var methods={
	    init:function(options){
       		var o=$.extend({},$.fn.inputselectmulti.defaults,options);
       		
		    return this.each(function(){

		    	var $input=$(this);
	            var toolname=($input.attr('id')||$input.attr('class'))+'inputtool';
		    	var inputval=$input.val();

				// input value set
				if(o.format=='comma'){
					inputval=inputval.split(',');
				}else if(o.format=='json'){
					inputval=JSON.parse(inputval||'[]');
				}

				// init
				var $tool=$('<div class="'+toolname+'" style="'+o.toolcss+'"></div>');
				var $toolselect=$('<select class="'+toolname+'select"></select>');
				$input.after($tool.append($toolselect.append(o.toolfirst)));
				if(o.hidden){$input.css('display','none')} // hidden input
    			_loop($toolselect,o.data); // create 

				// select change
	            $tool.find("select").change(function(){
	            	var $this=$(this);
	            	var group=$this.attr('toolgroup')
	            	var key=$this.find('option:selected').val();
	            	$this.parent().find('.'+group).hide();
	            	if(key){
		            	$('#'+group+key).show();
	            	}
	            	_refresh();
	            })

				// input change
				$tool.find("input").change(function(){
	            	_refresh();
				})

				// input extend
				$.fn.extend({
		        	refresh:_refresh()
			    })

			    // create item
	    		function _loop($item,data,depth){
		    		var itemgroup='tool'+randMix(4);
		    		var remove=true;
		    		var depth=depth||0;
		    		$item.attr('toolgroup',itemgroup);
	    			for(var i in data){
		                $item.append($('<option value="'+i+'">'+data[i][o.text]+'</option>'));
		                if(data[i].data!=undefined){
			                var $tmp;
			                switch(typeof(data[i].data)){
			                	case 'string':
			                		$tmp=$('<input class="'+itemgroup+'" id="'+itemgroup+i+'" />');
			                		if(i==inputval[depth]){
				                		$tmp.val(JSON.stringify(inputval[depth+1]));
					        		}
			                		if(data[i].callback!=undefined){
			                			for(eventname in data[i].callback){
					                		$tmp.on(eventname,data[i].callback[eventname]);
					                		$tmp.on(eventname,_refresh);
			                			}
			                		}
				                break;
			                	case 'object':
			                		$tmp=$('<select class="'+itemgroup+'" id="'+itemgroup+i+'"></select>');
			                		_loop($tmp,data[i].data,depth);
				                break;
			                }
			                $item.after((i==inputval[depth])?$tmp.show():$tmp.hide());
			                remove=false;
						}
		            }
		            if(remove){
		            	$item.removeAttr('toolgroup');
		            }
		    		$item.children('option[value='+inputval[depth]+']').attr('selected','selected');
	    		}

    			// refresh input value
				function _refresh(){
		        	var $item=$toolselect;
					var arr=[];
					var err=true;

					while(err){
						var val=$item.val();
						arr.push((val.search('{')==0&&val.search('}')==val.length-1)?JSON.parse(val):val);
						group=$item.attr('toolgroup');
						if(group==undefined){
							err=false;
						}else{
							$item=$tool.children('#'+group+val);
							if($item.length<=0){
								err=false;
							}
						}
					}

					if(o.format=="comma"){
						$input.val(arr.join(","));
					}else if(o.format=="json"){
						$input.val(JSON.stringify(arr));
					}
					if(typeof(o.callback)=='function'){
                		o.callback.call();
        			}
				}
		    })
        }
	};

	$.fn.inputselectmulti=function(options){
        if ( methods[options] ) {
            return methods[ options ].apply( this, Array.prototype.slice.call( arguments, 1 )); 
        } else if ( typeof options === 'object' || ! options ) {
            return methods.init.apply( $(this), arguments);
        } else {
             $.error('Method '+options+' does not exist on InputPlugin.');
        }
    }

   	$.fn.inputselectmulti.defaults={
    	tool:"", // tool
        toolcss:'display:inline-block', // tool css
        toolfirst:'<option></option>',
        callback:'',
        hidden:true, // hidden
		format:"json", // comma,json
        data:'',
        text:'text'
	};

	/*===============================
	    Input Plugin Tinymce
	    Update: 2018-8-31
	===============================*/
	$.fn.inputtinymce=function(options){
		var o=$.extend({},$.fn.inputtinymce.defaults,options);
		return this.each(function() {
	    	var $input=$(this);
	    	var inputid=$input.attr('id');
	    	if(inputid==''){
	    		inputid=$input.attr('class');
	    		$input.attr('id',inputid);
	    	}

			// init
			tinymce.init({
			    language:'zh_TW',
			    height:300,
			    width:'100%',
			    plugins:[
			    	'advlist autolink lists link image charmap print preview anchor',
			    	'searchreplace visualblocks code fullscreen textcolor colorpicker',
			    	'insertdatetime media table contextmenu paste code hr pagebreak nonbreaking'
			    ],
			    toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			    toolbar2: 'fontselect fontsizeselect | forecolor backcolor',
			    selector:'#'+inputid,
			    forced_root_block : '',
			    convert_urls: false,
			    paste_data_images: true,
			    images_upload_url: o.url,
			    images_upload_base_path: '',
			    images_upload_handler: function (blobInfo, success, failure) {
			    	var xhr, formData;

			        xhr = new XMLHttpRequest();
			        xhr.withCredentials = false;
			        xhr.open('POST', o.url);
			        xhr.onload = function() {
			            var json;

			            if (xhr.status != 200) {
			                failure("HTTP Error: " + xhr.status);
			                return;
			            }

			            json = JSON.parse(xhr.responseText);

			            if (!json || typeof json[0].path != "string") {
			                failure("Invalid JSON: " + xhr.responseText);
			                return;
			            }
			            success(o.filepath+json[0].path);
			        };
			        formData = new FormData();
			        formData.append('uploadfilepath', o.filepath);
			        formData.append('uploadid', 'tinymcefile');
			        formData.append('tinymcefile[]', blobInfo.blob(), blobInfo.filename());
			        xhr.send(formData);
			    },
			    init_instance_callback: function (ed) {
			        // ed.execCommand('mceImage');
			    }
			});			
		});
	};

	$.fn.inputtinymce.defaults={
		filepath:'',
		url:''
	};

	/*===============================
	    Input Plugin Auto Complete
	    Update: 2018-10-14
	    PHP: admin api-autocomplete
	===============================*/
	$.fn.inputautocomplete=function(options){
		var o=$.extend({},$.fn.inputautocomplete.defaults,options);
		return this.each(function() {
			var $input=$(this);
	    	var inputval=$input.val();
	    	var toolid=($input.attr('id')||$input.attr('class'))+'inputtool';
	    	var toollabelid=toolid+'label';

			// init
			var $tool=$('<ul id="'+toolid+'" class="'+o.css+'"></ul>');
			var $toolli=$('<li></li>');
			var $tool_search=$('<input type="text" placeholder="'+o.tip+'" size="60">');
			var $tool_label=$('<span id='+toollabelid+'></span>');

			if(o.hidden){$input.hide()} // hidden input
			$toolli.append($tool_label);
			$tool.append($toolli)
			$input.after($tool);
			$input.after($tool_search);

			// set item
			if(inputval==''){
				$tool.hide();
			    $tool_search.show();
		    }else{
		     	$tool.show();
	     		$tool_search.hide();
		     	$.getJSON(o.url, {
		     		tablename: o.table,
		     		label: o.label, 
			    	value: o.value,
		     		input:inputval
		     	}, function(json, textStatus) {
					if(json.length>0){
			        	$tool_label.text(json[0].label);
     					$tool_search.hide(json[0].label);
     					$input.trigger('ready');
					}
				});
		    }

		    $input.on('refresh',function(){
		    	if($input.val()==''){
					$tool.hide();
				    $tool_search.show();
			    }else{
			     	$tool.show();
		     		$tool_search.hide();
			     	$.getJSON(o.url, {
			     		tablename: o.table,
			     		label: o.label, 
				    	value: o.value,
			     		input:$input.val()
			     	}, function(json, textStatus) {
						if(json.length>0){
				        	$tool_label.text(json[0].label);
	     					$tool_search.hide(json[0].label);
						}
					});
			    }
		    })

		    // search on auto complete
		    $tool_search.autocomplete({
		    	minLength: o.min,
		      	source:function( request, response) {
		      		var condvalue=$(o.condfield).length>0?$(o.condfield).val():$('input[name="'+o.condfield+'"]').val();
				    $.getJSON(o.url,{ 
				    	tablename: o.table, 
				    	label: o.label, 
				    	value: o.value,
				    	require: o.require,
				    	term:request.term,
				    	condfield:o.condfield,
				    	condvalue:condvalue
				    }, response);
				},
		      	select: function( event, rs ){
			        $tool.show();
			        $tool_search.hide();
			        $tool_label.text(rs.item.label);
			        $input.val(rs.item.value);
		    	},
		    	change:function(event, ui){
		    		$input.trigger('change');
		    		if (ui.item === null) {
		    			$input.val('');
			            $(this).val('');
		    			$tool.hide();
     					$tool_search.show();
			        }
		    	}
		    }).focus(function () {
			    $(this).autocomplete("search");
			});

			// open search
			$tool_label.click(function(){
			    $tool.hide();
				$tool_search.val($tool_label.text()).show();
			});

			// close search
			$tool_search.keypress(function(event){
				if (event.keyCode == 13){
					$tool.show();
					$tool_search.hide();
				}
			});
		});
	};

	$.fn.inputautocomplete.defaults={
		url:'',
		css:'inputauto',
		table:'',
		label:'title',
		value:'no',
		require:'',
		cond:'',
		condfield:'',
		tip:'',
		hidden:true,
		min:0
	};

	/*===============================================
        Input Plugin List
        Update: 2018-10-30
        Label : field1,field2,...
        Search Autocomplete
        Select Format 1 Layer: {"1":"a","2":"b"}
        Select Format Optgroup: [{ 
        	text:'a',
        	children:[{id:"11",text:"a1"}]
        }];
    ===============================================*/
	$.fn.inputlist=function(options){
   		var o=$.extend({},$.fn.inputlist.defaults,options);
	    return this.each(function(){
	    	var $input=$(this);
	    	var inputval=$input.val();
            var toolid=($input.attr('id')||$input.attr('class'))+'inputtool';

			// input value set
			if(o.format=='comma'){
				inputval=!inputval?[]:inputval.split(',');
			}else if(o.format=='json'){
				inputval=JSON.parse(!inputval?'[]':inputval);
			}

			// init
			var $tool=$('<ul id="'+toolid+'" class="'+o.css+'"</ul>');
			var $toolli=$('<li><div><p></p></div></li>');
			var $tool_search=$('<input type="text" placeholder="'+o.tip+'" size="60">');
			var $tool_select=$('<select></select>').append(o.toolprend);
			var $tool_addrow=$('<input class="btn-gray" type="button" value="增加"/>');
			var $tool_drag=$('<div class="dragli"></div>');
			var $tool_deleterow=$('<span class="rowdelete"></span>');

			if(o.hidden){$input.hide()} // hidden input
			if(o.prepend){$tool_select.prepend(o.prepend)}
			if(o.append){$tool_select.append(o.append)}
			$input.after($tool.css('margin-top','3px'));
			if(o.url==''){
				$input.after($tool_select);
				$tool_select.after($tool_addrow);
			}else{
				$input.after($tool_search);
			}
			$toolli.append($tool_deleterow);
			$toolli.prepend($tool_drag);

			// remove reference item
			$tool.children('li').remove();

			// select init
			for(var i in o.data){
				if(typeof o.data[i].children == 'undefined'){
					$tool_select.append($('<option value="'+i+'">'+o.data[i]+'</option>'));
				}else{
                	var $optgroup=$('<optgroup label="'+o.data[i][o.text]+'"></optgroup>');
	    			for(var j=0,jmax=o.data[i].children.length;j<jmax;j++){
		                $optgroup.append($('<option value="'+o.data[i].children[j]['id']+'">'+o.data[i].children[j].text+'</option>'));
		            }
	                $tool_select.append($optgroup);
				}
            }

            // search on auto complete
		    $tool_search.autocomplete({
		    	minLength: 0,
		      	source:function( request, response) {
				    var condvalue=$(o.cond).length>0?$(o.cond).val():$('input[name="'+o.cond+'"]').val();
				    $.getJSON(o.url,{ 
				    	tablename: o.table, 
				    	label: o.label, 
				    	value: o.value,
				    	require: o.require,
				    	term:request.term,
				    	condfield:o.condfield,
				    	condvalue:condvalue
				    }, response);
				},
		      	select: function( event, rs ){
		      		var $tmpli=$toolli.clone(true).show();
					var $tmptext=$tmpli.find("p");
					$tmpli.data('id',rs.item.value);
					$tmptext.html(rs.item.label);
					$tool.append($tmpli);
					_refresh();
		    	},
		    	close:function(){
					$tool_search.val('');
		    	}
		    }).focus(function () {
			    $(this).autocomplete("search");
			}).click(function () {
			    $(this).autocomplete("search");
			});

			// add row
			$tool_addrow.click(function(){
				if($tool.find("li").length<o.rowmax){
					var $tmpli=$toolli.clone(true).show();
					var $tmptext=$tmpli.find("p");
					$tmpli.data('id',$tool_select.val());
					$tmptext.html($tool_select.find('option:selected').text());
					$tool.append($tmpli);
					_refresh();
				}else{
					alert("最多"+o.rowmax+"列")
				}
			});

			// delete row
			$tool_deleterow.click(function(){
				if($tool.find("li").length>o.rowmin){
					$(this).parent().remove();
					_refresh();
				}else{
					alert("最少"+o.rowmin+"列")
				}
			});

			// create item
			for(var i=0,imax=inputval.length;i<imax;i++){
				if(o.url==''){
					var $tmpli=$toolli.clone(true).show();
					var $tmptext=$tmpli.find("p");
					$tmpli.data('id',inputval[i]);
					$tmptext.html($tool_select.find('option[value='+inputval[i]+']').text());
					$tool.append($tmpli);	
				}else{
					$.getJSON(o.url, {
			     		tablename: o.table,
			     		label: o.label, 
				    	value: o.value,
			     		input:inputval[i]
			     	}, function(json, textStatus) {
						if(json.length>0){
	     					var $tmpli=$toolli.clone(true).show();
							var $tmptext=$tmpli.find("p");
							$tmpli.data('id',json[0].value);
							$tmptext.html(json[0].label);
							$tool.append($tmpli);
						}
					});	
				}
			}
			
			// sort row
			$tool.sortable({
				handle:".dragli",
				placeholder:"placeholder",
				stop:function(){_refresh()}
			});

			// refresh input value
			function _refresh(){
				var $tmpli=$tool.find("li");
				var arr=[];
				for(var i=0,imax=$tmpli.length;i<imax;i++){
					arr.push($tmpli.eq(i).data('id'));
				}
				if(o.format=="comma"){
					$input.val(arr.join(","));
				} else if(o.format=="json"){
					$input.val(JSON.stringify(arr));
				}
				$input.trigger('change');
				
				// refresh callback
				if(typeof(o.refresh)=='function'){
            		o.refresh.call();
    			}
			}
	    })
	};

   	$.fn.inputlist.defaults={
    	css:'inputtool inputauto',
        rowmin:0, // 最小列數
		rowmax:100, // 最大列數
        hidden:true, // hidden
        format:'comma', // comma,json
        refresh:'',
        source:'select', // select,autocomplete
        // source autocomplete
        url:'',
		table:'',
		label:'title',
		value:'no',
		require:'',
		cond:'',
		condfield:'',
        // source select
        data:'',
        append:'',
        prepend:'<option></option>',
        text:'text'
	};

	/*===============================================
        Input Plugin Select
        Update: 2020-2-10
        Format 1 Layer: {"1":"a","2":"b"}
        Format Optgroup: [{ 
        	text:'a',
        	children:[{id:"11",text:"a1"}]
        }];
    ===============================================*/
	$.fn.inputselect=function(options){
   		var o=$.extend({},$.fn.inputselect.defaults,options);
	    return this.each(function(){
	    	var $input=$(this);
	    	var inputval=$input.val();
            var toolid=($input.attr('id')||$input.attr('class'))+'inputtool';

			// init
			var $tool=$('<select id="'+toolid+'"></select>').append(o.toolprend);
			o.data=$(o.data).length>0?$(o.data).val():o.data;
			o.data=$('input[name="'+o.data+'"]').length>0?$('input[name="'+o.data+'"]').val():o.data;
			o.data=JSON.parse(o.data);

			if(o.hidden){$input.hide()} // hidden input
			if(o.prepend){$tool.prepend(o.prepend)}
			if(o.append){$tool.append(o.append)}
			$input.after($tool);

			for(var i in o.data){
				if(typeof o.data[i].children == 'undefined'){
					$tool.append($('<option value="'+i+'">'+o.data[i]+'</option>'));
				}else{
                	var $optgroup=$('<optgroup label="'+o.data[i][o.text]+'"></optgroup>');
	    			for(var j=0,jmax=o.data[i].children.length;j<jmax;j++){
		                $optgroup.append($('<option value="'+o.data[i].children[j]['id']+'">'+o.data[i].children[j].text+'</option>'));
		            }
	                $tool.append($optgroup);
				}
            }

            // select value set
            $tool.find('option[value='+inputval+']').attr('selected','selected');

		    // select change
            $tool.change(function(){
            	_refresh();
            })

			// refresh input value
			function _refresh(){
				$input.val($tool.find('option:selected').val());
			}
	    })
	};

   	$.fn.inputselect.defaults={
    	tool:'', // tool
    	css:'',
        append:'',
        prepend:'<option></option>',
        hidden:true, // hidden
        data:'[]',
        text:'text'
	};

    /*==========================
        Input Default Value
        Update: 2017-11-8
    ==========================*/
	$.fn.inputdefault=function(){
		return this.each(function(){
			var $input=$(this);
			var str=$input.attr('default');
			
			// init
			if($input.val()==str || $input.val()==''){
				$input.attr('style','color:#999')
				$input.val(str);
			}else{
				$input.attr('style','color:#000')
			}

			// click
			$input.click(function(){
				var $this=$(this);
				$this.attr('style','color:#000');
				if($this.val()==str){
					$this.val('');				
				}
			});

			// blur
			$input.blur(function(){
				var $this=$(this);
				if($this.val()==str || !$this.val()){
					$this.attr('style','color:#999');
					$this.val(str);
				}
			});
		});
    }

    /*============================
        Input Plugin Checkbox
        Update: 2018-7-20
    ============================*/
	$. fn.inputcheckbox=function(options){
		var o=$.extend({},$. fn.inputcheckbox.defaults,options);
		return this.each(function() {
            var $input=$(this);
			var inputval=$input.val();
            var toolid=($input.attr('id')||$input.attr('class'))+'inputtool';
			var data=JSON.parse(o.data);
			
			// input value set
			if(o.format=='comma'){
				inputval=inputval.split(',');
			}else if(o.format=='json'){
				inputval=JSON.parse((inputval==''||inputval==undefined)?'[]':inputval);
			}

			// init
			var $tool=$('<div id="'+toolid+'"></div>');
			var $checkbox=$('<input type="checkbox">');

			if(o.hidden){$input.hide()} // hidden input
			$input.after($tool);

			// checkbox change
			$checkbox.change(function(){
				_refresh();
			})

			// create item
			for(var i in data){
				var $item=$checkbox.clone(true);
				$item.attr('value',data[i].value);
				if(inputval.indexOf(data[i].value)>=0){
					$item.prop('checked',true);
				}
				$tool.append($item).append(data[i].label);
			}
			
			// refresh input value
			function _refresh(){
				var $checkbox=$tool.find('input[type="checkbox"]:checked');
				var arr=[];
				for(var i=0,imax=$checkbox.length;i<imax;i++){
					arr[i]=$checkbox.eq(i).val();
				}
				if(o.format=="comma"){
					$input.val(arr.join(","));
				} else if(o.format=="json"){
					$input.val(JSON.stringify(arr));
				}
			};
		});
    }
	
	$.fn.inputcheckbox.defaults={
		hidden:true,
		data:"[]",
		format:"comma" // comma,json
	};

    /*========================
        Input Plugin Tag
        Update: 2017-11-8
    ========================*/
	$. fn.inputtag=function(options){
		var o=$.extend({},$. fn.inputtag.defaults,options);
		return this.each(function() {
            var $input=$(this);
			var inputval=$input.val();
            var toolid=($input.attr('id')||$input.attr('class'))+'inputtool';
			var tags=o.tags.split(",");
			
			// input value set
			if(o.format=='comma'){
				inputval=inputval.split(',');
			}else if(o.format=='json'){
				inputval=JSON.parse((inputval==''||inputval==undefined)?'[]':inputval);
			}

			// init
			var $tool=$('<div id="'+toolid+'" class="editbox"></div>');
			var $tool_edit=$('<a href="javascript:void(0)">標籤編輯</a>');

			$input.after($tool);
			$input.after(']').after($tool_edit).after(' [');

			for(var i in tags){
				if(inputval.indexOf(tags[i])>=0)
					$tool.append('<input type="checkbox" value="'+tags[i]+'" checked="checked">'+tags[i]+' ');
				else
					$tool.append('<input type="checkbox" value="'+tags[i]+'">'+tags[i]+' ');
			}
			
			// editbox toggle
			$tool_edit.click(function(){
				$tool.slideToggle('fast');
			});
			
			// checkbox change
			$tool.find("input").change(function(){
				_refresh();
			})
			
			// refresh input value
			function _refresh(){
				var $checkbox=$tool.find('input[type="checkbox"]:checked');
				var arr=[];
				for(var i=0,imax=$checkbox.length;i<imax;i++){
					arr[i]=$checkbox.eq(i).val();
				}
				if(o.format=="comma")
					$input.val(arr.join(","));
				else if(o.format=="json")
					$input.val(JSON.stringify(arr));
			};
		});
    }
	
	$.fn.inputtag.defaults={
		tags:"",
		format:"comma" // comma,json
	};

    /*==========================
        Input Plugin Meta
        Update: 2017-11-8
    ==========================*/
	$.fn.inputmeta=function(options){
		var o=$.extend({},$.fn.inputmeta.defaults,options);
		return this.each(function() {
			var $input=$(this);
			var toolid=($input.attr('id')||$input.attr('class'))+'inputtool';

			// init
			var $tool=$('<div style="margin-top:5px" id="'+toolid+'"></div>');
			var $toolselect=$('<select style="height:22px;vertical-align:middle;"></select>');
			var $toolinput=$('<input style="vertical-align:middle;" type="text" value="" size="20" maxlength="50">');
			var $tool_add=$('<input class="btn-gray" style="height:22px;vertical-align:middle;" type="button" value="增加">');

			$tool.append($toolselect);
			$tool.append($toolinput);
			$tool.append($tool_add);
			$input.after($tool);

			for(var i in o.meta){
				$toolselect.append('<option value="'+o.meta[i]+'">'+o.meta[i]+'</option>');
			}
			
			// input clear value
			$toolinput.click(function(){
				$(this).val("");
			});
			
			// add meta
			$tool_add.click(function(){
				$input.val($input.val()+'<meta name="'+$toolselect.val()+'" content="'+$toolinput.val()+'" />\n');
			});
		});
    }
	
	$. fn.inputmeta.defaults={
		meta:["keywords","description","og:title","og:type","og:url","og:image","og:site_name"]
	};

    /*==========================================
        Input Plugin Multi
        Update: 2018-10-10
        Select: By Select Add Row
        Input Type Hidden: key or type=hidden
        Input label: inputtool-label
    ==========================================*/
	$.fn.inputmulti=function(options){
		var o=$.extend({},$.fn.inputmulti.defaults,options);
		return this.each(function() {
	    	var $input=$(this);
	    	var inputval=$input.val();
	    	var toolid=o.tool||(($input.attr('id')||$input.attr('name'))+'inputtool');
	    	var selectid=o.select||toolid+'select';

			// input value set
			inputval=JSON.parse((inputval=='')?'[]':inputval);

			// init
			var $tool=$('#'+toolid).length==0?$input.siblings('.inputtool').attr('id',toolid):$('#'+toolid);
			var $toolli=$tool.children('li').clone();
			var $tool_addrow=$('<input class="btn-gray" id="'+toolid+'_addrow" type="button" value="增加"/>').hide();
			var $tool_drag=$('<div class="dragli"></div>');
			var $tool_deleterow=$('<span class="rowdelete"></span>');
			var $select=$('#'+selectid).length==0?$input.siblings('select').attr('id',selectid):$('#'+selectid);
			var selectdata=function(){
				var data={};
				$select.find('option').each(function(){
					var $this=$(this);
					if($this.val()!=''){
						data[$this.val()]=$this.text();
					}
				})
				return data;
			}();

			o.select=$select.length==0?false:$select.attr('key')||true;
			o.format=$toolli.find('[key]').length==0?'array':'object';
			o.target=o.select===true?'type="hidden"':'key="'+o.select+'"';

			if(o.hidden){$input.hide()} // hidden input
			if(o.add){$tool_addrow.show();}
			if(o.delete){$toolli.append($tool_deleterow);}
			if(o.sort){$toolli.prepend($tool_drag);}
			if(o.select){
				$select.after($tool_addrow);
			}else{
				$tool.after($tool_addrow);
			}

			// remove reference item
			$tool.children('li').remove();

			// add row
			$tool_addrow.click(function(){
				var $option=$select.find('option');
				var $selected=$select.find(':selected');
				var index=$selected.index();
				var err=false;

				if($tool.find("li").length>o.rowmax){
					err=true;
					alert("最多"+o.rowmax+"列")
				}

				if(o.select){
			    	if($selected.val()==''||$option.length==0){
			    		err=true;
					}
			    }

				if(!err){
			        var $tmpli=$toolli.clone(true).show();
					if(o.select){
						$tmpli.find('input['+o.target+']').val($selected.val())
						$tmpli.find('.'+o.label).text($selected.text());
						$select.find(':nth-child('+($selected.index()+2)+')').prop('selected',true);
						$selected.remove();
						// $select.trigger('refresh');
					}
					$tool.append($tmpli);
					_refresh();
			    }
			});

			// delete row
			$tool_deleterow.click(function(){
				if($tool.find("li").length>o.rowmin){
					$(this).parent().remove();
					$select.trigger('refresh');
					_refresh();
				}else{
					alert("最少"+o.rowmin+"列")
				}
			});
			
			// sort row
			$tool.sortable({
				handle:".dragli",
				placeholder:"placeholder",
				stop:function(){_refresh()}
			});
			
			// input textarea
			$toolli.find("input,textarea").on('change keydown',function(){
				_refresh();
			});

			// select refresh
			$select.on('refresh',function(){
				var key=[];
				var tar=o.select===true?'type="hidden"':'key="'+o.select+'"';
				$tool.find('li input['+o.target+']').each(function(){
						key.push($(this).val());
					});
		      	$select.html('');
		      	for( var i in selectdata){
		      		if(key.indexOf(i)<0){
		      			$select.append('<option value="'+i+'">'+selectdata[i]+'</option>')
		      		}
		      	}
		    });

			// create item
			for(var i=0,imax=inputval.length;i<imax;i++){
				var $tmpli=$toolli.clone(true).attr('id',toolid+i);
				var $tmpinput=$tmpli.find("input,textarea");
				if(o.select){
					var key=(o.format=='array')?0:o.select;
					$tmpli.find('.'+o.label).text(selectdata[inputval[i][key]]);
				}
				for(var j=0,jmax=$tmpinput.length;j<jmax;j++){
					var key=(o.format=='array')?j:$tmpinput.eq(j).attr('key');
					$tmpinput.eq(j).val(inputval[i][key]);
				}
				$tool.append($tmpli);
			}

			// create min item
			for(var i=0,imax=o.rowmin-inputval.length;i<imax;i++){
				$tool.append($toolli.clone(true))
			}

			// ready
			$select.trigger('refresh');
			if(typeof(o.ready)=='function'){
        		o.ready.call();
			}

			// refresh input value
			function _refresh(){
				var $tmpli=$tool.find("li");
				var arr=[];
				for(var i=0,imax=$tmpli.length;i<imax;i++){
					var $tmpinput=$tmpli.eq(i).find("input,textarea");
					var tmparr=(o.format=='array')?[]:{};
					for(var j=0,jmax=$tmpinput.length;j<jmax;j++){
						var key=(o.format=='array')?j:$tmpinput.eq(j).attr('key');
						tmparr[key]=$tmpinput.eq(j).val();
					}
					arr.push(tmparr);
				}
				$input.val(JSON.stringify(arr));
				$input.trigger('change');
				
				// refresh callback
				if(typeof(o.refresh)=='function'){
            		o.refresh.call();
    			}
			};
		});
	};
	
	$.fn.inputmulti.defaults={
		tool:'', // tool 
		select:'', // select
		target:'', // setect target
		label:'inputtool-label', // select value text
		rowmin:1, // 最小列數
		rowmax:10, // 最大列數
		format:'array', // array,object *attr-key auto change
		hidden:true,
		sort:true,
		delete:true,
		add:true,
		ready:'',
		refresh:''
	};

	/*===============================
	    Input Plugin Image Upload
	    Update: 2019-8-19
	===============================*/
	$.fn.inputimageupload=function(options){
		var o=$.extend({},$.fn.inputimageupload.defaults,options);
		return this.each(function() {
	    	var $input=$(this);
	    	var inputval=$input.val();
	    	var toolid=($input.attr('id')||$input.attr('class'))+'inputtool';
			var toolfileid=toolid+'upfiles';

			// input value set
			if(o.format=='comma'){
				inputval=(inputval=='')?[]:inputval.split(',');
			}else if(o.format=='json'){
				inputval=JSON.parse((inputval=='')?'[]':inputval);
			}

			// init
			var $tool=$('<ul id="'+toolid+'" class="'+o.css+'"></ul>');
			var $toolli=$('<li class="fileempty dragli"><div class="fileimage" key="filepath"><a class="filetarget" target="_blank" style="display:inline-block;width:100%;height:100%"></a></div><div class="filestate">選擇檔案</div></li>');
			var $tool_file=$('<div class="filetd"><input class="fileinput" name="'+toolfileid+'" type="file" accept="image/*"></div>');
			var $tool_cannel=$('<div class="filecannel">取消</div>')
			var $tool_upload=$('<input class="btn-gray" type="button" value="上傳檔案"/>');
			var $tool_addrow=$('<input class="btn-gray" type="button" value="增加"/>');
			var $tool_deleterow=$('<div class="filedelete" filetarget=""></div>')
			
			if(o.delete){$toolli.append($tool_deleterow);}
			$toolli.prepend($tool_cannel);
			$toolli.append($tool_file);
			if(o.hidden){$input.hide()} // hidden input
			$input.after($tool_upload).after(' ');
			$input.after($tool_addrow);
			$input.after($tool);

			// file on selected preview image
			$tool_file.on("change", function(){
				var $this=$(this);
				var filelist = event.target.files;
				for(var i=0,imax=filelist.length; i<imax ;i++ ) {
					var file = filelist[i]
					if (!file.type.match('image.*')) {
						continue;
					}
					var reader = new FileReader();
					reader.onload = (function(file){
						return function(event){
							// console.log(file.name)
							var $item=$this.parent();
							$item.addClass('fileready');
							$item.find('.fileimage').css("background-image", "url("+event.target.result+")");
							$item.find('.filestate').html('');
						};
					})(file);
					reader.readAsDataURL(file); // use DataURL read image
				}
				// $tool_upload.trigger('click');
			});

			// cannel on click
			$tool_cannel.on('click',function(){
				var $item=$(this).closest('li');
				$item.removeClass('fileready')
				$item.find('.fileimage').css('background-image','');
				$item.find('.fileinput').val('');
				$item.find('.filestate').html('選擇檔案');
			})

			// add row
			$tool_addrow.click(function($thistable){		
				if($tool.find("li").length<o.rowmax){
					$tool.append($toolli.clone(true));
				}else{
					alert("最多"+o.rowmax+"列");
				}
				if($tool.find('fileready').length<$tool.find(".filetd").length){
					$tool_addrow.show();
				}else{
					$tool_addrow.hide();
				}
			});

			// delete row
			$tool_deleterow.click(function(){
				var $this=$(this);
				if($tool.children('li').length>o.rowmin){
					if($this.attr('filetarget')!=""){
						ajaxDeleteFile($this.attr('filetarget'));
					}
					$this.closest('li').fadeOut(function(){
						$(this).remove();
						_refresh();
					})
				}else{
					if($this.attr('filetarget')!=""){
						ajaxDeleteFile($this.attr('filetarget'));
						$this.closest('li').fadeOut(function(){
							$(this).remove();
							_refresh();
						})
						$tool.append($toolli.clone(true));
					}else{
						alert('最少'+o.rowmin+'列');
					}
				}
			});

			// upload file
			$tool_upload.click(function(){
				var formdata = new FormData();
				formdata.append('uploadfilepath', o.filepath);
		        formdata.append('uploadid', toolfileid);
		        var $item=$tool.find('.fileready');
		        for (var i = 0,imax=$item.length; i < imax; i++) {
		        	$item.find('.filestate').html('上傳中...');
				    formdata.append(toolfileid+'[]', $item.find('.fileinput')[i].files[0]);
				}
		        formdata.append('type', o.type);
		        formdata.append('bigsize', o.bigsize);
				$.ajax({
					url : o.url,
					method: 'POST',
					data: formdata,
					contentType: false,
					processData: false,
					cache: false,
					success: function (response) {
						// console.log(response)
						var data=JSON.parse(response);
						var $item=$tool.children('.fileready');	
						for(var i=0,imax=$item.length;i<imax;i++){
							$item.eq(i).find('.filestate').html(data[i]['msg']);
							if(data[i]['state']==1){
								$item.removeClass('fileready');
								$item.removeClass('fileempty');
								$item.eq(i).find('.fileimage').data("background-image","url("+o.filepath+data[i]['path']+")");
								$item.eq(i).find('.fileimage').attr('filepath',data[i]['path'])
								$item.eq(i).find('.filedelete').attr("filetarget",o.filepath+data[i]['path']);
								$item.eq(i).find('.filestate').fadeOut();
							}
						}
						_refresh();
					},
					error: function (msg) {
						alert('Ajax Request Error');   
					},
					complete: function(xhr) {
						console.log(xhr.responseText);
					}
				})
			});

			// create item
			inputval=function(){
				var arr=[];
				var istep=$toolli.find('.fileimage').length;
				for(var i=0,imax=inputval.length;i<imax;i+=istep){
					arr.push(inputval.slice(i,i+istep));
				}
				return arr;
			}();
			for(var i=0,imax=inputval.length;i<imax;i++){
				var $tmpli=$toolli.clone(true);
				var $tmpinput=$tmpli.find('.fileimage');
				for(var j=0,jmax=$tmpinput.length;j<jmax;j++){
					var key=(o.format=='comma')?j:$tmpinput.eq(j).attr('key');
					$tmpinput.eq(j).css('background-image','url('+o.filepath+inputval[i][key]+')');
					$tmpli.find('.fileimage').attr('filepath',inputval[i][key]);
					$tmpli.find('.filedelete').attr('filetarget',o.filepath+inputval[i][key]);
					$tmpli.find('.filestate').hide();
				}
				$tool.append($tmpli.removeClass('fileempty'));
			}

			// create min item
			for(var i=0,imax=(o.rowmin||1);i<imax;i++){
				if(inputval.length==0){
					$tool.append($toolli.clone(true));
				}
			}

			// sort row
			$tool.sortable({
				// handle:".dragli",
				placeholder:"placeholder",
				stop:function(){_refresh()}
			});

			// refresh input value
			function _refresh(){
				var $tmpli=$tool.children('li:not(.fileempty)');
				var arr=[];
				for(var i=0,imax=$tmpli.length;i<imax;i++){
					var $tmpinput=$tmpli.eq(i).find('.fileimage');
					var tmparr=(o.format=='comma')?[]:{};
					var key=(o.format=='comma')?0:$tmpinput.attr('key');
					tmparr[key]=$tmpinput.attr('filepath');
					arr.push(tmparr);
				}
				if(o.format=='comma'){
					$input.val(arr.join(','));
				}else if(o.format=='json'){
					$input.val(JSON.stringify(arr));
				}
			};
			
		});
	};

	$.fn.inputimageupload.defaults={
		filepath:'',
		url:'',
		type:'limit',
		bigsize:[1000,1000],
		css:'imguploadtool',
		rowmin:0, // 最小列數
		rowmax:10, // 最大列數
		format:'comma', // comma,json
		hidden:true,
		sort:true,
		delete:true
	};

	/*===============================
	    Input Plugin File Upload
	    Update: 2019-11-28
	===============================*/
	$.fn.inputfileupload=function(options){
		var o=$.extend({},$.fn.inputfileupload.defaults,options);
		return this.each(function() {
	    	var $input=$(this);
	    	var $form=$(o.form);
	    	var inputval=$input.val();
	    	var toolid=($input.attr('id')||$input.attr('class'))+'inputtool';
			var toolfileid=toolid+'upfiles';

			// input value set
			if(o.format=='comma'){
				inputval=(inputval=='')?[]:inputval.split(',');
			}else if(o.format=='json'){
				inputval=JSON.parse((inputval=='')?'[]':inputval);
			}

			// init
			var $tool=$('<ul id="'+toolid+'" class="'+o.css+'"</ul>');
			var $toolli=$('<li><input type="text" value="" size="50" key="filename"><input type="hidden" value="" size="50" key="filepath"> [<a href="" target="_blank">預覽</a>]</li>');
			var $tool_file=$('<input name="'+toolfileid+'[]" type="file" multiple="multiple">');
			var $tool_msg=$('<span style="color:#CC0000"></span>');
			var $tool_drag=$('<div class="dragli"></div>');
			var $tool_deleterow=$('<span class="rowdelete"></span>');
			
			if(o.hidden){$input.hide()} // hidden input
			if(o.delete){$toolli.append($tool_deleterow);}
			if(o.sort){$toolli.prepend($tool_drag);}
			$input.after($tool);
			$input.after($tool_msg).after(' ');
			$input.after('最多'+o.rowmax+'個檔案').after(' ');
			$input.after($tool_file);

			// upload file paramete set
			if(!$('#inputuploadidset').length){
				$input.after('<input name="inputuploadidset" id="inputuploadidset" type="hidden" value=""/>');
			}
			if(!$('#inputuploadfilepath').length){
				$input.after('<input name="inputuploadfilepath" id="inputuploadfilepath" type="hidden" value=""/>');
			}

			// filename change refresh input value 
			$toolli.find('input[type="text"]').keyup(function (){
				_refresh();
			});

			// upload file
			$tool_file.change(function () {
				var formdata = new FormData();
				formdata.append('uploadfilepath', o.filepath);
		        formdata.append('uploadid', toolfileid);
				formdata.append(toolfileid+'[]', $(this)[0].files[0]);
				// console.log($(this)[0].files[0].size);
				// console.log($(this)[0].files[0].name);
				// console.log($(this).val());
				if($tool.find('li').length>=o.rowmax){
					$tool_msg.html('檔案數最大為'+o.rowmax);
				}else{
					$tool_msg.html('檔案上傳中...');
					$.ajax({
						url : o.url,
						method: 'POST',
						data: formdata,
						contentType: false,
						processData: false,
						cache: false,
						success: function (response) {
							// console.log(response)
							var data=JSON.parse(response);
							for(i=0,imax=data.length;i<imax;i++){
								var $tmpli=$toolli.clone(true);
								var $tmpinput=$tmpli.find('input');
								if(data[i]['state']==1){
									$tmpinput.eq(0).val(data[i]['name']);
									$tmpinput.eq(1).val(data[i]['path']);
									$tmpli.find('a').attr('href',o.filepath+data[i]['path']);
									$tool.append($tmpli);
								}
							}
							_refresh();
							// reset form
							$tool_file.val('');
							$tool_msg.html('上傳成功').delay(3000).html('');
						},
						error: function (xhr, textStatus, errorThrown) {
							console.log(xhr)
							console.log(textStatus)
							console.log(errorThrown)
							$tool_msg.html('上傳失敗').delay(3000).html('');
						},
						complete: function(xhr, textStatus, errorThrown) {
							console.log(xhr)
							console.log(textStatus)
							console.log(errorThrown)
						}
					});
					return false;
				}
			});										  
				
			//delete row
			$tool_deleterow.click(function(){
				if($tool.find("li").length>o.rowmin){
					$(this).parent().remove();
					_refresh();
				}else{
					$tool_file.val('');
					alert("最少"+o.rowmin+"列")
				}
			});

			// create item
			inputval=function(){
				var arr=[];
				var istep=(o.format=='comma')?$toolli.find('input').length:1;
				for(var i=0,imax=inputval.length;i<imax;i+=istep){
					var data=(o.format=='comma')?inputval.slice(i,i+istep):inputval.slice(i,i+istep)[0];
					arr.push(data);
				}
				return arr;
			}();
			for(var i=0,imax=inputval.length;i<imax;i++){
				var $tmpli=$toolli.clone(true);
				var $tmpinput=$tmpli.find('input');
				for(var j=0,jmax=$tmpinput.length;j<jmax;j++){
					var key=(o.format=='comma')?j:$tmpinput.eq(j).attr('key');
					$tmpinput.eq(j).val(inputval[i][key]);
					if(key=='filepath'||key==1){
						$tmpli.find('a').attr('href',o.filepath+inputval[i][key]);
					}
				}
				$tool.append($tmpli);
			}

			// sort row
			$tool.sortable({
				handle:".dragli",
				placeholder:"placeholder",
				stop:function(){_refresh()}
			});

			// refresh input value
			function _refresh(){
				var $tmpli=$tool.find("li");
				var arr=[];
				for(var i=0,imax=$tmpli.length;i<imax;i++){
					var $tmpinput=$tmpli.eq(i).find('input');
					var tmparr=(o.format=='comma')?[]:{};
					for(var j=0,jmax=$tmpinput.length;j<jmax;j++){
						var key=(o.format=='comma')?j:$tmpinput.eq(j).attr('key');
						tmparr[key]=$tmpinput.eq(j).val();
					}
					arr.push(tmparr);
				}
				if(o.format=='comma'){
					$input.val(arr.join(','));
				}else if(o.format=='json'){
					$input.val(JSON.stringify(arr));
				}
			};
		});
	};

	$.fn.inputfileupload.defaults={
		form:'',
		filepath:'',
		url:'',
		css:'fileuploadtool',
		rowmin:0, // 最小列數
		rowmax:1, // 最大列數
		format:'comma', // comma,json
		hidden:true,
		sort:true,
		delete:true
	};

	/*===============================
	    Input Plugin Upload Trigger
	    Update: 2017-11-8
	===============================*/
	$.fn.inputuploadtrigger=function(options){
		var o=$.extend({},$.fn.inputuploadtrigger.defaults,options);
		return this.each(function() {
	    	var $input=$(this);
	    	var $form=(o.form=='')?$input.closest("form"):$(o.form);
	    	var inputval=$input.val();
			var toolid=($input.attr('id')||$input.attr('class'))+'inputtool';
			var toolfileid=toolid+'upfiles';

			// init
			var $tool=$('<div id="'+toolid+'" class="'+o.css+'"</div>');
			var $tool_file=$('<input name="'+toolfileid+'[]" type="file" multiple="multiple">');
			var $tool_msg=$('<span style="color:#CC0000"></span>');
			
			if(o.hidden){$input.hide()} // hidden input
			$input.after($tool);
			$input.after($tool_msg).after(' ');
			$input.after($tool_file);

			// upload file paramete set
			if(!$('#inputuploadidset').length){
				$input.after('<input name="inputuploadidset" id="inputuploadidset" type="hidden" value=""/>');
			}
			if(!$('#inputuploadfilepath').length){
				$input.after('<input name="inputuploadfilepath" id="inputuploadfilepath" type="hidden" value=""/>');
			}

			// upload file
			$tool_file.change(function () {
				// console.log($(this)[0].files[0].size);
				// console.log($(this)[0].files[0].name);
				// console.log($(this).val());
				$('#inputuploadidset').val(toolfileid);
				$('#inputuploadfilepath').val(o.filepath);
				if($tool.find('li').length>=o.rowmax){
					$tool_msg.html('檔案數最大為'+o.rowmax);
				}else{
					$tool.html('');
					$tool_msg.html('檔案上傳中...');
					$form.ajaxSubmit({
						// datatype : 'json',
						url : o.url,
						success: function (response) {
							console.log(response)
							var data=JSON.parse(response);
							if(data[0]['state']==1){
								o.filepath+data[0]['path'];
							}

							// reset form
							$tool_file.val('');
							$tool_msg.html('執行中...');
							setTimeout(function() {$tool_msg.html('');}, 3000);

							//trigger
							$.ajax({
							  	type: 'POST',
								url : o.trigger,
							  	data: {file:o.filepath+data[0]['path']},
								datatype : 'json',
								success: function (response) {
									var data=JSON.parse(response);
									var str='';
									for(var i=0,imax=data.length;i<imax;i++){
										if(str!=''){
											str+='<br/>';
										}
										str+=data[i];
									}
									$tool.slideDown();
									$tool.html(str);
									$tool_msg.html('執行成功');  
									setTimeout(function() {$tool_msg.html('');}, 3000);
								},
								error: function (msg) {
									$tool_msg.html('執行錯誤');
									setTimeout(function() {$tool_msg.html('');}, 3000);
								}
							})
						},
						error: function (msg) {
							$tool_msg.html('上傳失敗');  
							setTimeout(function() {$tool_msg.html('');}, 3000);
						},
						complete: function(xhr) {
							//console.log(xhr.responseText);
						}
					});
					return false;
				}
			});										  
		});
	};

	$.fn.inputuploadtrigger.defaults={
		form:'',
		filepath:'',
		url:'',
		trigger:'',
		css:'editbox',
		hidden:true
	};

	/*===============================
	    Input Any Picker For Time Length
	    Update: 2020-2-5
	    jQuery:AnyPicker
	===============================*/
	$.fn.inputanypickertime=function(options){
		var o=$.extend({},$.fn.inputanypickertime.defaults,options);
		return this.each(function() {
	    	var $input=$(this);
	    	var inputval=$input.val();
			var pickerdata = function(hours){
        		var arr=[];
        		var range = [hours, 59, 59];
		        for(var i=0;i<range.length; i++) {
		        	arr[i]=[];
		        	for(var j=0,jmax=range[i]+1;j<jmax;j++) {
		            	var str=j.toString();
		            	if(str.length==1) {
		                	str='0'+str;
		            	}
			            arr[i][j]={
			            	val: str,
			            	label: str
			            };
		        	}
		        }
		        return arr;
		    }(o.hours);

		    var dataSource = [{
		        component: 0,
		        data: pickerdata[0]           
		    }, {
		        component: 1,
		        data: pickerdata[1]           
		    }, {
		        component: 2,
		        data: pickerdata[2] 
		    }];

		    function parseInput(data) {
		        var arr=['00','00','00'];
		        if(data !== undefined && data !== null && data !== ""){
		          arr=data.split(':');
		        }
		        return arr;
		    }

		    function formatOutput(data) {
		        var arr=[];
		        for(var i=0,imax=this.tmp.numOfComp;i<imax;i++) {
		          arr.push(data.values[i].label.toString());
		        }
		        return arr.join(':');
		    }

			// init
		    $input.AnyPicker({
		        mode: "select",
		        layout: o.layout,
				i18n:o.i18n,
		        actionMode: "both",
		        rowsNavigation: o.rowsNavigation,
		        showComponentLabel: true,
		        components: o.components,
		        dataSource: dataSource,
		        parseInput: parseInput,
		        formatOutput: formatOutput,
				onSetOutput : function(){ $input.trigger('change')}
		    });									  
		});
	};

	$.fn.inputanypickertime.defaults={
		layout: "popup", // popup, relative, fixed, inline
		rowsNavigation: "scroller", // scroller, buttons, scroller+buttons
		hours:23,
		i18n:{
			headerTitle: "",
		},
		components:[{
	        component: 0,
	        name: "hours",
	        label: "時",
	        width: "50%",
	        textAlign: "center"
	    }, {
	        component: 1,
	        name: "mintes",
	        label: "分",
	        width: "20%",
	        textAlign: "center"
	    }, {
	        component: 2,
	        name: "seconds",
	        label: "秒",
	        width: "30%",
	        textAlign: "center"
		}]
	};

	/*=====================================
	    Input Plugin Get Google Geocode
	    Update: 2017-11-5
	=====================================*/
	$.fn.inputgeocode=function(options){
		var o=$.extend({},$.fn.inputgeocode.defaults,options);
		return this.each(function() {
	    	var $input=$(this);
			var $source=$(o.source);
			var sourceval=$source.val();

			// init
			var $tool=$('<span style="color:blue;text-decoration:underline;cursor:pointer">'+o.text+'</span>');
			
			$input.after(']').after($tool).after(' [');

			// click get source
			$tool.click(function(){
		    	var geocoder = new google.maps.Geocoder();
		    	var val;
		    	geocoder.geocode( { address: sourceval}, function(results, status) {
			        if (status == google.maps.GeocoderStatus.OK) {
			        	switch(o.data){
			        		case 'latlng':
			        		val=results[0].geometry.location.lat()+','+results[0].geometry.location.lng();
			        		break;
			        		case 'address':
			        		val=results[0].formatted_address;
			        		break;
			        	}
			        	$input.val(val);
			        }
		    	});
			});

			// input dblclick get source
			$input.dblclick(function(event) {
		    	$tool.trigger('click');
			});
		});
	};

	$.fn.inputgeocode.defaults={
		source:'',
		data:'latlng',
		text:'取得'
	};

	/*==============================
	    Input Plugin Get Or Put
	    Update: 2017-4-5
	==============================*/
	$.fn.inputgetput=function(options){
		var o=$.extend({},$.fn.inputgetput.defaults,options);
		return this.each(function() {
	    	var $input=$(this);
	    	var $form=(o.form=='')?$input.closest("form"):$(o.form);
			var $target=$(o.target);
			var targettype=(o.targettype||$target.prop('tagName')).toLowerCase();

			// init
			var $tool_btn=$('<span style="color:blue;text-decoration:underline;cursor:pointer">擷取文字</span>');
			var $tool_checkbox=$('<input type="checkbox">');
			
			if(o.click){$input.after(']').after($tool_btn).after('[');}
			if(o.check){$input.after($tool_checkbox);}

			// click get source
			$tool_btn.click(function(){
				var $source=(o.type=='get')?$target:$input;
				var $put=(o.type=='get')?$input:$target;
				var str=function(){
					switch(targettype){
					case 'tinymce':
	      				return html2txt(tinymce.get(o.target.substr(1,o.target.length-1)).getContent());
	      				break;
	      			case 'input':
	      				return $source.val();
	      				break;
	      			case 'textarea':
	      				return $source.val();
	      				break;
					}
				}().replace(/\n/g,'').replace(/\r/g,'').substr(0,o.max);
				$put.val(str); //don`t use text
			});

			// on submit trigger click
			$form.submit(function(){
				var $check=(o.type=='get')?$input:$target;
				if(!$check.val()||$tool_checkbox.is(':checked')&&o.submit){
					$tool_btn.trigger('click');
				}
				// return false
			});
		});
	};

	$.fn.inputgetput.defaults={
		form:'',
		target:'',
		targettype:'', // input,textarea,tinymce
		type:'get',
		max:255,
		click:true,
		check:true,
		submit:true
	};

   /*==========================================
        Input Plugin Facebook
    ==========================================*/
	$.fn.inputfacebook=function(options){
		var o=$.extend({},$.fn.inputfacebook.defaults,options);
		return this.each(function() {
			var $this=$(this);
			var toolid=(o.tool=="")?"#"+$this.attr("id")+"inputtool":o.tool;
			var toolname=toolid.substring(1,toolid.length)
			var inputval=$this.val();

			// input value set
			if(o.output=="comma"){
				inputval=inputval.split(",");
			}else if(o.output=="json"){
				if(inputval=="" || inputval==undefined)
					inputval="[]";
				inputval=JSON.parse(inputval);
			}
			
			// init
			$this.after('<input class="btn-gray" style="height:22px" id="'+toolname+'add" type="button" value="新增"> facebook網址或id');
			$this.after('<input id="'+toolname+'url" type="text" size="50" maxlength="100" default="'+o.url+'">');
			$this.after('<ul id="'+toolname+'" class="fbgrouplist"><li style="display:none"><div class="dragli"></div><div class="rowcontent"></div><span class="rowdelete"></span></li></ul>');
			var $tool=$(toolid);
			var $toolli=$tool.find("li");
			
			// input url default
			$(toolid+"url").inputdefault();
			
			// delete
			$toolli.find(".rowdelete").click(function(){
				if($tool.find("li").length-1>o.rowmin){
					$(this).parent().remove();
					_refresh();
				}else{
					alert("最少"+o.rowmin+"列")
				}
			});
			
			// add row
			$(toolid+"add").click(function(){
				if($tool.find("li").length<=o.rowmax){
					var $tmpli=$toolli.clone(true).show();
					$tmpli.find(".rowcontent").html(row_create(getFbGraph($(toolid+"url").val(),"id,name")));
					$tool.append($tmpli);
					_refresh();
				}else{
					alert("最多"+o.rowmax+"列")
				}
			});
			
			// init
			$this.css('display','none') //隱藏輸入欄位
			if(inputval.length<=0){
				$tool.append($toolli.clone(true));
			}else{
				var iarr=JSON.parse(inputval);
				var imax=iarr.length;
				for(var i=0;i<imax;i++){
					var $tmpli=$toolli.clone(true).show();
					$tmpli.find(".rowcontent").html(row_create(getFbGraph(iarr[i],"id,name")));
					$tool.append($tmpli);
				}
			}

			// sort
			$tool.sortable({
				handle:".dragli",
				placeholder:"placeholder",
				stop:function(){_refresh()}
			});
			
			// row create
			function row_create(data){
				var str='<img src="http://graph.facebook.com/'+data.id+'/picture?type=square"/><p><a href="https://www.facebook.com/'+data.id+'" target="_blank">' + data.name + '</a></p>';
				if(o.fblike==true)
					str+='<iframe style="'+o.fblikecss+'" src="//www.facebook.com/plugins/like.php?href='+data.url+'&amp;send=false&amp;layout='+o.fblayout+'&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;scrolling="no" frameborder="0" allowTransparency="true"></iframe>';
				return str;
			};
			
			// refresh input value
			function _refresh(){
				var $thisli=$tool.find("li");
				var imax=$thisli.length;
				var arr=[];
				for(var i=1;i<imax;i++){
					arr.push($thisli.eq(i).find("a").attr('href').replace('https://www.facebook.com/',''));
				}
				if(o.format=="comma")
					$this.val(arr.join(","));
				else if(o.format=="json")
					$this.val(JSON.stringify(arr));
			};
		});
	};
	
	$.fn.inputfacebook.defaults={
		tool:"", // tool
		fblike:true,  // add like button
		fblayout:"standard", // standard,box_count,button_count,button
		fblikecss:"",
		url:"https://www.facebook.com/", // input url default 
		rowmin:0, // 最小列數
		rowmax:10, // 最大列數
		format:"json" // comma,json
	};	

})(jQuery);

function ajaxDeleteFile(src){
	// console.log(src)
	$.ajax({
		url: '../api-deletefile.php',
		cache: false,
		dataType: 'html',
		type:'post',
		data: {				
			files: src
		},
		success: function(response){
			console.log(response);
		},
		error: function(xhr) {
			alert('Ajax Request Error');
		},
	});
}