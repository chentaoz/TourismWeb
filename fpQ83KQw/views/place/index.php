<?php $this->load->view('head_other_v1', array('currentTab' => 1)); ?>
<style type="text/css">
    .tip_schlay {
        position: relative;
        z-index: 99;
        border: 1px solid #c0c0c0;
        background: #fff;
    }
    .tip_schlay ul {
        width: 100%;
        overflow: hidden;
    }
    .tip_schlay li {
        width: 100%;
        overflow: hidden;
        border-bottom: 1px solid #ececec;
    }
		.highlight {
        background: #e0f1df;
    }
    
    .tip_schlay li a {
        display: block;
        height: 32px;
        overflow: hidden;
        padding: 0 10px;
        line-height: 32px;
        color: #323232;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

</style>
  <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
 <script src="<?=WWW_domian?>js/jquery-address-pick/dist/locationpicker.jquery.min.js"></script>
 <script>	 
 function resizeIframe(obj) {
			obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
			console.log("obj.style.height:",obj.style.height);
		};
</script>
<!--main-->
<div class="place">
    <div class="destination_bg" style="background-image: url(<?= base_url() . $this->config->item('upload_ad') . '/' . $back['img'] ?>);">
        <div class="destin_ser">
            <div class="destin_ser_ad">你好，世界！</div>
            <div class="destin_form">
                <div class="destin_ser_input" id="destin_ser_input">
                    <form target="_blank" onsubmit="return false;">
                        <input type="text" id="search-box" placeholder="搜索国家、城市、目的地" class="destin_input l"
                               autocomplete="off"/>
                        <input type="button" id="search-btn" value="" class="desti_sersub l"/>
                        <div class="clear"></div>
                    </form>
                    <div id="tipsList" class="tip_indschlay tip_schlay" style="display: none;">
                    </div>
                </div>
                <div class="destin_ser_hot">热门城市：<a href="#">成都</a><a href="#">香港</a>&nbsp; &nbsp; <a href="#myModal_add_pl" role="button" data-toggle="modal">添加目的地</a></div>
			
            </div>
        </div>
    </div>
	<div class="modal fade" id="myModal_add_pl" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">
											<span aria-hidden="true" >&times;</span>
										</button>
									
										<h4 class="modal-title" >添加目的地</h4>
									</div>
									<div class="modal-body" id="modal-body">
									<iframe src="<?=WWW_domian?>place/addressverify" style="height: 100%; width: 100%" frameBorder="0" seamless width="700px"   seamless onload='resizeIframe(this)' ></iframe>
									</div>
									<div class="modal-footer">
										<input type="hidden" id="add_sport_com_value" >
											<input type="hidden" id="add_sport_com_name" >
							
									</div>
								</div>
							</div>
						</div>
    <div class="wp">
        <div class="destination">
            <div role="tabpanel">
                <div class="tab-title"><span>精彩世界</span></div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php if($ad){
                        foreach($ad as $k=>$v){?>
                            <li role="presentation" <?php if($k==0){ echo 'class="active"';}?>><a href="#tab_ad_<?=$k?>" role="tab" data-toggle="tab"><?=$v['name']?></a></li>
                        <?php }
                    }?>
                </ul>
                <div class="tab-title"><span>为您推荐</span></div>
                <!-- Tab panes -->
                <div class="tab-content">
                    <?php if($ad){
                        foreach($ad as $k=>$v){?>
                            <div role="tabpanel" class="tab-pane<?php if($k==0){ echo ' active';}?>" id="tab_ad_<?=$k?>">
                                <?php if ($v['advis']) {?>
                                <ul class="destin_imgs">
                                    <?php foreach ($v['advis'] as $j => $i) {?>
                                        <li class="no_margin_right">
                                            <a href="<?=$i['weblink']?>" target="_blank">
                                                <img src="<?= base_url() . $this->config->item('upload_ad') . '/' . $i['img'] ?>">
                                            </a>
                                            <span class="destin_imgs_title"><a href="<?=$i['weblink']?>" target="_blank"><?=$i['title']?></a></span>
                                        </li>
                                    <?php }?>
                                    <div class="clear"></div>
                                </ul>
                                <?php }?>
                            </div>
                        <?php }
                    }?>
                </div>
            </div>
        </div>
        <div class="continent">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php if ($place_parent) {
                        foreach ($place_parent as $k => $v) {
                            ?>
                            <li role="presentation" <?php if($k==0){ echo 'class="active"';}?>>
                                <a href="#tab_area_<?=$k?>" role="tab" data-toggle="tab"><?=$v['name']; ?></a>
                            </li>
                        <?php
                        }
                    }?>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <?php if ($place_parent) {
                        foreach ($place_parent as $k => $v) {?>
                            <div role="tabpanel" class="tab-pane<?php if($k==0){ echo ' active';}?>" id="tab_area_<?=$k?>">
                                <div class="destin_area_con">
                                    <div class="now_area"><span><?php echo $v['name']; ?> <?php echo $v['name_en']; ?></span></div>
                                    <?php if ($v['child']) {
                                        foreach ($v['child'] as $j => $i) { ?>
                                            <div class="destin_areas">
                                                <a href="<?= base_url('place/index/pid/' . $i['pid']); ?>"><?php echo $i['name']; ?> <?php echo $i['name_en']; ?></a>
                                                <?php if ($i['hot'] == 0) { ?><span class="hot_area">热门</span><?php } ?>
                                            </div>
                                        <?php }
                                    }?>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        <?php
                        }
                    }?>
                </div>
            </div>

            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">

                </ul>
                <!-- Tab panes -->
                <div class="tab-content">

                </div>
            </div>
        </div>
    </div>
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
    <script>
	
	$('#us3').locationpicker({
        radius: 0,
        inputBinding: {
            latitudeInput: $('#us3-lat'),
            longitudeInput: $('#us3-lon'),
            radiusInput: $('#us3-radius'),
            locationNameInput: $('#us3-address')
        },
        enableAutocomplete: true,
        onchanged: function (currentLocation, radius, isMarkerDropped) {
		alert(1);
            // Uncomment line below to show alert on each Location Changed event
            //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
        }
    });</script>
</body>
</html>
