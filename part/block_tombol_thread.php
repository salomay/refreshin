<?php if($_SESSION[member][id]!=""){ ?>
	<a class="add_plan" href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/articles/" ?>">ADD NEW ARTIKEL</a>
	<a class="ad_new_trip" href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/trips/" ?>">CREATE NEW TRIP</a>
	<a class="gt_prm" href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/sells/" ?>">START SELLING</a>
<?php } ?>