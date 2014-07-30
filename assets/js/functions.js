(function($) {
    $.StartScreen = function(){
        var plugin = this;

        plugin.init = function(){
            setTilesAreaSize();
            addMouseWheel();
        };

        var setTilesAreaSize = function(){
            var groups = $(".tile-group");
            var tileAreaWidth = 160;
            $.each(groups, function(i, t){
                tileAreaWidth += $(t).outerWidth()+46;
            });
            $(".tile-area").css({
                width: tileAreaWidth
            });
        };

        var addMouseWheel = function (){
            $("body").mousewheel(function(event, delta){
                var scroll_value = delta * 50;
                $(document).scrollLeft($(document).scrollLeft() - scroll_value);
                return false;
            });
        };

        plugin.init();
    }
})(jQuery);

$(function(){
    $.StartScreen();
});

jQuery(document).ready(function($){

	// 	INIT METRO
		$('body').addClass('metro');
	// 	INIT METRO




	// 	BUILD BLACK BOX
	var buildBlackBox = function(){
		$('body').append('<div id="blackbox" style="display:none;"></div>')

	};
	buildBlackBox();
	// 	BUILD BLACK BOX


	
	// 	BUILD SIDE MENU
	var buildMenu = function(){

		/*
		 * 	INITIALIZE TARGET
		 */
		 	var menuStart	= $('#menu-start');


		/*
		 * 	INITIALIZE COMPONENTS
		 */
			var menuMain 	= $('#nav').find('.navbar-nav.menu-primary');	
			var menuMain_li = $(menuMain).find('li');
			var menuMain_a	= [];
			var menuMain_r	= [];
			var menuMain_i	= [];

			for( var a=0; a < menuMain_li.length; a++ ){
				var textA = $(menuMain_li[a]).find('a').text();
				var reffA = $(menuMain_li[a]).find('a').attr('href');
				var iconA = $(menuMain_li[a]).find('a i').attr('class');
				menuMain_a.push( textA );
				menuMain_r.push( reffA );
				menuMain_i.push( iconA );
			}

			$.ajax({
			  	type 	: "POST",
			  	url 	: cfx_ajax.ajaxurl,
			  	data 	: { 
							"action" 				: cfx_ajax.ajax_action, 
		                    "do" 					: "get_interface", 
		                    "data" 					: {'key': "sidemenu"},
		                    "_ajax_nonce" 			: cfx_ajax._ajax_nonce
                },
                success: function(result){
        /*
		 * BUILD MENU
		 */ 
		                	var material_wrapper 	= result.wrapper;
		                	var material_recurse 	= result.wrapper_recurse;
		                	var material_data 		= result.recurse_data;

		                	$(menuStart).append(material_wrapper);

		                	var menuUL = $(menuStart).find('ul');
		                	for( var b = 0; b < menuMain_li.length; b++ ){
		                		$(menuUL).append(material_recurse);
		                	}

		                	var menuLI= $(menuUL).find('li');
							for( var c = 0; c < menuLI.length; c++ ){
		                		$(menuLI[c]).append('<a href="'+menuMain_r[c]+'"><i class="'+menuMain_i[c]+'"></i>'+menuMain_a[c]+'</a>');
		                	}		                	
				},
               	dataType : "json"
			})

		/*
		 *	CLEAR TRACE
		 */
		 	$('#nav').remove();
		 	windowHeight = window.innerHeight;
		 	$('#sidebarMENU').height(windowHeight);

	};
	buildMenu();
	// 	BUILD SIDE MENU
	 
	


});

 


function check_focus(elm,val){
    if(elm.value.toLowerCase() == val.toLowerCase()){
        elm.value = '';    
    }
}

function check_blur(elm,val){
    if(elm.value.toLowerCase() == ''){
        elm.value = val;    
    }
}