<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $meta; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="HandheldFriendly" content="true">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <?php echo $title; ?>
    <?php echo $keywords; ?>
    <?php echo $description; ?>
    <?php //echo $css; ?>
    <!-- Bootstrap core CSS -->
    <link href="<?= WWW_domian ?>css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.min.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
    <!-- Custom styles for this template -->
    <link href="<?= WWW_domian ?>css/carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= WWW_domian ?>css/common.css">
    <link rel="stylesheet" href="<?= WWW_domian ?>css/master.css">
    <link rel="stylesheet" href="/lib/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=WWW_domian?>css/map.css">
    <link rel="stylesheet" href="<?=WWW_domian?>css/map-pin.css">
    <link rel="stylesheet" href="<?=WWW_domian?>icomoon/gwk-icon.css">
    <link rel="stylesheet" href="<?=WWW_domian?>assets/raty/lib/jquery.raty.css">
    <?php echo $js; ?>
    <?php if(false): ?>
        <script type="text/javascript" src="http://dev.ditu.live.com/mapcontrol/mapcontrol.ashx?v=7.0"></script>
    <?php endif; ?>
    <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0&mkt=ngt"></script>

</head>
<body style="background-color: #F0F0F0;">
<div class="homepage hidden-sm hidden-xs">
    <div class="navbar-wrapper" style="background: #548F1E!important;">
        <div class="container">
            <nav class="navbar navbar-inverse navbar-static-top" style="background-color: #548F1E!important;">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?= WWW_domian ?>"><img src="<?= WWW_domian ?>images/logo/latest.png"
                                                                              alt="" ></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse l">
                        <ul class="nav navbar-nav">
                            <li><a href="<?= base_url() ?>place" style="color: #fff!important;">目的地</a></li>
                            <li><a href="<?= base_url()?>sport" style="color: #fff!important;">部落</a></li>
                            <li><a href="//activity.gowildkid.com" style="color: #fff!important;">活动</a></li>
                            <li><a href="//daren.gowildkid.com" style="color: #fff!important;">达人</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 top-search">

                    </div><!-- /.col-lg-6 -->
                    <div class="common_in r">
                        <?php if(isset($user)&&$user!=null){ ?>
                            <ul class="nav nav-tabs">
                                <li role="presentation" class="dropdown">
                                    <a data-toggle="dropdown" href="<?=WWW_domian?>user" role="button" aria-expanded="false">
                                        <?php echo $user['username'] ?> <span class="caret"></span>
                                    </a>
                                    <img class="smile" src="<?=base_url()?>images/xiaolian.png" alt="">
                                    <ul class="dropdown-menu" role="menu">
                                        <li ><a class="me" href="<?=WWW_domian?>user">我的首页</a></li>
                                        <li><a  class="me_guid" href="<?=WWW_domian?>forum/guide">我的技术</a></li>
                                        <li ><a class="me_travel"href="<?=WWW_domian?>forum/travel">我的游记</a></li>
                                        <li ><a class="me_post" href="<?=WWW_domian?>forum/post">我的贴子</a></li>
                                        <li ><a class="me_bag" href="<?=WWW_domian?>user/bag">我的背包</a></li>
                                        <li ><a class="me_photo" href="<?=WWW_domian?>user/photo">我的照片</a></li>
                                        <li ><a class="me_spoor" href="<?=WWW_domian?>user/spoor">我的足迹</a></li>
                                        <li ><a class="me_set" href="<?=WWW_domian?>user/person_info">个人设置</a></li>
                                        <li ><a class="me_logout" href="<?=PASSPORT_domian?>oauth/logout">退出</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php }else{?>
                            <ul class="nav nav-tabs">
                                <li role="presentation" class="dropdown">
                                    <a href="<?=PASSPORT_domian?>oauth/login">
                                        登录
                                    </a><span>|</span>
                                </li>
                                <li>
                                    <a href="<?=PASSPORT_domian?>oauth/register">注册</a>
                                    <img class="smile" src="<?=base_url()?>images/xiaolian.png" alt="">

                                </li>
                            </ul>
                        <?php }?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="fluid-row">
    <div class="col-md-12 col-sm-12 col-xs-12" id="map-col">
        <div id="map" ></div>
    </div>
</div>
<div id="map-menu-sys">
    <div class="box">
        <div class="row">
            <div class="col-md-12">
                <form id="form-map-opts-sys" onsubmit="javascript:return false;">
                    <ul class="ul-opts-sys">
                        <li data-container="body" data-toggle="popover" data-placement="left" data-content='<i onclick="javascript:try{_ctrl.map.setView({mapTypeId:Microsoft.Maps.MapTypeId.birdseye});} catch(e) {alert(e);}" class="fa fa-2x fa-globe fc-main"></i><hr style="margin:0!important;" /><i onclick="javascript:try {_ctrl.map.setView({mapTypeId:Microsoft.Maps.MapTypeId.road});}catch(e){alert(e);}" class="fa fa-2x fa-road fc-main"></i>'>
                            <input type="hidden" name="state-map-birdseye" id="state-map-birdseye" class="ctr-btn-state" value="0" />
                            <i class="fa fa-2x fa-globe"></i>
                        </li>
                        <li onclick="javascript:try{ _ctrl.helper.setUserLocCenter(); } catch(e) {alert(e); }" title="定位">
                            <i class="fa fa-2x fa-location-arrow"></i>
                        </li>
                        <li class="hide" onclick="javascript:try{$('#map-menu-content').collapse('hide');}catch(e){alert(e);}"  title="关闭筛选器">
                            <i class="fa fa-2x fa-times"></i>
                        </li>
                        <li>
                            <i class="fa fa-2x fa-plus" onclick="javascript:try{_ctrl.map.setView({zoom:_ctrl.map.getZoom() + 1});}catch(e){alert(e);}"></i>
                            <hr style="margin:0!important;" />
                            <i class="fa fa-2x fa-minus" onclick="javascript:try{_ctrl.map.setView({zoom:_ctrl.map.getZoom() - 1});}catch(e){alert(e);}"></i>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<div id="map-menu">
    <div class="box">
        <div class="row">
            <div class="col-md-12">
                <form id="form-map-filter" onsubmit="javascript:return false;">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" disabled>
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                        <input type="text" id="ipt-typeahead-dest" onkeyup="javascript:_ctrl.deprecated.searchDest(this)" class="form-control typeahead" placeholder="目的地，地址，活动等">
                    </div>

                    <div class="collapse in" id="map-menu-content" style="margin-top:6px;">
                        <div class="box">
                            <div id="menu-btn-ctn" class="container">
                                <div class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-4 col-xs-4" id="menu-btn-np">
                                            <i onclick="javascript:_ctrl.toggle.togglePoiPanel ();" class="icon-gwk-btn-poi" title="景点和服务设施" data-toggle="tooltip" data-placement="bottom" ></i>
                                    </span>
                                    <span class="col-lg-4 col-md-4 col-sm-4 col-xs-4" id="menu-btn-dest">
                                            <i onclick="javascript:_ctrl.toggle.toggleDestPanel(this);" class="icon-gwk-btn-dest" title="目的地" data-toggle="tooltip" data-placement="bottom" ></i>
                                    </span>
                                    <span class="col-lg-4 col-md-4 col-sm-4 col-xs-4" id="menu-btn-activity">
                                            <i onclick="javascript:_ctrl.activity.pull();_ctrl.toggle.toggleActivityRcmdPanel();" class="icon-gwk-btn-activity" title="活动" data-toggle="tooltip" data-placement="bottom" ></i>
                                    </span>
                                </div>
                            </div>
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default hide">
                                    <div class="panel-body" style="">

                                        <ul class="ul-opts hide">
                                            <li onclick="javascript:_ctrl.toggle.toggleNationalParkData();" data-toggle="tooltip" data-placement="top" title="国家公园">
                                                <input type="hidden" name="state-national-park" id="state-national-park" class="ctr-btn-state" value="0" />
                                                <input type="hidden" name="toggleNP" id="toggleNP" value="0" />
                                                国家公园
                                            </li>
											<li onclick="javascript:_ctrl.toggle.toggleNationalOrg();" data-toggle="tooltip" data-placement="top" title="组织者">
                                                <input type="hidden" name="organizer" id="organizer" class="ctr-btn-state" value="0" />
                                                <input type="hidden" name="toggleOrg" id="toggleOrg" value="0" />
                                                国家公园
                                            </li>
                                            <li onclick="javascript:_ctrl.toggle.toggleDestPanel(this);" data-toggle="tooltip" data-placement="top" title="目的地">
                                                <input type="hidden" name="state-dest" id="state-dest" class="ctr-btn-state btn-to-toggle" value="0" />
                                                <i class="fa fa-2x fa-map-signs"></i>
                                            </li>
                                            <li onclick="javascript:_ctrl.activity.pull();_ctrl.toggle.toggleActivityRcmdPanel();" data-toggle="tooltip" data-placement="top" title="活动">
                                                <input type="hidden" name="state-activity" id="state-activity" class="ctr-btn-state" value="0" />
                                                <input type="hidden" name="toggleAct" id="toggleAct" value="0" />
                                                <i class="fa fa-2x fa-pied-piper-alt"></i>
                                            </li>
                                            <li onclick="javascript:_ctrl.toggle.toggleSearchPanel(this);" data-toggle="tooltip" data-placement="top" title="搜索">
                                                <input type="hidden" name="state-search" id="state-search" class="ctr-btn-state btn-to-toggle" value="0" />
                                                <i class="fa fa-2x fa-search-plus"></i>
                                            </li>
                                            <?php if(isset($user)&&$user!=null): ?>
                                                <li class="hidden-lg hidden-md" onclick="javascript:location.href='http://www.gowildkid.com/user'" data-toggle="tooltip" data-placement="top" title="用户中心">
                                                    <input type="hidden" name="state-user-center" id="state-user-center" class="ctr-btn-state" value="0" />
                                                    <i class="fa fa-2x fa-tachometer"></i>
                                                </li>
                                            <?php else: ?>
                                                <li class="hidden-lg hidden-md" onclick="javascript:location.href='http://passport.gowildkid.com/oauth/login'" data-toggle="tooltip" data-placement="top" title="登陆">
                                                    <input type="hidden" name="state-login" id="state-login" class="ctr-btn-state" value="0" />
                                                    <i class="fa fa-2x fa-sign-in"></i>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel panel-default panel-to-toggle" id="panel-dests" style="display: none;">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#panel-content-dest">运动类型</a>
                                        </h4>
                                    </div>
                                    <div id="panel-content-dest" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <ul id="ul-filter-poi">
                                                <?php if (0): ?>
                                                    <?php foreach($sport_cate as $cate):?>
                                                        <li onclick="javascript:_ctrl.deprecated.pullDestData(this)">
                                                            <span class="gwk-pin-dest-<?php echo $cate['spid'] ?>"> </span>
                                                            <input type="checkbox" style="display: none;" name="filter_sports[]" value="<?php echo $cate['spid'] ?>" />
                                                            <br />
                                                            <span class="gwk-dest-title"><?php echo $cate['name'] ?></span>
                                                        </li>
                                                    <?php endforeach; ?>

                                                    <li onclick="javascript:_ctrl.deprecated.pullDestData(this)">
                                                        <span class="gwk-pin-dest-all"> </span>
                                                        <input type="checkbox" style="display: none;" name="filter_sports[]" value="all" />
                                                        <br />
                                                        全部
                                                    </li>
                                                <?php endif; ?>

                                                <li onclick="javascript:_ctrl.toggle.togglePOIData('ski_resort', this);">
                                                    <input type="hidden" value="0" class="togglePoiState" />
                                                    <span class="gwk-pin-dest-ski"> </span>
                                                    <h5>滑雪场</h5>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default panel-to-toggle" id="panel-act-recmd" style="margin-top: 6px;">
                                    <div id="panel-content-act-recmd" class="panel-collapse collapse in">
                                        <div class="panel-body" >
                                            <ul id="list-group-act-recmd">
												
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default panel-to-toggle" id="panel-pois" style="display: none;">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#panel-content-poi">景点和服务设施</a>
                                        </h4>
                                    </div>
                                    <div id="panel-content-poi" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <ul id="ul-poi">
                                                <li onclick="javascript:_ctrl.toggle.toggleNationalParkData();">
                                                    <input type="hidden" value="0" class="togglePoiState" />
                                                    <span class="gwk-pin-dest-national-park" ></span>
                                                    <h5>国家公园</h5>
                                                </li>
												<li onclick="javascript:_ctrl.toggle.togglePOIData('org', this);">
													<input type="hidden" value="0" class="togglePoiState" />
                                                    <span class="gwk-pin-dest-org"> </span>
                                                    <h5>组织者</h5>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-poi" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" style="padding: 0!important;">
                <div class="container-fluid" id="modal-poi-ctn" style="overflow-y: hidden;">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
// $this->load->view('foot_v1');
?>
<style type="text/css">

</style>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>

<script src="<?=WWW_domian?>js/jquery.cookie.js"></script>
<script src="<?=WWW_domian?>assets/raty/lib/jquery.raty.js"></script>
<script src="<?=WWW_domian?>js/bootstrap3.typeahead.js"></script>
<script src="<?=WWW_domian?>js/jquery.base64.js"></script>
<script src="<?=WWW_domian?>js/Modernizr.js"></script>
<script src="<?=WWW_domian?>js/imagesloaded.pkgd.min.js"></script>
<script src="<?=WWW_domian?>js/map.js"></script>
<script type="text/javascript">
    _ctrl = GwkMapController;
</script>
</body>
</html>