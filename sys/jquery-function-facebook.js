function fb_init(){
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			FB.getLoginStatus(fbfan);
		}else if (response.status === 'not_authorized') {
			fblogin();
			$('#islogin').bPopup({modalClose:false});
		}else{
			$('#islogin').bPopup({modalClose:false});
		}
	});
}

function fblogin(){
	FB.login(function(response) {
    	if (response.authResponse) {
        	FB.getLoginStatus(fbfan());
			$('#islogin').bPopup().close();
    	} else {
            alert("請先授權!!");    
    	}
	}, {scope: 'user_likes,user_status,user_about_me,publish_stream'});
}

function fbfan(response){
	FB.api("/me?fields=id,name",function(response){
		$('input[name="id"]').val(response.id);
	});
	if (response.authResponse){
		FB.api("/me/likes/",function(response){
			var like_num=0;
			//var like_id=['125386714156073'];
			likes = response.data;
			for(key in likes) {							
				page_id = likes[key].id;
				//for ie8 indexOf			
				if (!Array.prototype.indexOf){
				  Array.prototype.indexOf = function(elt /*, from*/){
					var len = this.length >>> 0;					
					var from = Number(arguments[1]) || 0;
					from = (from < 0)
						 ? Math.ceil(from)
						 : Math.floor(from);
					if (from < 0)
					  from += len;					
					for (; from < len; from++){
					  if (from in this &&
						  this[from] === elt)
						return from;
					}
					return -1;
				  };
				}
				//end					
				if(like_id.indexOf(page_id)>=0) {
					like_num+=1;
				}
		  	}
			if(like_num>=like_id.length){
				getQuestionAnswer();
			}else{
				$('#isfans').bPopup();
			}
		});
	}
}

function getQuestionAnswer(){		
	$.ajax({
		url: 'ajax-quanswer.php',
		cache: false,
		dataType: 'html',
		type:'GET',
		data: {
			no: $("#questionno").val(),
			selectvalue: $('input[name="questionitem"]:checked').val(),
		},			
		success: function(data){
			var data=jQuery.parseJSON(data);
			$('#questionimg').fadeOut();
			$('#questioncontent').fadeOut();
			$('#answerbtn').fadeOut(); 
			$('#answerbtn').fadeOut(function() {
				$('#questionimg').attr('src','upload/article/'+data['img']);
				$('#questioncontent').html(data['ans']);
				$('#answerbtn').attr('href','javascript:fbpost()');
				$('#answerbtn').find('img').attr('src','btn/fbpost.png');
				$('#questionimg').fadeIn();
				$('#questioncontent').fadeIn();
				$('#answerbtn').fadeIn();
		   	});
		},
		error: function(xhr) {
			alert('Ajax request 發生錯誤');
		}
	});
}

function fbpost(){
	var postbody = { 
		message: $('#questioncontent').html().replace("<br>","\n"), 
		link: location.href,
		picture: 'http://www.likenews.tw/'+$('#questionimg').attr('src'),
		name: $('.title').find('h2').text(),
		caption: 'www.likenews.tw',
		description: $('#questionsummary').text().replace("<br>","\n")
	};
	FB.api('/me/feed', 'post', postbody, function(response) {		
		if (!response || response.error) {		
			alert('發佈失敗');		
		} else {
			document.location.href=location.href+'&msg=已成功發佈到塗鴉牆';	
		}		
	});
}