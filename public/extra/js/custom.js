$(document).ready(function(){	
	
	// SELECTBOXES
	/*$(function() {
        $('.dataTables_length input, select').not("select.multiple").selectmenu({
            style: 'dropdown',
            transferClasses: true,
            width: null
        });
    });*/
	
	// RADIOBUTTONS & CHECKBOXES
	$("input[type=radio], input[type=checkbox]").each(function() {
        if ($(this).parents("table").length === 0) {
            $(this).customInput();
        }
    });
	
	/*// FILE INPUT STYLE
    $("input[type=file]").filestyle({
        imageheight: 28,
        imagewidth: 85,
        width: 150
    });*/
    
    // INPUT PLACEHOLDER
	$('input[placeholder], textarea[placeholder]').placeholder();
    
	// HIDE LEFT PANEL
	$(".hide-btn").click(function(){
		if($("#left").css("width") == "0px"){
			$("#left").animate({width:"230px"}, 500);
			$("#right").animate({marginLeft:"250px"}, 500);
			$("#wrapper, #container").animate({backgroundPosition:"0 0"}, 500);
			$(".hide-btn.top, .hide-btn.center, .hide-btn.bottom").animate({left: "229px"}, 500, function() { $(window).trigger("resize");});
		
			$(".hide-btn.top, .hide-btn.center, .hide-btn.bottom").removeClass('toright');
			$(".hide-btn.top, .hide-btn.center, .hide-btn.bottom").addClass('toleft');
		}
		else{
			$("#left").animate({width:"0px"}, 500);
			$("#right").animate({marginLeft:"0px"}, 500);
			$("#wrapper, #container").animate({backgroundPosition:"-230px 0px"}, 500);
			$(".hide-btn.top, .hide-btn.center, .hide-btn.bottom").animate({left: "-12px"}, 500, function() { $(window).trigger("resize");});
	
			$(".hide-btn.top, .hide-btn.center, .hide-btn.bottom").removeClass('toleft');
			$(".hide-btn.top, .hide-btn.center, .hide-btn.bottom").addClass('toright');
		}
	});
	
    // HIDE BOXES	
	$(function() {
		$('.title .hide').showContent();
	});

	$.fn.showContent = function() {
		return this.each(function() {
			var box = $(this);
			var content = $(this).parent().next('.content');

			box.toggle(function() {
				content.slideUp(500);
			}, function() {
				content.slideDown(500);
			});

		});
	};
	
	// AUTOGROW TEXTAREA
	jQuery('.grow').elastic();
	
	// SYSTEM MESSAGES
	$(".message").live('click',function () {
      $(this).fadeOut();
    });
	 
	// DATATABLE
    $('table.all').dataTable({
        "bInfo": false,
        "iDisplayLength": 10,
        "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        "sPaginationType": "full_numbers",
        "bPaginate": true,
        "sDom": '<f>t<pl>',
        "oLanguage": {
            "oPaginate": {
              "sNext": "Berikutnya",
              "sPrevious": "Sebelumnya",
              "sFirst": "Awal",
              "sLast": "Terakhir",
              "sEmptyTable": "Tak ada data yang tersedia",
              "sProcessing": "Sedang memproses data"
            }
        }
    });
    
    //LOGIN BOX
	$(document).ready(function() {
	    $("#loginBox").click(function() {
	    	$("#loginBoxContent").toggle();
	    	$("#loginBox").toggleClass("activeLoginBox");
	    	$(".loginBoxToggle").toggleClass("activeLoginBoxToggle");
	    	if(!isLoggedIn)loadPage('<s:url action="ajax/login" />','#loginBoxContent');
	    });
	});	
	
//	//Navigation Fixed Floating
//	$(document).ready(function () {  
//		var top = $('nav').offset().top - parseFloat($('nav').css('marginTop').replace(/auto/, 0));
//		$(window).scroll(function (event) {
//			// what the y position of the scroll is
//		    var y = $(this).scrollTop();
//		  
//		    // whether that's below the form
//		    if (y >= top) {
//		    	// if so, ad the fixed class
//		    	$('nav').addClass('fixedNavigation');
//		    }else {
//		    	// otherwise remove it
//		    	$('nav').removeClass('fixedNavigation');
//		    }
//		});
//	});
	
	//Scroll to top
	$(function() {
		$(window).scroll(function() {
			if($(this).scrollTop() != 0) {
				$('#toTop').fadeIn();	
			} else {
				$('#toTop').fadeOut();
			}
		});
	 
		$('#toTop').click(function() {
			$('body,html').animate({scrollTop:0},800);
		});	
	});
	
	//Sidebar Navigation
	var accordion_head = $('.accordion > li > a');
	var accordion_body = $('.accordion li > .sub-menu');

	accordion_head.first().addClass('active').next().slideDown('normal');
	accordion_head.on('click', function(event) {
		event.preventDefault();
		if ($(this).attr('class') != 'active'){
			accordion_body.slideUp('normal');
			$(this).next().stop(true,true).slideToggle('normal');
			accordion_head.removeClass('active');
			$(this).addClass('active');
		}
	});
});

//Sidebar Navigation Function
function setActiveSidebarMenu(obj){
	var accordion_head = $('.accordion > li > a');
	var accordion_body = $('.accordion li > .sub-menu');
	
	if ($("#"+obj).attr('class') != 'active'){
		accordion_body.slideUp('normal');
		$("#"+obj).next().stop(true,true).slideToggle('normal');
		accordion_head.removeClass('active');
		$("#"+obj).addClass('active');
	}
}

function FreezeScreen(msg) {
    scroll(0,0);
    
    var image_load = "<div style='text-align: center;' ><img src='"+imageLoading+"' /></div>";
    var content = image_load+"Mohon Tunggu...<h3>\""+msg+"\"</h3>";
    
    if($('#FreezePane')) $('#FreezePane').addClass('FreezePaneOn');
    if($('#InnerFreezePane')) $('#InnerFreezePane').html(content);
}