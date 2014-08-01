

jQuery(document).ready(function($){
	


	 var initMetro = function(){

	 	/* 	Title Area */
	 	var header 			= $('#header');
	 	var h_title			= $(header).find('#title a');

	 	
		// alert(tempImageSrc.length);

	 	/*	Init Title Area 	*/
	 	$('.tile-area-title').text($(h_title).text());

	 	

	 };
	 initMetro();



	var initMetroGallery = function(){

		var gallery			= $('#sidebar');
		var galleryImage	= $(gallery).find('.category-favorites');
		var tempImageSrc	= [];
		var tempImageName	= [];

		/* 	Favorite Area */
		for(var a=0; a<galleryImage.length; a++){
			var tempName 	= $(galleryImage[a]).find('.entry-title a').text();
			var tempURL 	= $(galleryImage[a]).find('img').attr('src');
			tempImageSrc.push(tempURL);
			tempImageName.push(tempName);
		}

		/*	Init Favorite Area*/ 
		for(var b=0; b<galleryImage.length; b++){
			var blitz_gallery	= $('#blitz-gallery');
		 	var blitz_galleryM	= $(blitz_gallery).find('.modal-hidden .tile');
		 	var $blitz_galleryC	= $(blitz_galleryM).clone();
		 	$( ".con-img", $blitz_galleryC ).attr('src', ''+tempImageSrc[b]+'');
		 	$( ".label", $blitz_galleryC ).text(''+tempImageName[b]+'');
		 	$('#blitz-gallery').append( $blitz_galleryC );
		}

	};
	initMetroGallery();



	/* 	CLICK FUNCTION FOR GALLERY TILE */
	var accessGallery = function(){

		var that 	= this;
		var aSlug 	= $(that).find('.label').text();
		var slug 	= aSlug.toLowerCase();

		$.ajax({
		  	type: "POST",
		  	url: cfx_ajax.ajaxurl,
		  	data: { 
				"action" : cfx_ajax.ajax_action, 
                "do" : "access_post", 
                "data" : {'key': "gallery", 'value': ""+slug+""},
                "_ajax_nonce" : cfx_ajax._ajax_nonce
            },
            success: function(result){
            	console.log(result);
				var theTitle= result.title;
				var theContent= result.content;
			},
           	dataType : "json"
		})
		

	};
	$('.tile-gallery').on('click', accessGallery);
	/* 	CLICK FUNCTION FOR GALLERY TILE */








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