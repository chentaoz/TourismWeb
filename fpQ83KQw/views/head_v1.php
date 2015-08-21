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
    <div class="navbar-wrapper">
        <div class="container">
            <nav class="navbar navbar-inverse navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?= WWW_domian ?>"><img src="<?= WWW_domian ?>images/logo/latest.png"
                                                                              alt="" style="height: 36px;margin-top:6px;"></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse l">
                        <ul class="nav navbar-nav">
                            <li><a href="<?= base_url() ?>place">目的地</a></li>
                            <li><a href="<?= base_url()?>sport">部落</a></li>
<!--                            <li><a href="--><?//= WWW_domian ?><!--bag">背包</a></li>-->
<!--                            <li><a href="--><?//= WWW_domian ?><!--guide">攻略</a></li>-->
<!--                            <li><a href="--><?//= BBS_domian ?><!--" target="_blank">社区</a></li>-->
                        </ul>
                    </div>
                    <div class="col-lg-6 top-search">
                        <div class="input-group" id="input-group-search">
                            <form method="post" autocomplete="off" action="<?=BBS_domian?>search.php?mod=forum"
                                  target="_blank" onsubmit="return check_key()">
                                <input type="text" id="scform_srchtxt" name="srchtxt" class="form-control" placeholder="搜索目的地/用户/宝典">
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
                                        <!--                                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
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