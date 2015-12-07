<?php 
if($_SESSION[member]!=""){
$tampil = new usrlib();
echo $tampil->tampilkan_doctype('main');
echo $tampil->tampilkan_header('main');
echo $tampil->tampilkan_menu('main');
$dbu = new db();
$appx = new app();
$urlx = new url();
?>
<body >
	<div class="wrapall">
<script src="<?php echo $app[lib_www];?>/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "#myid",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "preview code undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | unlink link image"
});
</script>		
<div class="wrapcontent">
			<div class="content add_fix">
				<div class="box-left-right add_fix">
					<div class="content_left">
						<div class="input-destinasi">
							<form method="post" action="<?php echo $app[www]."/add_thread_article/";?>">
								<h1 class="main_title" style="margin-bottom:20px;">THREAD ARTIKEL<span class="border"></span></h1>
								<input name="p_judul" id="p_judul" type="text" placeholder="Article Title">
								<input name="p_dest" id="p_dest" type="text" placeholder="Type Destination">
								<div id="topiknya"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#p_dest").keyup(function(){
			var keyword = $("#p_dest").val();
			if (keyword.length >= MIN_LENGTH) {
				$.ajax({

					type: "POST",
					url: "<?php echo $app[lib_www] ?>/xaja/topicDest.php",
					data:'keyword='+$(this).val(),
					success: function(data){
						$("#topiknya").show();
						$("#topiknya").html(data);
					}
				});
			}else{
				$("#topiknya").hide();
			}
		});
		
	});
	//To select country name
	function topicDest(val) {
		$("#p_dest").val(val);
		$("#topiknya").hide();
	}
</script>
								<Select name="p_tipe" id="p_tipe">
									<option value="">choose article type</option>
									<option value ="news">news</option>
									<option value="event">event</option>
									<option value ="discussion">discussion</option>
								</select>
								<textarea id="myid"  name="p_content" style="width:100%"></textarea>
								<div class="robot" style="margin-top:10px;"><img id="siimagex" src="<?php echo $app["lib_www"]."/securimg/securimage_show.php";?>?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="center"></div>
								<input type="text" name="captchax" id="captcha_regx" placeholder="Enter the code shown">
								<p>Can't read this code? <a href="#" onClick="document.getElementById('siimagex').src = '<?php echo $app["lib_www"]."/securimg/securimage_show.php";?>?sid=' + Math.random(); this.blur(); return false">Try a different code</a></p>
								<div class="box-submit-reg add_fix">
									<input type="submit" value="SUBMIT" id="a_submit" style="width:15%;float:right;height:40px;">
									<input type="reset" value="RESET" id="a_resetx" style="width:15%;float:right;">
									<input type="hidden" name="referer" value="<?php echo $urlx->curPageURL()?>">
								</div>
							</form>
						</div>
					</div> <!-- content_left -->	
					<div class="content_right thread_section">
						<?php
							include "part/block_hot_thread.php";
						?>
					</div> <!-- content_right -->
				</div> <!-- box-left-right add_fix -->
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
</html>
<?php }else{
	header("location:".$defaultURL);
} ?>