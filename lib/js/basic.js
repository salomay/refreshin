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
	login();
	result_add();
	fly();
	ava();
	activity();
	transport();
	budget();
	maps_fadeIn();
	menu();
	shop();
	join();
	checkin();
	rating();
	whowashere();
	community();
	reg();
	inputtrip();
	
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


function menu(){

	$(".wrapmenu").height($(window).height());
	$(".mainmenu").height($(window).height());
	if($(window).width() <= 1024){
		$(".mainmenu").height($(window).height()-120);
	}
	$('.overlay-body').height($(window).height());
	$(".burger-menu").click(function(e){
		if($(this).hasClass("is-active")){
			$(this).removeClass("is-active");
			$(".wrapmenu").fadeOut("fast");
			$(".overlay-body").css({'display':'none'});
		}else{
			$(this).addClass("is-active");
			$(".wrapmenu").fadeIn();
			$(".overlay-body").css({'display':'block'});
		}
	});	
}

function login() {
	$('.pop_box_login').height($(window).height());
	$('.login_link').click(function(e){
	e.preventDefault(); //mematikan link
		$('.pop_box_login').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.pop_box_login').fadeOut("fast");
	});
}
function result_add() {
	$('.pop_box_add').height($(window).height());
	$('.add_des').click(function(e){
	e.preventDefault(); //mematikan link
		$('.pop_box_add').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.pop_box_add').fadeOut("fast");
	});
}

function ava(){
	$(".box_account").css({display:'none'});
	$('.ava_head').click(function(e){
		e.preventDefault(); //mematikan link

		if($('.box_account').hasClass("open")){		
			$('.box_account').removeClass("open")			
			$(".box_account").fadeOut("fast");
			$(".overlay-body").fadeOut("fast");
			
		}else{
			$('.box_account').addClass("open")
			$(".box_account").fadeIn();
			$(".overlay-body").fadeIn();
		}
	});
}

function fly() {
	$(window).scroll(function(){
		if ($(window).scrollTop() > 350){
		$('.head_nf_community').css({position:'fixed', top:'60px'});
		}else{
			$('.head_nf_community').css({top:'0','position':'relative'});
		}
	})
}

function activity() {
	$('.overlay_activity').height($(window).height());
	$('.activity').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_activity').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_activity').fadeOut("fast");
	});
}

function transport() {
	$('.overlay_transport').height($(window).height());
	$('.transport').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_transport').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_transport').fadeOut("fast");
	});
}

function budget() {
	$('.overlay_budget').height($(window).height());
	$('.budget').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_budget').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_budget').fadeOut("fast");
	});
}

function shop() {
	$('.overlay_shopping').height($(window).height());
	$('.buy_this').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_shopping').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_shopping').fadeOut("fast");
	});
}

function join() {
	$('.overlay_join').height($(window).height());
	$('.join_thread').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_join').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_join').fadeOut("fast");
	});
}

function checkin() {
	$('.overlay_checkin').height($(window).height());
	$('.check-in').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_checkin').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_checkin').fadeOut("fast");
	});
}

function rating() {
	$('.overlay_rating').height($(window).height());
	$('.add-rate').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_rating').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_rating').fadeOut("fast");
	});
}

function whowashere() {
	$('.overlay_who_was_here').height($(window).height());
	$('.who-here').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_who_was_here').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_who_was_here').fadeOut("fast");
	});
}

function community() {
	$('.overlay_community').height($(window).height());
	$('.more-community').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_community').fadeIn();
	});
	$('.close').click(function(e){
	e.preventDefault(); //mematikan link
		$('.overlay_community').fadeOut("fast");
	});
}

function reg() {
	$('.register-boxed').hide();
	$('.reg-a').click(function(e){
	e.preventDefault(); //mematikan link
		$('.login_wrap').hide();
		$('.register-boxed').slideDown("slow");
	});
	$('.close_reg').click(function(e){
		location.reload();
		$('.pop_box_login').hide();
	});
}

function inputtrip() {
	$('.result-trip li').hide();
	$('.add-new-trip').click(function(e){
	e.preventDefault(); //mematikan link
		$('.result-trip li').show();
	});
}

function maps_fadeIn(){
	$('.my_location a').click(function(e){
		e.preventDefault(); //mematikan link

		if($(this).hasClass("open")){		
			$(this).removeClass("open");		
			$(".boxcon_search_destination").fadeOut("fast");
			$(this).html("Show Map");
		}else{
			$(this).addClass("open");
			$(".boxcon_search_destination").fadeIn();
			$(this).html("Hide Map");

		}
	});
	
}



/*---------------------------------- end of file ----------------------------------*/