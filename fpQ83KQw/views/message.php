<?php $this->load->view('head'); ?>
<?php $this->load->view('head_other'); ?>
<style type="text/css">
	#message{ text-align: center;color: #555;font-size: 14px;padding-bottom: 30px;}
	#message img {margin-top: 60px;}
	#message h5 {font-size: 18px; font-weight: bold;line-height: 60px;margin-top: 30px; }
	#message a{padding-right: 24px; background: url("<?=WWW_domian;?>images/mmore.jpg") right center no-repeat;}
</style>
<div class="wp pos_relative">
	<div id="message">
		<?php if($success){ ?>
			<img src="<?=WWW_domian;?>images/yes.png">
		<?php }else{ ?>
			<img src="<?=WWW_domian;?>images/no.png">
		<?php } ?>
		<h5><?php echo $content; ?></h5>
		<?php echo $delay_time; ?> <?php echo $lang['auto_redirect']; ?>，
		<?php echo anchor($target_url, $lang['no_waiting']);?>
	</div>
</div>
<br/><br/><br/>
<script type="text/javascript">
	setTimeout(function() {
		window.location = "<?php echo get_url($target_url); ?>";
	}, <?php echo ($delay_time * 1000); ?>);
</script>
<?php $this->load->view('foot'); ?>
<?php echo $script; ?>
</body>
</html>
<?php
die();
?>