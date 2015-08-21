<?php $this->load->view('head_other_v1', array('currentTab' => 1)); ?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/place.css">
<style>
    .nav>li>a {
        position: relative;
        display: block;
        padding: 10px 15px;
    }
    .table > tbody > tr > th{
        border-top: 0px solid rgba(221, 221, 221, 0);
    }
    .table > tbody > tr > td{
        border-top: 0px solid rgba(221, 221, 221, 0);
    }
    .desti_show_ch{
        height: auto !important;

    }
    .table{
        margin-bottom: 0px;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
        color: #555;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    .nav-tabs {
        border-bottom: 1px solid #ddd;
    }
    .nav-tabs > li > a{
         border: 0px solid #CDCCCC;
         border-bottom: 0px solid #CDCCCC;
    }
    .destin_show_txt {
        border-top: 1px solid #ddd;
    }
    .carousel .item {
        height: 100%;
     background-color: #ffffff;
    .carousel{
        height: 100% !important;
    }
    .breadcrumb {
        list-style: none;
        overflow: hidden;
        font: 18px Helvetica, Arial, Sans-Serif;
    }
    .breadcrumb li {
        float: left;
    }
    .breadcrumb li a {
        color: white;
        text-decoration: none;
        padding: 10px 0 10px 65px;
        /*background: brown;                   *//* fallback color */
        /*background: hsla(34,85%,35%,1);*/
        position: relative;
        display: block;
        float: left;
    }
    .breadcrumb li a:after {
        content: " ";
        display: block;
        width: 0;
        height: 0;
        border-top: 50px solid transparent;           /* Go big on the size, and let overflow hide */
        border-bottom: 50px solid transparent;
        /*border-left: 30px solid hsla(34,85%,35%,1);*/
        position: absolute;
        top: 50%;
        margin-top: -50px;
        left: 100%;
        z-index: 2;
    }
    .breadcrumb li a:before {
        content: " ";
        display: block;
        width: 0;
        height: 0;
        border-top: 50px solid transparent;
        border-bottom: 50px solid transparent;
        border-left: 30px solid white;
        position: absolute;
        top: 50%;
        margin-top: -50px;
        margin-left: 1px;
        left: 100%;
        z-index: 1;
    }
    .breadcrumb li:first-child a {
        padding-left: 10px;
    }
    /*.breadcrumb li:nth-child(2) a       { background:        hsla(34,85%,45%,1); }*/
    /*.breadcrumb li:nth-child(2) a:after { border-left-color: hsla(34,85%,45%,1); }*/
    /*.breadcrumb li:nth-child(3) a       { background:        hsla(34,85%,55%,1); }*/
    /*.breadcrumb li:nth-child(3) a:after { border-left-color: hsla(34,85%,55%,1); }*/
    /*.breadcrumb li:nth-child(4) a       { background:        hsla(34,85%,65%,1); }*/
    /*.breadcrumb li:nth-child(4) a:after { border-left-color: hsla(34,85%,65%,1); }*/
    /*.breadcrumb li:nth-child(5) a       { background:        hsla(34,85%,75%,1); }*/
    /*.breadcrumb li:nth-child(5) a:after { border-left-color: hsla(34,85%,75%,1); }*/
    .breadcrumb li:last-child a {
        background: transparent !important;
        color: black;
        pointer-events: none;
        cursor: default;
    }
    /*.breadcrumb li a:hover { background: hsla(34,85%,25%,1); }*/
    /*.breadcrumb li a:hover:after { border-left-color: hsla(34,85%,25%,1) !important; }*/
</style>
<!--main-->

<?php

$counter=0;
$array_num=count($sport_attr);
$num_of_attr=[];
$sports=[];
$sports[$counter]=$sport_attr[0]["name"];
for($i=0;$i<$array_num;$i++) {
    if ($sports[$counter]==$sport_attr[$i]["name"]){
        $num_of_attr[$counter]++;
    }
    else{
        $found_flage=0;
        for($c=0;$c<$counter;$c++){
           if($sports[$c]==$sport_attr[$i]["name"]){
               $num_of_attr[$c]++;
               $found_flage=1;
           }
        }
        if($found_flage==0){
        $counter=$counter+1;
        $sports[$counter]=$sport_attr[$i]["name"];
        }
    }
}

?>


<div class="bg_f5">
    <div class="desti_title desti_detail">
        <div class="desti_route" style="margin: 0 auto;width: 1048px">
            <ol class="breadcrumb">
                <li><a href="<?=base_url()?>">野孩子</a></li>
                <li><a href="<?=base_url("place")?>">目的地</a></li>
                <?php foreach($top_parent as $k=>$v){
                    if($k>0){?>
                        <li><a href="<?php echo site_url('place/index/pid/'.$v[0])?>"><?=$v[1]?></a></li>
                    <?php }
                }?>
                <li class="active"><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name']?></a></li>
            </ol>
        </div>
        <div class="wp clear">
            <div class="l des_tit_wd col-md-6">

                <div style="height: 100%" class="desti_hd desti_en "><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name_en']?></a></div>
                <div style="height: 100%" class="desti_hd desti_ch "><a href="<?=site_url('/place/index/pid/'.$place['pid'])?>"><?=$place['name']?></a></div>
            </div>
            <div class="r des_tit_wd col-md-6" style="padding-bottom: 35px">
                <div class="desti_img" style="margin-top: 0px">
                    <?php  $blnShow = $visit && $visit['planto']==1; ?>
                    <span id="plan">
                        <a data-pid="<?=$place['pid']?>" data-type="plan" data-value="1" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'none':'' ?>;">
                            <img src="<?=base_url("images/des_ico1.png")?>">
                        </a>
                        <a data-pid="<?=$place['pid']?>" data-type="plan" data-value="0" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'':'none' ?>;">
                            <img src="<?=base_url("images/des_ico12.png")?>">
                        </a>
                    </span>
                    <?php  $blnShow = $visit && $visit['beento']==1; ?>
                    <span id="been">
                        <a data-pid="<?=$place['pid']?>" data-type="been" data-value="1" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'none':'' ?>;">
                            <img src="<?=base_url("images/des_ico2.png")?>">
                        </a>
                        <a data-pid="<?=$place['pid']?>" data-type="been" data-value="0" href="javascript:void(0);" onclick="return false;" style="display:<?php echo $blnShow?'':'none' ?>;">
                            <img src="<?=base_url("images/des_ico22.png")?>">
                        </a>
                    </span>

                </div>
                <div class="desti_all"><span><?php echo $sports_total; ?></span>个热门部落&nbsp; &nbsp;
                    <span><?php echo $been_total;?></span>人去过这里&nbsp; &nbsp;
                    <span><?php echo $comments_total;?></span>条目的地点评
                </div>
            </div>
        </div>
    </div>

    <div class="bg_f5">
        <div class="wp">
            <div class="desti_show clear">
                <div class="desti_show_l l">
                    <div class="desti_show_des">
                     
                            <iframe style="height: 100%; width: 100%" id="myiframe"
                                src="<?=(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/place/placedetailimg/'.$place["pid"]?>" frameBorder="0" seamless width="700px"  scrolling='no' seamless onload='javascript:resizeIframe(this)'></iframe>
                    
                        <div class="desti_show_info l" style="width: 100%">
<!--                            <div class="col-md-12" style="height: auto">-->
<!--                            <div class="desti_show_ch">--><?//= $place['name'] ?><!--</div>-->
<!--                            <div class="desti_show_en">--><?//= $place['name_en'] ?><!--</div>-->
<!--                                </div>-->
<!--                            <div class="col-md-5";>-->
<!--                                <div class="desti_start">-->
<!--                                    <span class="avg_score"></span>-->
<!--                                    <span style="font-size: 45px;color:green">--><?//=$avg?><!--</span>-->
<!--                                    <span style="color:green">分</span>-->
<!--                                </div>-->
<!--                                <div class="desti_nums col-md-12"><span>--><?php //echo $comments_total; ?><!--</span>条评论</div>-->
<!--                            </div>-->
<!--                            <div class="desti_wdp col-md-12" style="margin-top: 0px"><a href="#comment"><img src="--><?//= base_url('images/w_dp.png') ?><!--"></a></div>-->
                        </div>
						<div class="modal fade" id="myModal_add_sp" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">
											<span aria-hidden="true" >&times;</span>
										</button>
									
										<h4 class="modal-title">添加运动种类</h4>
									</div>
									<div class="modal-body col-md-12">
										  <div class="dropdown ">
											<button class="btn btn-success dropdown-toggle col-md-2" type="button" data-toggle="dropdown">
                                                <strong id="setfont">新增活动</strong><span class="caret"></span>
                                            </button>
                                              <ul class="breadcrumb col-md-6" style="margin-left: 15px">
                                                  <li>已有的活动：</li>
                                                  <li><a href="#" class="sub_event"><?=$sports[0]?></a></li>
                                                  <?php for($cnt=1;$cnt<=$counter;$cnt++) {
                                                      echo "<li><a class='sub_event' href='#'>";
                                                      echo $sports[$cnt];
                                                      echo "</a></li>";
                                                  }
                                                  ?>
                                              </ul>
											<ul class="dropdown-menu">
											<?php foreach($all_sp_li as $s_sp):?>
											<?php if(!in_array($s_sp["name"],$sports)):?>
											 <li><a class="add_s_link" favalue="<?=$s_sp["spid"]?>" faname="<?=$s_sp["name"]?>"><?=$s_sp["name"]?></a></li>
											 <?php endif;?>
											<?php endforeach;?>
											</ul>
											</div>
											<div class="box">
											<form id="addspform">
											</form>
											</div>
									</div>
									<div class="modal-footer">
										<input type="hidden" id="add_sport_com_value" >
											<input type="hidden" id="add_sport_com_name" >
										<button type="button" class="btn btn-success"  id="add_sport_com">确定</button>
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="modal fade" id="myModal_edit_attr" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">
											<span aria-hidden="true" >&times;</span>
										</button>
									
										<h4 class="modal-title">属性编辑</h4>
									</div>
									<div class="modal-body">
                                        <ul class="breadcrumb">
                                            <li data-target="#carousel-example-generic" data-slide-to="0" ><a href="#" style="color: #449d44" class="modal_nav active"><?=$sports[0]?></a></li>
                                            <?php for($cnt=1;$cnt<=$counter;$cnt++) {

                                                    echo "<li data-target='#carousel-example-generic' data-slide-to='$cnt'><a href='#' class='modal_nav'>";
                                                    echo $sports[$cnt];
                                                    echo "</a></li>";

                                            }
                                                ?>

                                        </ul>
										<form id="form_edit">
                                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="height: 100%">
                                                <div class="carousel-inner" role="listbox">
                                            <?php $sport_cnt =1?>

									    <table style="margin-left:20%;margin-right:20%" class="item active" id="attr_edit_table<?=$sport_cnt?>">

                                        <?php 
										$sp_arr=array();
										$rest_arr=array();
										$this_sport=null;
										foreach($sport_attr as $attr):
										if($this_sport==null):
										$this_sport=$attr['name'];?>
<!--										<center><h4>--><?//=$this_sport?><!--</h4></center>-->
<!--                                        <caption style="text-align: center" id="attr_edit_table_title--><?//=$sport_cnt?><!--">--><?//=$this_sport?><!--</caption>-->
                                        <tbody>
										<?php 
										$sp_arr[]=$attr['name'];
										endif;
										if($this_sport==$attr['name']):
										?>
										<tr>
											<td ><label> <?=$attr['attribute']?></label><br/>
                                                        <input class="form-control" type="text" name="<?=$attr['name']."_".$attr['attribute']?>" style="width:100%" value=" <?=$attr['value']?>"/></td>
                                        </tr>
										<?php
										else:
										$_this_flage=0;
										foreach($rest_arr as $ress):
											if($attr['name']==$ress):
													$_this_flage++;
											endif;
										endforeach;
										if($_this_flage==0){
											$sp_arr[]=$attr['name'];
											$rest_arr[]=$attr['name'];
                                        }
										endif;?>
										<?php endforeach;?>
                                            </tbody>
										</table>


										<?php if(count($rest_arr)>0):?>
											<?php foreach($rest_arr as $rest):?>
<!--											<center><h4>--><?//=$rest?><!--</h4></center>-->

                                                <?php $sport_cnt++;?>
											<table style="margin-left:20%;margin-right:20%" class="item" id="attr_edit_table<?=$sport_cnt?>">
<!--                                                <caption style="text-align: center" id="attr_edit_table_title--><?//=$sport_cnt?><!--">--><?//=$rest?><!--</caption>-->
                                                <tbody>
											<?php
												foreach($sport_attr as $attr):
													if($rest==$attr['name']):
											?>
											<tr>
                                                    <td ><label> <?=$attr['attribute']?></label><br/>
                                                                <input class="form-control" type="text" name="<?=$attr['name']."_".$attr['attribute']?>" style="width:100%" value=" <?=$attr['value']?>"/></td>
<!--												<td style="width:20%"><label> --><?//=$attr['attribute']?><!--<label></td>-->
<!--												<td style="width:80%"><input type="text" name="--><?//=$attr['name']."_".$attr['attribute']?><!--" style="width:100%" value=" --><?//=$attr['value']?><!--"/></td>											-->
											</tr>
											
                                                <?php
                                                endif;?>
                                                <?php endforeach;?>
                                                <tbody>
												</table>
											<?php endforeach?>
										<?php endif?>
                                                </div>
<!--                                                <a class="left carousel-control" style="background-image: linear-gradient(to right, rgba(0, 0, 0, .0001) 0%, rgba(0, 0, 0, .0001) 100%);"  href="#carousel-example-generic" role="button" data-slide="prev" style="background-color: #d3d3d3">-->
<!--                                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>-->
<!--                                                    <span class="sr-only">Previous</span>-->
<!--                                                </a>-->
<!--                                                <a class="right carousel-control" style="background-image: linear-gradient(to right, rgba(0, 0, 0, .0001) 0%, rgba(0, 0, 0, .0001) 100%);" href="#carousel-example-generic" role="button" data-slide="next" style="background-color: #d3d3d3">-->
<!--                                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>-->
<!--                                                    <span class="sr-only">Next</span>-->
<!--                                                </a>-->
                                            </div>

										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-success"  id="edit_com">确定</button>
									</div>
								</div>
							</div>
						</div>
                        <?php
                        echo "<ul class='nav nav-tabs' role='tablist' id='tabs'>";
                        $i=0;
                        if($array_num!=0) {
                            echo " <br/><li role='presentation' class='active'><a href='#$i' role='tab' data-toggle='tab' style='padding: 10px 15px;margin: 0 5px 0 0;'>$sports[$i]</a></li>";
                        }

                        for($i=1;$i<=$counter;$i++){
                            echo " <li role='presentation' ><a href='#$i'  role='tab' data-toggle='tab' style='padding: 10px 15px;margin: 0 5px 0 0;'>$sports[$i]</a></li>";
                        }
                        echo "</ul>";
                        echo "<div class='tab-content'>";
                        if($array_num==0) {
                            echo "<div class='panel panel-default' style='margin-top: 30px;'>
                              <div class='panel-body'>
                                现在这个景点还没有对应的运动
                              </div>
                            </div>";
                        }
                        if($array_num!=0) {
                            {
                                $i = 0;
                                echo "<div role='tabpanel' class='tab-pane active' id='$i'>";
                                echo "<table class='table   col-md-6' frame=void style='width: 50%'>

                            <tbody id='informcontent'>";
                                //<caption>$sports[$i]</caption>
                                $flagstatus = 0;
                                echo "<div>";
                                $order = 1;
                                for ($y = 0; $y < $array_num; $y++) {

                                    if ($order - 1 > $num_of_attr[$i] / 2) {
                                        break;
                                    }
                                    for ($x = 0; $x < $array_num; $x++) {
                                        $flagstatus = 0;
                                        if ($sport_attr[$x]["order"] == $order) {
                                            echo "<tr><th scope='row'>";
                                            echo $sport_attr[$x]["attribute"];
                                            echo "</th>";

                                            echo "<td>";
                                            echo $sport_attr[$x]["value"];
                                            echo "</td>";
                                            echo "</tr>";
                                            $order++;
                                            $flagstatus = 1;
                                            break;
                                        }
                                    }
                                }
                                if (($flagstatus = 0) && ($order != 1)) {
                                    echo "<p>以下序号不存在</p>";
                                    echo $order;
                                }
                                if (($flagstatus = 0) && ($order == 1)) {
                                    echo "<p>没有发现序号1</p>";
                                }
                                echo "</div>";

                                echo "</tbody>
                        </table>";

                                echo "<table class='table   col-md-6'  frame=void style='width:50%'>


                            <tbody id='informcontent'>";
//                                <caption style='visibility: hidden'>详细信息</caption>
                                echo "<div>";
                                for ($y = 0; $y < $array_num; $y++) {
                                    for ($x = 0; $x <= $array_num; $x++) {
                                        $flagstatus = 0;
                                        if ($sport_attr[$x]["order"] == $order) {
                                            echo "<tr><th scope='row'>";
                                            echo $sport_attr[$x]["attribute"];
                                            echo "</th>";

                                            echo "<td>";
                                            echo $sport_attr[$x]["value"];
                                            echo "</td>";
                                            echo "</tr>";
                                            $order++;
                                            $flagstatus = 1;
                                            break;
                                        }
                                    }
                                    if ($order > $num_of_attr[$i]) break;
                                }
                                if (($flagstatus = 0) && ($order != 1)) {
                                    echo "<p>以下序号不存在</p>";
                                    echo $order;
                                }
                                if (($flagstatus = 0) && ($order == 1)) {
                                    echo "<p>没有发现序号1</p>";
                                }
                                echo "</div>";
                                echo " </tbody>
                        </table>";
                                echo "</div>";
                            }
                            for ($i = 1; $i <= $counter; $i++) {

                                echo "<div role='tabpanel' class='tab-pane' id='$i'>";
                                echo "<table class='table   col-md-6' frame=void style='width: 50%'>

                            <tbody id='informcontent'>";
//                                <caption>$sports[$i]</caption>
                                $flagstatus = 0;
                                echo "<div>";
                                $order = 1;
                                for ($y = 0; $y < $array_num; $y++) {

                                    if ($order - 1 > $num_of_attr[$i] / 2) {
                                        break;
                                    }
                                    for ($x = 0; $x <= $array_num; $x++) {
                                        $flagstatus = 0;
//                                    echo $sports[$i],"and",$sport_attr[$x]["name"];
//                                    echo $sport_attr[$x]["order"],"and",$order;
                                        if (($sport_attr[$x]["order"] == $order) && ($sports[$i] == $sport_attr[$x]["name"])) {
                                            echo "<tr><th scope='row'>";
                                            echo $sport_attr[$x]["attribute"];
                                            echo "</th>";
                                            echo "<td>";
                                            echo $sport_attr[$x]["value"];
                                            echo "</td>";
                                            echo "</tr>";
                                            $order++;
                                            $flagstatus = 1;
                                            break;
                                        }
                                    }
                                }
                                if (($flagstatus = 0) && ($order != 1)) {
                                    echo "<p>以下序号不存在</p>";
                                    echo $order;
                                }
                                if (($flagstatus = 0) && ($order == 1)) {
                                    echo "<p>没有发现序号1</p>";
                                }
                                echo "</div>";
                                echo "</tbody>
                        </table>";

                                echo "<table class='table   col-md-6'  frame=void style='width:50%'>


                            <tbody id='informcontent'>";
//                                <caption style='visibility: hidden'>详细信息</caption>
                                echo "<div>";
                                for ($y = 0; $y < $array_num; $y++) {
                                    for ($x = 0; $x <= $array_num; $x++) {
                                        $flagstatus = 0;
                                        if (($sport_attr[$x]["order"] == $order) && ($sports[$i] == $sport_attr[$x]["name"])) {
                                            echo "<tr><th scope='row'>";
                                            echo $sport_attr[$x]["attribute"];
                                            echo "</th>";

                                            echo "<td>";
                                            echo $sport_attr[$x]["value"];
                                            echo "</td>";
                                            echo "</tr>";
                                            $order++;
                                            $flagstatus = 1;
                                            break;
                                        }

                                    }
                                    if ($order > $num_of_attr[$i]) break;
                                }
                                if (($flagstatus = 0) && ($order != 1)) {
                                    echo "<p>以下序号不存在</p>";
                                    echo $order;
                                }
                                if (($flagstatus = 0) && ($order == 1)) {
                                    echo "<p>没有发现序号1 </p>";
                                }
                                echo "</div>";
                                echo " </tbody>
                        </table>";
                                echo "</div>";
                            }
                        }
                            echo "</div>";

                        ?>
                        <br/>
                        <div class="desti_show_info l" style="width: 100%">
						
                        </div>
                        <div class="clear">
						</div>
						<?php if($place["disablechange"]==0):?>
						<a href="#myModal_edit_attr" role="button" class="btn btn-primary pull-right" data-toggle="modal" style=" background: #88c74f;    border: 1px #88c74f solid; margin-top: 10px">编辑属性</a>
						<?php endif;?>
						<?php if($place["disableadd"]==0):?>
							<a href="#myModal_add_sp" role="button" class="btn btn-primary pull-right" data-toggle="modal" style="margin-right: 10px; background: #88c74f;    border: 1px #88c74f solid; margin-top: 10px">增加运动方式</a>
							<?php endif;?>
                        <div class="destin_show_txt">
                            <?= $place['description'] ?>
                        </div>
                        <div class="desti_show_other" style="display: none">
                            门票：免费<br>
                            到达方式：可选择搭乘港铁至香港站下车 ，经由A出口或乘至尖東站经由J出口出站。<br>
                            开放时间：在维多利亚港两岸的建筑物于每晚20:00开始历时约20分钟的激光表演。<br>
                            地址：中环或尖沙咀天星码头(查看地图)<br>
                            所属分类：自然风光<br>
                        </div>
                    </div>
                    <div class="destin_comment_tit">点评</div>

                    <div class="destin_comments">
                        <?php if ($comments) {
                        foreach ($comments as $k => $v) {
                        ?>
                        <div class="destin_comment_list">
                            <div class="destin_comment_listl l">
                                <a href="<?=site_url('space/'.$v['uid'])?>" target="_blank"><img src="<?=IMG_domian?>avatar/<?=$v['uid']?>"><br><?= $v['username'] ?></a>
                            </div>
                            <div class="destin_comment_listr l">
                                <div class="user_score">
                                    <?php if(ereg("^[0-9][.][0-9]$",$v['score'])){?><!--判断评分是否是小数-->
                                    <?php for($i=0;$i<round($v['score']);$i++){?>
                                        <?php if($i+1==round($v['score'])){?>
                                            <span class="half_start"></span>
                                        <?php }else{?>
                                            <span class="green_start"></span>
                                        <?php }?>
                                    <?php }?>
                                    <?php for($i=0;$i<5-round($v['score']);$i++){?>
                                        <span class="gray_start"></span>
                                    <?php }?>
                                    <?php }else{?>
                                        <?php for($i=0;$i<$v['score'];$i++){?>
                                            <span class="green_start"></span>
                                        <?php }?>
                                        <?php for($i=0;$i<5-$v['score'];$i++){?>
                                            <span class="gray_start"></span>
                                        <?php }?>
                                    <?php }?>
                                </div>
                                <div class="destin_comment_text l"><?= $v['description'] ?></div>
                                <div class="r" style="display: none"><span class="desreplay">0条回复</span></div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php }}?>

                        <div class="destin_w_comment">
                            <a name="comment"></a>写点评
                            <span class="score" style="padding:0px 10px;"></span>
                            <span id="function-hint" style="font-size: 25px"></span>
                        </div>
                        <?php echo $form; ?>
                            <div class="message_txt">
                                <div class="message_textarea">
                                    <textarea class="textarea"  onKeyUp="javascript:checkWord(this);" onMouseDown="javascript:checkWord(this);" name="comment" placeholder="我去过，我想说">
                                    </textarea>
                                </div>
                                <div class="zstips">还可以输入<span style="font-family: Georgia; font-size: 26px;" id="wordCheck">3000</span>个字符</div>
                                <div class="message_submit r">
                                    <input type="submit" class="message_sub" value="留言"/>
                                    <!--james 评分数值-->
                                    <input type="hidden" name="score" value="3">
                                    <input type="hidden" name="pid" value="<?= $place['pid'] ?>"/>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="desti_show_r r">
                    <div class="desti_showr r">
                        <div class="member_indexr_ctit">
                            <div class="l desti_nums"><span><?php echo $been_total; ?></span>位野孩子去过这里</div>
                            <!--<div class="r"><a href="#">更多</a></div>-->
                            <div class="clear"></div>
                        </div>
                        <ul class="my_scbaglist">
                            <?php if ($visit_had) {
                                foreach ($visit_had as $k => $v) {
                                    ?>
                                    <li><a href="<?=site_url('space_spoor/'.$v['uid'])?>" target="_blank"><img src="<?=IMG_domian?>avatar/<?=$v['uid']?>"></a>
                                        <br><a href="<?=site_url('space_spoor/'.$v['uid'])?>" target="_blank"><?= $v['username'] ?></a>
                                    </li>
                                <?php
                                }
                            }?>
                            <div class="">
                                <div class="desti_start">
                                    <span class="avg_score"></span>
                                    <span style="font-size: 45px;color:green"><?=$avg?></span>
                                    <span style="color:green">分</span>
                                </div>
                                <div class="desti_nums col-md-12"><span><?php echo $comments_total; ?></span>条评论</div>
                            </div>
                            <div class="desti_wdp col-md-12" style="margin-top: 0px"><a href="#comment"><img src="<?= base_url('images/w_dp.png') ?>" style="margin-bottom: 20px;"></a></div>

                            <img src="<?= base_url('upload/advertisement/4.jpg') ?>">
                            <img src="<?= base_url('upload/advertisement/5.jpg') ?>">
                            <img src="<?= base_url('upload/advertisement/6.jpg') ?>">
                            <div class="clear"></div>
                        </ul>
                        <div class="desti_showban">
                            <?php foreach($ad as $b):?>
                                <a href="<?php if($b['weblink']){echo $b['weblink'];}else{echo 'javascript:;';}?>"><img src="<?=base_url().$this->config->item('upload_ad').'/'.$b['img']?>" width="262" height="225" /></a>
                            <?php endforeach ?>
                        </div>
                    </div>
					<div class="desti_showr r">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                we will put sports content here
                                <img src="<?= base_url('upload/advertisement/1.jpg') ?>">
                                <img src="<?= base_url('upload/advertisement/2.jpg') ?>">
                                <img src="<?= base_url('upload/advertisement/3.jpg') ?>">

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>

<script type="text/javascript">
    $('.carousel').carousel({
        interval: false
//        pause:false
    })


	 function resizeIframe(obj) {
			obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
         console.log("obj.style.height:",obj.style.height);
		}
     $( window ).resize(function() {
         location.reload();
//         $("#myiframe").style.height = $("#myiframe").contentWindow.document.body.scrollHeight + 'px';
//         console.log("$("#myiframe").style.height:",$("#myiframe").style.height);
     });
    function onSpClick(event) {
        var url, link = $(this);
        var pid = link.attr('data-pid');
        var type = link.attr('data-type');
        var value = link.attr('data-value');
        if (type == 'plan') {
            url = g_siteUrl + 'place/ajax_plan?pid=' + pid + '&plan=' + value;
        }
        if (type == 'been') {
            url = g_siteUrl + 'place/ajax_been?pid=' + pid + '&been=' + value;
        }

        $.ajax({
            url: url,
            dataType: 'json',
            success: function (res) {
                if (res.code == -1) {
                    location = res.url;
                } else {
                    link.parent().find('a').show();
                    link.parent().find('a[data-value="' + res + '"]').hide();
                }
            },
            error: function () {
                return false;
            }
        });
    }
    $(document).delegate('#plan a,#been a', 'click', onSpClick);
</script>
<script>
    $(function () {
        $("#form1").validate({
            rules: {
                comment: "required"
            },
            success: function (em) {
                em.text("").addClass("success");
            },
            messages: {
                comment: "请输入评论内容"
            }
        });
    });
</script>
<script>
    var maxstrlen = 3000;

    function Q(s) {
        return document.getElementById(s);
    }

    function checkWord(c) {

        len = maxstrlen;

        var str = c.value;

        myLen = getStrleng(str);

        var wck = Q("wordCheck");

        if (myLen > len * 2) {

            c.value = str.substring(0, i + 1);

        }

        else {

            wck.innerHTML = Math.floor((len * 2 - myLen) / 2);

        }

    }

    function getStrleng(str) {

        myLen = 0;

        i = 0;

        for (; (i < str.length) && (myLen <= maxstrlen * 2); i++) {

            if (str.charCodeAt(i) > 0 && str.charCodeAt(i) < 128)

                myLen++;

            else

                myLen += 2;

        }

        return myLen;

    }
//评分js jamse add

 //平均分的js
    $(function() {
        $.fn.raty.defaults.path = '<?=base_url().'images'?>';
        $('.avg_score').raty({
            number: 5,//多少个星星设置
            score: <?=$avg?>,//初始值是设置
            half:true,
            targetType: 'number',//类型选择，number是数字值，hint，是设置的数组值
            cancelOff : 'cancel-off-big.png',
            cancelOn  : 'cancel-on-big.png',
            size      : 24,
            starHalf  : 'pink_harf.png',
            starOff   : 'blue_s.png',
            starOn    : 'red_s.png',
            target    : '#function-hint',
            cancel    : false,
            targetKeep: true,
            readOnly  : true,
            hints     : ['非常差', '差', '一般', '好', '非常好'],
            precision : false//是否包含小数
        });
    });
    $(function() {
        $.fn.raty.defaults.path = '<?=base_url().'images'?>';
        $('.score').raty({
            number: 5,//多少个星星设置
            score: 3,//初始值是设置
            half:true,
            targetType: 'number',//类型选择，number是数字值，hint，是设置的数组值
            cancelOff : 'cancel-off-big.png',
            cancelOn  : 'cancel-on-big.png',
            size      : 24,
            starHalf  : 'green_harf.png',
            starOff   : 'blue_s2.png',
            starOn    : 'green_s.png',
            target    : '#function-hint',
            cancel    : false,
            targetKeep: true,
            hints     : ['非常差', '差', '一般', '好', '非常好'],
            precision : false,//是否包含小数
            click: function(score, evt) {
                $("input[name='score']").val(score);
                // alert('ID: ' + $(this).attr('class') + "\nscore: " + score + "\nevent: " + evt.type);
            }
        });
    });
	$("#edit_com").click(function(){
		  var url="<?=WWW_domian?>"+'place/userEditAttribute/<?=$place['pid']?>/detail';
		  var data=$("#form_edit").serialize()+"&sports="+"<?=implode(" ",$sp_arr)?>";
		 // alert(data);
		  window.location.href=url+"?"+data;
		//  $.ajax({
		//	  url:url,
		//	  data:"spos=ss",
		//	  type:"post",
		//	success:function(res){
		//		  
		//	  }
		 // });
		
	});
	$(".add_s_link").click(function(){
	document.getElementById("add_sport_com_value").value=$(this).attr("favalue");
	document.getElementById("add_sport_com_name").value=$(this).attr("faname");
	 var url="<?=WWW_domian?>"+'place/userAddSport/'+$(this).attr("favalue")+"/<?=$place["pid"]?>";
	 var strname=$(this).attr("faname");
	 $.ajax({url:url,type:"post",dataType:"json",
	 success:function(response){
		 //alert("成功");
		 //console.log(response);
		 console.log(response);
		 if(response=="exist")
		 {
			 alert("此活动别人正在添加或管理员已添加");
			 return;
		 }
		 $("#setfont").html(strname);
		 	 console.log(strname);
			 var str_element="<strong>属性：</strong>(如果您还对这些属性还不清楚可以不用填写哦...)<br/>";
		 if(response==false){
			 
		 }
		 else{
			 $("#addspform").empty();
			 for( var i=0;i<response.length;i++){
				 str_element+="<p style='font-weight: bold'>"+response[i]['attribute']+"</p>"+"<input  class='form-control' style='width:100%' type='text' name='"+strname+"_"+response[i]['attribute']+"'> <br/>";
			 }
			 $(str_element).appendTo("#addspform");
		 }
	 }
	 
	 
	 });

});
$("#add_sport_com").click(function(){
	var data=$("#addspform").serialize()+"&sport_n="+document.getElementById("add_sport_com_name").value;
var url="<?=WWW_domian?>"+'place/userAddSportAction/'+document.getElementById("add_sport_com_value").value+"/<?=$place['pid']?>/";
	window.location.href=url+"?"+data;
});
	
</script>
<script>

    $(".modal_nav").click(function(){
//        alert("modal_nav");
        $(".modal_nav").removeClass('active');
        $(".modal_nav").css("color","black");
        $(this).addClass('active');
        $(this).css("color","#449d44");
    });
    $(".add_s_link").each(function(){
        var target=this;
        $(".sub_event").each(function(){
            if(this.val()==target.val()){
                target.css("background","#dddddd");
                target.disabled = true;
            }
        });
    });
</script>
</body>
</html>

