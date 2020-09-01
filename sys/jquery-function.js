//滑鼠變換圖片 圖片置換名稱為_over
function ImgHoverjQuery(x) {
	$(x).hover(function() {
		//取得圖片的副檔名
		var file_type=FileType($(this));	
		var img_src=$(this).attr("src").replace("."+file_type, "_over."+file_type);
		$(this).attr('src',img_src);
	} , function(){
		var img_src=$(this).attr("src").replace("_over.",".");
		$(this).attr('src',img_src);
	});
}
	
//抓取副檔名
function FileType(x) {
	var $this=$(x).attr("src").split('.');
	return $this[$this.length-1];
}

//抓取路徑名
function FilePath(x) {
	var $this=$(x).attr("src").split('/');
	var $thisPath='';
	for(i=0;i<$this.length-1;i++){
		$thisPath+=$this[i];
	}
	return $thisPath;
}

//取得名稱
function getTargetName(tar){
	if(tar.search('#')>=0)
		thisname=tar.split('#')[1];
	else
		thisname=tar.split('.')[1];
	return thisname
}

function hex2rgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}


//去除html標籤
function html2txt(str,noEnter){
	var html = str;
	html = html.replace(/<!--[sS]*?-->/img, "");//注释
	html = html.replace(/<[/]*table[^>]*>/img, "");//table
	html = html.replace(/<[/]*tbody[^>]*>/img, "");//tbody
	html = html.replace(/<[/]*tr[^>]*>/img, "");//tr
	html = html.replace(/<[/]*td[^>]*>/img, "");//td
	html = html.replace(/<[/]*p[^>]*>/img, "");//p 一起jquery,17jquery 
	html = html.replace(/<[/]*a[^>]*>/img, "");//a
	html = html.replace(/<[/]*col[^>]*>/img, "");//col
	html = html.replace(/<[/]*br[^>]*>/img, "");//br
	html = html.replace(/<[/]*[^>]*>/img, "");//
	html = html.replace(/<[/]*span[^>]*>/img, "");//span
	html = html.replace(/<[/]*center[^>]*>/img, "");//center
	html = html.replace(/<[/]*ul[^>]*>/img, "");//ul 
	html = html.replace(/<[/]*i[^>]*>/img, "");//i
	html = html.replace(/<[/]*li[^>]*>/img, "");//li
	html = html.replace(/<[/]*b[^>]*>/img, "");//b
	html = html.replace(/<[/]*hr[^>]*>/img, "");//hr
	html = html.replace(/<[/]*hd+[^>]*>/img, "");//h1,2,3,4,5,6
	html = html.replace(/<STYLE[sS]*?<\/STYLE>/img, "");//样式 	
	html = html.replace(/<script[sS]*?<\/script>/img, "");//引用的脚本
	//html = html.replace(/<[?!A-Za-z][^><]*>/img, "");alert("str:"+html)
	html = html.replace(/ /img, "");//换行
	html = html.replace(/ /img, "");//回车
	html = html.replace(/[　|s]* [　|s]* /img, "");
	html = html.replace(/(&nbsp;)*/g,"");
	//html = reg.replace(html,@"( )[^ 　]/img,"$1");
	//html = formatHtml(html);
	if(noEnter){
		html = html.replace(/ /img, ""); 
		html = html.replace(/ /img, "");
		html = html.replace(/ /img, "");
	}
	return (html);
}

function randMix(imax,addtime,type){
	var imax=(typeof imax !== 'undefined')? imax : 20;
	var addtime=(typeof addtime !== 'undefined')? addtime : null;
	var type=(typeof type !== 'undefined')? type : 3;
	var str="";
	for(i=0;i<imax;i++){
		gettype=Math.floor(Math.random()*(type)+1);
		if(gettype==1)
			str+=String(Math.floor(Math.random()*(9-0+1)+0));
		else if(gettype==2)
			str+=String.fromCharCode(Math.floor(Math.random()*(112-97+1)+97));
		else if(gettype==3)
			str+=String.fromCharCode(Math.floor(Math.random()*(90-65+1)+65));
	}
	if(addtime!=null)
		str=Date.now()+str;
	return str;
}

function utf8_encode (argString) {
  // From: http://phpjs.org/functions
  // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: sowberry
  // +    tweaked by: Jack
  // +   bugfixed by: Onno Marsman
  // +   improved by: Yves Sucaet
  // +   bugfixed by: Onno Marsman
  // +   bugfixed by: Ulrich
  // +   bugfixed by: Rafal Kukawski
  // +   improved by: kirilloid
  // +   bugfixed by: kirilloid
  // *     example 1: utf8_encode('Kevin van Zonneveld');
  // *     returns 1: 'Kevin van Zonneveld'

  if (argString === null || typeof argString === "undefined") {
    return "";
  }

  var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
  var utftext = '',
    start, end, stringl = 0;

  start = end = 0;
  stringl = string.length;
  for (var n = 0; n < stringl; n++) {
    var c1 = string.charCodeAt(n);
    var enc = null;

    if (c1 < 128) {
      end++;
    } else if (c1 > 127 && c1 < 2048) {
      enc = String.fromCharCode(
         (c1 >> 6)        | 192,
        ( c1        & 63) | 128
      );
    } else if (c1 & 0xF800 != 0xD800) {
      enc = String.fromCharCode(
         (c1 >> 12)       | 224,
        ((c1 >> 6)  & 63) | 128,
        ( c1        & 63) | 128
      );
    } else { // surrogate pairs
      if (c1 & 0xFC00 != 0xD800) { throw new RangeError("Unmatched trail surrogate at " + n); }
      var c2 = string.charCodeAt(++n);
      if (c2 & 0xFC00 != 0xDC00) { throw new RangeError("Unmatched lead surrogate at " + (n-1)); }
      c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
      enc = String.fromCharCode(
         (c1 >> 18)       | 240,
        ((c1 >> 12) & 63) | 128,
        ((c1 >> 6)  & 63) | 128,
        ( c1        & 63) | 128
      );
    }
    if (enc !== null) {
      if (end > start) {
        utftext += string.slice(start, end);
      }
      utftext += enc;
      start = end = n + 1;
    }
  }

  if (end > start) {
    utftext += string.slice(start, stringl);
  }

  return utftext;
}

//解析 google url 網址參數
function getGooglePanoramaParameter(url){
	if(url.search("https://")>=0 && url.search("www.google.com")>=0){
		var obj = {};
		if(url.search("googleusercontent.com")<0){
			obj.id=url.split("!1s");//!3m5!1e1!3m3!1s
			obj.id=(obj.id[1]==undefined)?"":obj.id[1].substring(0,obj.id[1].search("!"));
		}else{
			obj.id=url.split("!1s");//!3m5!1e1!3m3!1s
			obj.id=decodeURIComponent(obj.id[1].substring(0,obj.id[1].search("!")));
		}
		url=url.substring(url.search("@"),url.length-1);
		url=url.substring(1,url.search("/"));		
		url=url.split(",");
		obj.position=url[0]+","+url[1];
		obj.latitude=url[0];
		obj.longitude=url[1];
		obj.heading=parseFloat(url[4].substring(0,url[4].length-1));
		obj.pitch=parseFloat(url[5].substring(0,url[5].length-1))-parseFloat(90);
		obj.pitch=Math.round(obj.pitch*100)/100;
		obj.zoom=parseFloat(5)-Math.sqrt(parseFloat(url[3].substring(0,url[3].length-1)))*parseFloat(5/Math.sqrt(90));
		obj.zoom=Math.round(obj.zoom*100)/100;
		return obj;
	}else{
		console.log('analysis url error!')
	}
}


// 解析 youtube url 網址參數
function getYoutubeParameter(url){
	var arr = [];
	var url = decodeURIComponent(url);
	var params,temp;
	var i,imax;
	if(url!=""||url!=undefined){
		params=url.split("?").split("&");
		imax=params.length;
		for(i=0;i>imax;i++){
			temp=params[i].split("=")
			arr[params[i][0]]=(params[i][1]);
		}
	}else{
		arr=false;	
	}
	return arr;
}

// 取得 youtube data by api 3.0
function getYoutubeData(arr){
	$.ajaxSettings.async = false; // 設為同步處理
	var apikey='AIzaSyA3b7Ajw_UYHgOeW_ilsK0xoqblxrMyaOQ';// youtube api key
	var moviearr=[];
	var moviereturn=[];
	var record=[]; // 排除特定與重複id
	var i,imax=arr.length;
	
	// get movie data
	for(i=0;i<imax;i++){
		var data=_get(arr[i]);
		if(!data["state"]){
			if(data.length>0){
				var jmax=data.length;
				for(j=0;j<jmax;j++){
					moviearr.push(data[j]);
				}
			}else{
				moviearr.push(data);
			}
		}
	}
		
	// remove recover id
	imax=moviearr.length;
	for(i=0;i<imax;i++){
		if(record.indexOf(moviearr[i].id)<0){
			moviereturn.push(moviearr[i])
			record.push(moviearr[i].id)
		}
	}
	return moviereturn;
	
	// get youtube data
	function _get(e){
		var arr = [];
		var url = '';
		e.alt = ( e.alt == undefined )?"json":e.alt;
		e.order = ( e.order == undefined )?"viewCount":e.order;
		e.count = ( e.count == undefined )?1:e.count;
		if(e.type!="" && e.id!=""){
			switch(e.type){
			case 'video':
				url="https://www.googleapis.com/youtube/v3/videos?part=snippet&id="+e.id+"&key="+apikey;
				break;
			case 'playlist':
				url="https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&playlistId="+e.id+"&orderby="+e.order+"&maxResults="+e.count+"&key="+apikey;
				break;
			case 'channel':
				url="https://www.googleapis.com/youtube/v3/search?part=snippet&channelId="+e.id+"&orderby="+e.order+"&maxResults="+e.count+"&key="+apikey;
				break;
			case 'user':
				url="https://www.googleapis.com/youtube/v3/search?part=snippet&channelId="+_channelid(e.id)+"&orderby="+e.order+"&maxResults="+e.count+"&key="+apikey;
				break;
			}
			$.getJSON(url, function(data){
				if(data==undefined){
					arr.state=false;									
				}else{
					if(e.type=="video"){
						var obj={};
						obj.id=e.id;
						obj.title=data.items[0].snippet.title;
						obj.content=data.items[0].snippet.description;
						obj.img=data.items[0].snippet.thumbnails.default.url;
						arr.push(obj);
					}else{
						var imax=(e.count>=data.items.length)?((e.type=="playlist")?data.items.length:data.items.length-1):e.count;
						for(var i=0;i<imax;i++){
							var obj={};
							if(e.type=="playlist"){
								obj.id=data.items[i].contentDetails.videoId;
								obj.title=data.items[i].snippet.title;
								obj.content=data.items[i].snippet.description;				
								obj.img=data.items[i].snippet.thumbnails.default.url;
							}else if(e.type=="user"||e.type=="channel"){
								obj.id=data.items[i].id.videoId;
								obj.title=data.items[i].snippet.title;
								obj.content=data.items[i].snippet.description;				
								obj.img=data.items[i].snippet.thumbnails.default.url;
							}
							arr.push(obj);
						}
					}
				}
			});
			return arr;
		}
	}

	// get youtube data
	function _channelid(user){
		var obj;
		url="https://www.googleapis.com/youtube/v3/channels?part=snippet&forUsername="+user+"&key="+apikey;
		$.getJSON(url, function(data){
			obj=data.items[0].id;
		});
		return obj;
	}
}	

//取得facebook graph
function getFbGraph(keyword,fields){
	$.ajaxSettings.async = false; //設為同步處理
	var obj;
	var baseurl = 'http://graph.facebook.com/';	
	if(keyword.search('www.facebook.com')>=0){
		fbid=keyword.split('/')[keyword.split('/').length-1];
		url=keyword;
	}else{
		fbid=keyword;
		url='http://www.facebook.com/'+fbid;
	}
	$.getJSON(baseurl+fbid+"?fields="+fields, function(data){
		obj=data;
	});
	if(obj==undefined){
		alert('網址格式錯誤,請重新輸入!!');
	}else{
		obj.url=url
		return obj;
	}
	
}

//html facebook 
function htmlFbLike(thisname,fbidarr,fblayout,fblikecss){
	if(fbidarr!=""){
		var arr=fbidarr.split(',')
		for(var key in arr){
			$.ajaxSettings.async = false; //設為同步處理
			var fbid = arr[key];
			var baseurl = 'http://graph.facebook.com/';
			$.getJSON(baseurl+fbid+'?fields=id,name&callback=?', function(data){
				if(data==undefined){
					alert('網址格式錯誤,請重新輸入!!');
				}else{
					var str='<img src="http://graph.facebook.com/'+data.id+'/picture?type=square" width="32" height="32" /><a href="https://www.facebook.com/'+data.id+'" target="_blank"><p>' + data.name + '</p></a>';			
					str+='<iframe src="//www.facebook.com/plugins/like.php?href=http://www.facebook.com/'+data.id+'&amp;send=false&amp;layout='+fblayout+'&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;scrolling="no" frameborder="0" style="'+fblikecss+'" allowTransparency="true"></iframe>';
					$('#'+thisname).append('<li>'+str+'</li>');
				}
			});
		}	
	}		
}
