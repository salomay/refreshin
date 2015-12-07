// AJAX call for autocomplete
var MIN_LENGTH = 2; 
$(document).ready(function(){
	$("#katakunci").keyup(function(){
		var keyword = $("#katakunci").val();
		if (keyword.length >= MIN_LENGTH) {
			$.ajax({
				type: "POST",
				url: "../xaja/autocomplete.php",
				data:'keyword='+$(this).val(),
				success: function(data){
					$("#hasilcari").show();
					$("#hasilcari").html(data);
				}
			});
		}else{
			$("#hasilcari").hide();
		}
	});
	
});
//To select country name
function pilihDestinasi(val) {
	$("#katakunci").val(val);
	$("#hasilcari").hide();
}