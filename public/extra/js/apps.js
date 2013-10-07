function load(page,div){
	var image_load = "<div style='text-align: center; margin: 10px 0px 10px 0px;' ><img src='"+imageLoading+"' /></div>";
    jQuery.ajax({
        url: page,
        beforeSend: function(){
        	jQuery(div).html(image_load);
        },
        success: function(response){
            jQuery(div).html(response);
        },
    dataType:"html"
    });
    return false;
}

function loadCombo(page,div){
	var image_load = "<span id='tempLoad'><img src='"+imageLoadingMicro+"' /></span>";
    jQuery.ajax({
        url: page,
        beforeSend: function(){
        	jQuery(div).append(image_load);
        },
        success: function(response){
        	jQuery("#tempLoad").html("");
            jQuery(div).html(response);
        },
    dataType:"html"
    });
    return false;
}

function load_into_box(page,dt){
    jQuery.ajax({
        url: page,
        data: dt,
        beforeSend: function(){
        	//jQuery.facebox('<div style="padding: 17px; font-size: 36px;">Loading....</div>');
        },
        success: function(response){
            jQuery.facebox(response);
        },
        type:"post",
        dataType:"html"  		
    });

    return false;
}

function load_into_box_alert(title,page,ok,dt){
    jQuery.ajax({
        url: page,
        data: dt,
        beforeSend: function(){
        	jQuery.facebox('<div style="padding: 17px; font-size: 36px;">Loading....</div>');
        },
        success: function(response){	
//        	jQuery.facebox.close();
        	alertPopUp(title, response, ok);
        },
        type:"post",
        dataType:"html"  		
    });

    return false;
}

function sendForm(formObj,action,responseDIV){
    jQuery.ajax({
        url: action, 
        data: jQuery(formObj.elements).serialize(),
        beforeSend: function(){
        	jQuery.facebox.close();
        	jQuery.facebox('<div style="padding: 17px; font-size: 36px;">Loading....</div>');
        },
        success: function(response){
        		jQuery.facebox.close();
                jQuery(responseDIV).html(response);
            },
        type: "post", 
        dataType: "html"
    }); 

    return false;
}

function sendFormAlertPopUp(formObj,action,responseDIV){
	var image_load = "<div style='text-align: center;' ><img src='"+imageLoading+"' /></div>";
    jQuery.ajax({
        url: action, 
        data: jQuery(formObj.elements).serialize(),
        beforeSend: function(){
//        	jQuery.facebox.close();
//        	jQuery.facebox('<div style="padding: 17px; font-size: 36px;">Loading....</div>');
        	jQuery(responseDIV).html(image_load);
        },
        success: function(response){
//        		jQuery.facebox.close();
                jQuery(responseDIV).html(response);
            },
        type: "post", 
        dataType: "html"
    }); 
    return false;
}

function confirmPopUp(command, title, text, yes, no){
	var html = "<div class='fbox_header'>"+title+"</div>" +
			"<div class='fbox_container'><div class='fbox_content'>" +
			text+
			"</div><div class='fbox_footer'>" +
			"<a class=\"uibutton special\" href='javascript:void(0)' onclick='"+command+"'>"+yes+"</a>" +
			"<a class=\"uibutton\" href='javascript:void(0)' onclick='jQuery.facebox.close()'>"+no+"</a>" +
			"</div></div>";
	jQuery.facebox(html);
}

function freeze(title, text){
	var html = "<div class='fbox_header'>"+title+"</div>" +
			"<div class='fbox_container'><div class='fbox_content'>" +
			text+
			"</div><div class='fbox_footer'>" +
			"<a class=\"uibutton disable\" href='javascript:void(0)' >Mohon Tunggu...</a>" +
			"</div></div>";
	jQuery.facebox(html);
}

function alertPopUp(title, text, ok){
	var html = "<div class='fbox_header'>"+title+"</div>" +
			"<div class='fbox_container'><div class='fbox_content'>" +
			text+
			"</div><div class='fbox_footer'>" +
			"<a class=\"uibutton special\" href='javascript:void(0)' onclick='jQuery.facebox.close()'>"+ok+"</a>" +
			"</div></div>";
	jQuery.facebox(html);
}

function maintenance(){
	alertPopUp('Pemberitahuan', 'Mohon Maaf.. Untuk sementara Feature ini belum tersedia..<br />Sedang dalam tahap pengembangan<br />Coba beberapa saat lagi<br /><br />Terima kasih', 'Tutup');
}

function notif(type, text){
	var myNoty = noty({
  		text: text,
  		type: type,
  		layout: "topCenter",
  		callback: {
  		    afterShow: function() {
  		    	setTimeout(function(){myNoty.close()} , 3000)
  		    }
  		},
  	});
}

function setTime(tanggal, jam, menit, detik){
	if(detik == 60){
		menit = parseFloat(menit) +1;
		detik = 0;
	}
	if(menit == 60){
		jam = parseFloat(jam) +1;
		menit = 0;
	}
	if(jam == 24){
		jam = 0;
	}
	
	if(detik.toString().length == 1)detik = "0" + detik;
	if(menit.toString().length == 1)menit = "0" + menit;
	if(jam.toString().length == 1)jam = "0" + jam;
	
	var waktu = jam + ":" + menit + ":" + detik;
	var serverTime = tanggal + " | " + waktu;
	$('#time').html(serverTime);
	
	setTimeout("setTime('"+tanggal+"', '" + parseFloat(jam) + "', '" + parseFloat(menit) + "', '" + (parseFloat(detik)+1) + "')",1000);
}

jQuery(document).ready(function(){
	//for checkbox
	jQuery('input[type=checkbox]').each(function(){
		var t = jQuery(this);
		t.wrap('<span class="checkbox"></span>');
		t.click(function(){
			if(jQuery(this).is(':checked')) {
				t.attr('checked',true);
				t.parent().addClass('checked');
			} else {
				t.attr('checked',false);
				t.parent().removeClass('checked');
			}
		});
	});
	
	jQuery(window).scroll(function() {
		if($(this).scrollTop() != 0) {
			jQuery('#toTop').fadeIn();	
		} else {
			jQuery('#toTop').fadeOut();
		}
	});
 
	jQuery('#toTop').click(function() {
		jQuery('body,html').animate({scrollTop:0},600);
	});	
});
