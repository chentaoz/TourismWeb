<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $meta; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <?php echo $title; ?>
    <?php echo $keywords; ?>
    <?php echo $description; ?>
    <!--    --><?php //echo $css; ?>
    <!-- Bootstrap core CSS -->
    <link href="<?= WWW_domian ?>css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Custom styles for this template -->
    <link href="<?= WWW_domian ?>css/carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= WWW_domian ?>css/common.css">
    <link rel="stylesheet" href="<?= WWW_domian ?>css/master.css">
    <style>
        @media (max-width: 980px) {
            .footer {
                display: block;
            }
        }
        #navbar.in a {
            color: #F7F6F6;
        }
        .error{color: red !important;}
        .highlight1 {
            background: #e0f1df;
            opacity: 0.9;
            filter: Alpha(opacity=90); /* IE8 and earlier */
        }
        #input-group-search{
            position: absolute;
        }
        .tip_schlay1 {
            position: relative;
            z-index: 99;
            border: 1px solid #c0c0c0;
            background: #fff;
        }
        .tip_schlay1 ul {
            width: 100%;
            overflow: hidden;
        }
        .tip_schlay1 li {
            width: 100%;
            overflow: hidden;
            border-bottom: 1px solid #ececec;
        }
        .tip_schlay1 li a {
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
    <?php echo $js; ?>
    <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
</head>
<body style="background-color: #F0F0F0;">
<div class="homepage">
    <div class="navbar-wrapper" style="background: #548F1E!important;">
        <div class="container">
            <nav class="navbar navbar-inverse navbar-static-top" style="background-color: transparent!important;">
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
                            <!--                            <li><a href="--><?//= WWW_domian ?><!--bag">背包</a></li>-->
                            <!--                            <li><a href="--><?//= WWW_domian ?><!--guide">攻略</a></li>-->
                            <!--                            <li><a href="--><?//= BBS_domian ?><!--" target="_blank">社区</a></li>-->
                        </ul>
                    </div>
                    <div class="col-lg-6 top-search">
                        <div class="input-group" id="input-group-search">
                            <form method="post" autocomplete="off" action="<?=BBS_domian?>search.php?mod=forum"
                                  target="_blank" onsubmit="return check_key()">
                                <input type="text" id="scform_srchtxt"  name="srchtxt" class="form-control" placeholder="搜索目的地">
                                <input type="submit" class="r top_sub" value=""/>
                                <div class="clear"></div><input type="hidden" name="searchsubmit" value="yes">
                            </form>
                            <div id="head_tipsList" class="tip_indschlay1 tip_schlay1" style="display: none; position:absolute">
                            </div>
                        </div><!-- /input-group -->
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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=WWW_domian?>css/map.css">

<div class="fluid-row">
    <div class="col-md-12" id="map-col">
        <div id="map" class="map" oncontextmenu="return false"></div>
    </div>
</div>
<div id="map-menu">
    <div class="box">
        <div class="row">
            <div class="col-md-12">
                <form id="form-map-filter">
                    <button class="btn btn-default btn-block"
                            id="map-menu-btn"
                            type="button"
                            data-toggle="collapse"
                            data-target="#map-menu-content"
                            aria-expanded="false"
                            aria-controls="map-menu-content">
                        <i class="fa fa-caret-square-o-up"></i>
                        收起
                    </button>
                    <div class="collapse in" id="map-menu-content">
                        <div class="box">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">运动类型</a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <ul id="ul-filter-poi">
                                                <?php foreach($sport_cate as $cate):?>
                                                    <li onclick="filterPOIBySport(this, <?php echo $cate['spid'] ?>)">
                                                        <img src="//www.gowildkid.com/upload/sports_icon/<?php echo $cate['img'] ?>" />
                                                        <input type="checkbox" style="display: none;" name="filter_sports[]" value="<?php echo $cate['spid'] ?>" />
                                                        <?php echo $cate['name'] ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">POI类型</a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse in">
                                        <div class="panel-body" style="padding: 10px!important;">
                                            <ul id="ul-filter-activity">
                                                <li onclick="filterPOIByPoiType(this,'activity')" disabled>
                                                    <i class="fa fa-2x fa-pied-piper-alt"></i>
                                                    <input type="checkbox" style="display: none;" name="filter_poi[]" value="activity" />
                                                    活动
                                                </li>
                                                <li onclick="filterPOIByPoiType(this,'destination')">
                                                    <i class="fa fa-2x fa-map-marker"></i>
                                                    <input type="checkbox" style="display: none;" name="filter_poi[]" value="destination" />
                                                    目的地
                                                </li>
                                                <li onclick="filterPOIByPoiType(this,'national_park')">
                                                    <i class="fa fa-2x fa-tree"></i>
                                                    <input type="checkbox" style="display: none;" name="filter_poi[]" value="national_park" />
                                                    国家公园
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
<?php
// $this->load->view('foot_v1');
?>
<style type="text/css">
    .contact-widget {
        position: fixed;
        right: 20px;
        bottom: 155px;
        width: 80px;
        height: 150px;
        text-align: center;
        border-radius: 2px;
    }
    .contact-widget .widget-item:first-child, .backtotop .widget-item:first-child {
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
    }
    .contact-widget .widget-item {
        text-align: center;
        position: relative;
        display: block;
        cursor: pointer;
        background-color: rgba(0,0,0,0.5);
        width: 100%;
        height: 50px;
        padding: 8px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .contact-widget .widget-item .widget-qrcode, .backtotop .widget-item .widget-qrcode, .contact-widget .widget-item .widget-tel, .backtotop .widget-item .widget-tel {
        position: absolute;
        display: none;
        right: 80px;
        bottom: 0;
    }
    .contact-widget .widget-item .widget-tel img, .backtotop .widget-item .widget-tel img {
        width: auto;
        height: 50px;
    }
</style>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>

<script src="<?=WWW_domian?>js/jquery.cookie.js"></script>
<script src="<?=WWW_domian?>js/typeahead.js"></script>
<script src="<?=WWW_domian?>js/map.js"></script>
</body>
</html>
