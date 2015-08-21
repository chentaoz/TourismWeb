<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>6));?>
  <div class="spoor member_index">
    <div class="spoor-total"><?=$t_name?>在<?=$c_name['name']?>的足迹</div>
   <?php if($spaces){?>
       <?php foreach($spaces as $s){?>
    <div class="spoor-city clear">
        <div class="spoor-city-img">
            <a href="<?php echo site_url('place/index/pid/'.$s['pid']);?>">
                <img src='<?php echo get_img_url($s['img'],'230x230',2)?>' />
            </a>
        </div>
      <div class="fn-left">
        <div>
            <a href="<?php echo site_url('place/index/pid/'.$s['pid']);?>" class="spoor-city-name"><?=$s['name']?></a>
           <?php if(!$space && $space!='space'){?>
              <?php if(!$s['child']){?>
                <a style="float:right" href="javascript:;" onclick="del_spoor(<?=$s['pid']?>)">删除足迹</a>

           <?php }}?>
        </div>
          <div class="spoor-city-intro"><?=$s['description']?></div>
         <?php if($s['child']){?>

                 <div class="child">在<?=$s['name']?>里的足迹：
             <?php foreach($s['child'] as $c){?>
                  <span><a href="<?=site_url('place/index/pid/'.$c['pid'])?>"><?=$c['name']?></a>
                   <?php if(!$space && $space!='space'){?>
                      <em onclick="del_spoor(<?=$c['pid']?>)">X</em>
                   <?php }?>
                  </span>
             <?php }?>
                 </div>

         <?php }?>
      </div>
    </div>
           <?php } ?>
   <?php }else{ ?>
       <div class="nofino"><img src="<?php echo base_url('images/noinfo.png');?>"><br>这家伙太懒了，什么都没留下！</div>
      <?php }?>
  </div>
  <div class="page_link">  <?=$pagelink?></div>
</div>

<!--foot-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	$('.spoor-city .starbox').each(function() {
        $(this).find('li').hover(function(){
				$end=$(this).attr('data-order');
				$parent=$(this).parent();
				$children=$parent.children();
				$children.removeClass('stared');
				$children.slice(0,$end).addClass('stared');
				$parent.next().html($(this).attr('title'));
			},function(){
					$parent=$(this).parent();
					$oldsize=$parent.attr('data-oldsize');
					$parent.children().removeClass('stared');
					$parent.children().slice(0,$oldsize).addClass('stared');
					if($oldsize==0){
					  $parent.next().html('点击星星为它评分');
					}
				});
    });
	$(this).find('li').click(function(){
		  $parent=$(this).parent();
		  $end=$(this).attr('data-order');
		  $parent.next().html($(this).attr('title'));
		  $parent.children().removeClass('stared');
		  $parent.children().slice(0,$end).addClass('stared');
		  $parent.attr('data-size',$end);
		  $parent.attr('data-oldsize',$end);
	});
	$('.spoor-add a').on('click',function(){
		$.layer({
			type: 2,
			shadeClose: true,
			title: '在<?=$c_name['name']?>你去过哪些地方',
			closeBtn: [0, true],
			shade: [0.8, '#000'],
			border: [3,0.5,'#ddd'],
			offset: ['100px',''],
			area: ['800px', ($(window).height() - 250) +'px'],
			btns:2,
			iframe: {src: '<?php echo site_url('user/spoor_destination_add').'/'.$city_id.'/'.$place_id; ?>'},
			yes:function(index){
					/*这里是点击确定按钮之后的相关操作*/
            //获取选择的具体
            var choose=$(window.frames["xubox_iframe1"].document).find(".spoor-dest");//元素个数
            var lg=choose.length;
            var place = [];
                for(var i=0;i<lg;i++){
                   var options= $(choose[i]).attr('data-choose');
                    if(options==1){//选择的放在数组里面
                        place.push($(choose[i]).find('img').attr('pid'));
                   }
                }
            //存放数组中完毕判断数组是否为空
            if(place.length==0){
                layer.msg('请选择你的足迹',2,3);
                return false;
            }
            //ajax 给后台数据
                var url="<?=site_url('user/spoor_destination_add')?>";
                $.post(url, {'country':<?=$place_id?>,'sport':place,'city':<?=$city_id?>},function(r){
                   // console.log(r);
                   if (r ==1){
                       layer.msg('添加成功',2,1);
			           layer.close(index);
                       window.location.reload();
                   }
                    else{
                    layer.msg('添加失败',2,3);
                   }
                });

				}
		}); 
	});
});
//删除足迹
function del_spoor(spoor_id){
    $.layer({
        shade: [0],
        area: ['auto','auto'],
        dialog: {
            msg: '您确定要删除吗？',
            btns: 2,
            type: 4,
            btn: ['确定','取消'],
            yes: function(){
                layer.closeAll();
                layer.msg('加载中...',6,9);
                var spoor_url="<?php echo site_url('user/del_spoor/')?>";
                $.post(spoor_url, {'spoor':spoor_id},function(result){
                   if(result){
                       layer.msg('删除成功！',2,1);
                       window.location.reload();
                   }else{
                       layer.msg('删除失败！',2,3);
                   }
                });
            }
        }
    });


}

</script>
</body>
</html>