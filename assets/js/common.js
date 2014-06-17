$(document).ready(function(){

	function resetErrors() {
		var $this = $(this),
			$field = $this.closest('.extra-field'),
			$error = $field.find('.error');
		$error.hide();
	}

	$('.input').on('change', resetErrors);
	$('.input').on('click', resetErrors);

	/**************************
	 *
	 *
	 *
	 *  ARROW ALERT
	 *
	 *
	 **************************/
	if($(window).height() > 800) {
		$("#alertArrow").hide();
	} else {
		TweenMax.to($("#alertArrow"), 0.5, {css:{top:"-=30px"}, yoyo:true, repeat:6});
		TweenMax.to($("#alertArrow"), 1, {css:{opacity:0}, delay:3, onComplete:function(){
			$("#alertArrow").hide().remove();
		}});
	}

	/**************************
	 *
	 *
	 *
	 *  GALLERY
	 *
	 *
	 **************************/
	$(".gallery").fancybox({
		fitToView	: true,
		padding		: 0,
		margin		: 30,
		autoSize	: true,
		closeClick	: false,
		helpers:  {
			title : {
				type : 'float'
			},
			overlay : {
				opacity  : 0.3
			}
		}
	});
	/**************************
	 *
	 *
	 *
	 *  PAGES FRAME
	 *
	 *
	 **************************/
	$(".inscriptions, .mentions").fancybox({
		fitToView	: false,
		padding		: 20,
		maxWidth	: 760,
		maxHeight	: 600,
		autoSize	: false,
		closeClick	: false,
		helpers:  {
			title : null,
			overlay : {
				opacity  : 0.3
			}
		}
	});
	$(".credits").fancybox({
		fitToView	: false,
		padding		: 20,
		maxWidth	: 760,
		maxHeight	: 250,
		autoSize	: false,
		closeClick	: false,
		helpers:  {
			title : null,
			overlay : {
				opacity  : 0.3
			}
		}
	});
	$(".participants").fancybox({
		type		: 'iframe',
		fitToView	: true,
		width		: '100%',
		height		: '100%',
		padding		: 0,
		margin		: 20,
		autoSize	: true,
		closeClick	: false,
		helpers:  {
			title : null,
			overlay : {
				opacity  : 0.3
			}
		}
	});
	/**************************
	 *
	 *
	 *
	 *  ARROW FRAME
	 *
	 *
	 **************************/
	$("#alertBtn").fancybox({
		fitToView	: false,
		padding		: 20,
		width	: 200,
		height	: 250,
		modal:false,
		helpers:  {
			title : null,
			overlay : {
				opacity  : 0.1
			}
		}
	})
	$("#alertBtn").hide().click();
	/**************************
	 *
	 *
	 *
	 *  CONFIRM FRAME
	 *
	 *
	 **************************/
	$("#confirmBtn").fancybox({
		fitToView	: false,
		padding		: 20,
		width	: 200,
		height	: 250,
		modal:false,
		helpers:  {
			title : null,
			overlay : {
				opacity  : 0.1
			}
		}
	}).hide().click();

});