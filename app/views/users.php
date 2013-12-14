<script>
	var mypage = new base.myfn({
		AAAAA: 'my var',
		BBBBB: 'my b var',
		cool: 'my cool var in the view',
		site_name: '<?php site_name(); ?>',
});
</script>

<div id="users">
	<h3><?php site_name(); ?></h3>
	<?php foreach($users as $user):?>
	<div class='links'><?php a(''.base_url().''.$user['age'], $user['name']);?></div>
	<?php endforeach;?>
</div>