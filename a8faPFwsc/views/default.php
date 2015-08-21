<script type="text/javascript">
$(document).ready(function() {
	$('.area-l').height($(window).height()-85);
	$('#main').height($(window).height()-85);
	$(window).bind('resize',function(){
		$('.area-l').height($(window).height()-85);
		$('#main').height($(window).height()-85);
	});
	$('.nav li').click(function(){
		$(this).siblings().removeClass('focus');
		$(this).addClass('focus');
		$('#J-sidemenu').html($(this).find('ul').html());
		$('#J-sidemenu li:first').addClass('focus');
		$('#J-sidemenu li').click(function(){
			$(this).siblings().removeClass('focus');
			$(this).addClass('focus');
		});
	});
	
	$('#J-showmenu').toggle(function(){
		$('.area-l').fadeOut(function(){
				$('.area-r').animate({marginLeft:0});
			});
	},function(){
			$('.area-r').animate({marginLeft:'160px'},function(){
					$('.area-l').fadeIn();
				});
		});
});
</script>
</head>
<body>
<div class="wraper fn-clear">
  <div class="area-top">
    <div class="fn-left">
      <h1 class="logopanel"><a href="">Control Pannel</a></h1>
      <div class="datewidget"><?php echo $lang['sys_today']; ?>：<?php echo $date; ?></div>
    </div>
    <div class="system-panel"> <a href="javascript:void(0);" id="J-showmenu"></a>
      <div class="welcome">Hi,&nbsp;&nbsp;<?php echo $username; ?>&nbsp;<?php echo anchor(site_url($logouturl),$lang['sys_loginout']); ?>&nbsp;&nbsp;<?php echo anchor(base_url('../'),$lang['sys_homepage'],array('target'=>'_blank'));?></div>
      <div class="nav">
        <ul>
          <li class="focus"><a href="<?php echo site_url('welcome/home'); ?>" target="content"><?php echo $lang['sys_home']; ?></a>
            <ul>
              <li class="focus"><a href="<?php echo site_url('welcome/home'); ?>"><?php echo $lang['sys_admin_homepage']; ?></a></li>
            </ul>
          </li>
          <?php
    foreach ($menu as $k=>$v){
    ?>
          <li><a href="<?php if(count($v['menu'])!=0){echo site_url($v['menu'][0]['sourceMod']);}else{ echo '#';} ?>" target="content"><?php echo $v['name']; ?></a>
            <ul>
              <?php
      if(count($v['menu'])!=0){
	  foreach ($v['menu'] as $r){
    ?>
              <li><a href="<?php echo site_url($r['sourceMod']); ?>" target="content"><?php echo $r['name']; ?></a></li>
              <?php
      }
	  }
        ?>
            </ul>
          </li>
          <?php
    }
      ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="area-l">
    <ul id="J-sidemenu">
      <li class="focus"><a href="<?php echo site_url('welcome/home'); ?>" target="content"><?php echo $lang['sys_admin_homepage']; ?></a></li>
    </ul>
    <div class="copyright">Powered by <?php echo $this->config->item('version');?></div>
  </div>
  <div class="area-r">
    <div id="main">
      <iframe name="content" id="content" frameborder="0" scrolling="auto" src="<?php echo site_url('welcome/home'); ?>" style="width:100%; height:100%;"></iframe>
    </div>
  </div>
</div>