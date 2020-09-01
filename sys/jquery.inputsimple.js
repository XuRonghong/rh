(function($){
  $.fn.pluginsimple1 = function(options) {
    var o=$.extend({
      text:"hello"
    },options);

    var _this=this;
    var _arguments = arguments;

    return this.each(function() {
      var methods = {
          init:function(){
            $input.val($input.attr('id')+o.text);
          },
          addrow:function(html) {
            $input.after(html);
          }
      };

      var $input=$(this);

      _this.extend(methods);

      if( methods[options] ) {
        return methods[ options ].apply( this, Array.prototype.slice.call( _arguments, 1 )); 
      } else if ( typeof options === 'object' || ! options ) {
          return methods.init.apply( $(this), _arguments);
      } else {
          $.error('Method '+options+' does not exist on InputPlugin.');
      }

    });
  }
})( jQuery );

(function($){

  $.fn.pluginsimple2 = function(options) {

    // default settings
    var o=$.extend({
      text:"hello"
    },options);

    var $input=$(this);

    // methods
    var methods = {
      init:function(){
        $input.val($input.attr('id')+o.text);
        this.extend(methods);
        return this;
      },
      addrow:function(html) {
        var html=html||'<div>Default</div>';
        $input.after(html);
        return this
      }
    };

    if( methods[options] ) {
      return methods[ options ].apply( this, Array.prototype.slice.call( arguments, 1 )); 
    } else if ( typeof options === 'object' || ! options ) {
      return methods.init.apply( $(this), arguments);
    } else {
      $.error('Method '+options+' does not exist on InputPlugin.');
    }

  } //end of pluginsimple2

})(jQuery);

// not ok
(function($){
    $.fn.inputtest=function(options){
        var o=$.extend({},$.fn.inputtest.defaults,options);
        var that=this;
        that._refresh=function(){
	    	console.log(this.toolname)
	    }
        return this.each(function(){
            var $input=$(this);
            var toolname=($input.attr('id')||$input.attr('class'))+'inputtool';
            var inputval=$input.val();
            $input.toolname=toolname;
            $input.click(function(){
	        	that._refresh.call($input)
            })
	        $.fn.extend({
	        	getName:function(){
		        	that._refresh.call($input)
			    },
			    setValue:function(x){
			    	$input.val(x)
			    }
		    })
        });
    }

    $.fn.inputtest.defaults={
        tool:"", // tool
        format:"json", // comma,json
        data:'',
        firstitem:'<option></option>',
        text:'text'
    };

})(jQuery);