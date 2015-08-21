<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $meta; ?>
    <?php echo $title; ?>
    <?php echo $keywords; ?>
    <?php echo $description; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <!-- Bootstrap core CSS -->
    <link href="<?=WWW_domian?>css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=WWW_domian?>css/buttons.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Custom styles for this template -->
    <link href="<?=WWW_domian?>css/carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=WWW_domian?>css/common.css">
    <link rel="stylesheet" href="<?=WWW_domian?>css/login.css">
    <link rel="stylesheet" href="<?=WWW_domian?>css/validate.css" type="text/css" />
    <style type="text/css">
        .error{color: red !important;}
    </style>
    <script type="text/javascript" src="<?=WWW_domian?>js/jquery-1.9.1.min.js"></script>
</head>
<body>
<!--common top-->
<div class="common_topbg">
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
                        <a class="navbar-brand" href="<?=WWW_domian?>"><img src="<?=WWW_domian?>images/ologo.png" alt=""></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse l">
                        <ul class="nav navbar-nav">
                            <li><a href="<?=WWW_domian?>place">目的地</a></li>
                            <li><a href="<?=WWW_domian?>sport">部落</a></li>
<!--                            <li><a href="--><?//=WWW_domian?><!--bag">背包</a></li>-->
<!--                            <li><a href="--><?//=WWW_domian?><!--guide">攻略</a></li>-->
<!--                            <li><a href="--><?//=BBS_domian?><!--" target="_blank">社区</a></li>-->
                        </ul>
                    </div>
                    <div class="common_in r">
                        <?php if(isset($user)&&$user!=null){ ?>
                            <ul class="nav nav-tabs" style="display:none;">
                                <li role="presentation" class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="<?=WWW_domian?>" role="button" aria-expanded="false">
                                        <?php echo $user['username'] ?><span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li ><a class="me" href="<?=WWW_domian?>user">我的首页</a></li>
                                        <li><a  class="me_guid" href="<?=WWW_domian?>forum/guide">我的技术</a></li>
                                        <li ><a class="me_travel"href="<?=WWW_domian?>forum/travel">我的游记</a></li>
                                        <li ><a class="me_post" href="<?=WWW_domian?>forum/post">我的贴子</a></li>
                                        <li ><a class="me_bag" href="<?=WWW_domian?>user/bag">我的背包</a></li>
                                        <li ><a class="me_photo" href="<?=WWW_domian?>user/photo">我的照片</a></li>
                                        <li ><a class="me_spoor" href="<?=WWW_domian?>user/spoor">我的足迹</a></li>
                                        <li ><a class="me_set" href="<?=WWW_domian?>user/person_info">个人设置</a></li>
                                        <li ><a class="me_logout" href="<?=base_url()?>oauth/logout">退出</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php }else{?>
                        <ul class="nav nav-tabs" >
                            <li role="presentation" class="dropdown">
                                <a href="<?=base_url()?>oauth/login">
                                    登录
                                </a><span>|</span>
                            </li>
                            <li >
                                <a href="<?=base_url()?>oauth/register">注册</a>
                            </li>
                        </ul>
                        <?php }?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!--top-->