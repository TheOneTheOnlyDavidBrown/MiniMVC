<script>

	var calculator = new base.calculator({
		site_name: '<?php site_name(); ?>'
	});
	
</script>

<?php for($i=0;$i<10;$i++):?>
	<input type='button' value='<?php echo $i?>' />
<?php endfor;?>

<div id="numone"></div>
<div id="numtwo"></div>
<div id="sum"></div>