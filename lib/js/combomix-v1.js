$(document).ready(function(){
	$('#p_negara').change(function(){
		$('#p_propinsi').html('');
		var id_negara = "select id, nama from provinsi where id_negara ='"+$(this).val()+"' order by nama";
		$.ajax({
			type:"POST",
			url:"../xaja/lib/combomix.php",
			data:'kueri='+id_negara,
			success: function(data){				
				$("#p_propinsi").html(data);
			}
		});
	});

});
