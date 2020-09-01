// 根據卷軸位置改顯示狀態
(function($) {
	$.fn.scrollToggle = function(options) {
		var o = $.extend({}, $.fn.scrollToggle.defaults, options);
		return this.each(function() {
			var $this = $(this);
			$(window).bind('scroll resize', function(){	
				o.position=(typeof o.position)=='number'?o.position:$(o.position).position().top;
				o.removeclass=o.removeclass==''?o.addclass:o.removeclass;
				if($(window).scrollTop()>o.position){
					switch(o.type){
						case 'show':
							$this.show();
							break;
						case 'hide':
							$this.hide();
							break;
						case 'fadein':
							$this.fadeIn();
							break;
						case 'fadeout':
							$this.fadeOut();
							break;
						case 'class':
							$this.addClass(o.addclass);
							break;
					}
				}else{
					switch(o.type){
						case 'show':
							$this.show();
							break;
						case 'hide':
							$this.hide();
							break;
						case 'fadein':
							$this.fadeOut();
							break;
						case 'fadeout':
							$this.fadeIn();
							break;
						case 'class':
							$this.removeClass(o.removeclass);
							break;
					}
					
				}
			});
		});
	};
	$.fn.scrollToggle.defaults = {
		type 	: 'show', // show, hide, fadein, fadeout, class
		position: 0,
		addclass: '',
		removeclass: '',
	};
})(jQuery);

// 根據卷軸位置改變position狀態
(function($) {
	$.fn.positionToggle = function(options) {
		var opts = $.extend({}, $.fn.positionToggle.defaults, options);
		return this.each(function() {
			var $this = $(this);
			var o = $.meta ? $.extend({}, opts, $this.data()) : opts;
			$(window).bind('scroll resize', function(){
				if(o.align=='bottom'){					
					var scrollmax = o.position-$this.outerHeight()-o.marginY;
					if($(document).height()-($(window).height()+$(window).scrollTop())>(scrollmax)){
						$this.css('position','fixed');
						$this.css('bottom',o.marginY+'px');
						$this.css('top','');				
					}else{
						$this.css('position','absolute')
						$this.css('top',$(document).height()-o.position+'px');
					}
				}else{				
					var scrollmax = o.position-o.marginY;
					if(($(window).scrollTop())>(scrollmax)){
						$this.css('position','fixed');
						$this.css('top',o.marginY+'px');				
					}else{
						$this.css('position','absolute')
						$this.css('top',o.position+'px');
					}			
				}
			});
			$this.ready(function(e){

			})
		});
	};
	$.fn.positionToggle.defaults = {
		align 	: 'top',
		position: 100,
		marginX	: 30,
		marginY : 30
	};
})(jQuery);