/*
 * GLOBALLY USED SCRIPT FOR "Refreshin.com"
 * Coder : Miftachul Chandra & Muhammad Firdaus
 */
 
//GLOBAL VARIABLE

var window_width=$(window).width();
var window_height=$(window).height();
 
//BAGIAN INI HARUS DI INIT DI SEMUA HALAMAN
$(document).ready(function(){
	create_fix();
	menu_mobile();
	login();
	result_add();
	fly();
}) 

//TUNGGU PERUBAHAN PADA UKURAN WINDOW
var view_updater;
$(window).resize(function(){
	clearTimeout(view_updater);
	view_updater=setTimeout("view_changed()",150)
})

//TRIGGER EVENT KETIKA UKURAN WINDOW BERUBAH
function view_changed(){
	
}
 
//CREATE FIX UNTUK BROWSER YANG TIDAK SUPPORT CSS GENERATED CONTENT
function create_fix(){
	if(!Modernizr.generatedcontent){
		$(".add_fix").append('<span class="clearfix">&nbsp;</span>')
	}
}

function menu_mobile(){
	$('.menu_mobile').click(function(e){
		e.preventDefault(); //mematikan link

		if($('.wrapmenu').hasClass("open")){		
			$('.wrapmenu').removeClass("open")			
			$(".wrapmenu").animate({left:0},0);
			$(".content").css({width:'88%',left:'12%'});
			$(".head_nf").css({width:'63.5%',left:'12%'});
			$(".head_nf_fr").css({width:'88%',left:'12%'});
			$(".head_nf_community").css({width:'72%',left:'0'});
		}else{
			$('.wrapmenu').addClass("open")
			$(".wrapmenu").animate({left:-200},0);
			$(".content").css({width:'100%',left:'0'});
			$(".head_nf").css({width:'72%',left:'0'});
			$(".head_nf_fr").css({width:'100%',left:'0'});
		}
	});
}

function login() {
	$('.pop_box_login').height($(window).height());
	$('.login_link').click(function(e){
	e.preventDefault(); //mematikan link
		$('.pop_box_login').show();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.pop_box_login').hide();
	});
}
function result_add() {
	$('.pop_box_add').height($(window).height());
	$('.add_des').click(function(e){
	e.preventDefault(); //mematikan link
		$('.pop_box_add').show();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.pop_box_add').hide();
	});
}

function fly() {

	$(window).scroll(function(){
		if ($(window).scrollTop() > 191){
		$('.head_nf_community').css({position:'fixed', top:'60px'});

		}else{
			$('.head_nf_community').css({top:'0','position':'relative'});
			$('.wrapmenu').css({'z-index':'999'});
		}
	})

}



/*---------------------------------- end of file ----------------------------------*/