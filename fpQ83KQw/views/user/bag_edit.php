<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
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
<!--main-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>4));?>
    <!--背包-->
    <div class="bag">
        <div class="bag-title">编辑背包</div>
        <form action="<?=site_url('user/edit_bag')?>" method="post" id="form">
            <div class="bag-input" id="destin_ser_input">
                <span class="bag-input-title">目的地：</span><span class="bag-input-data">
			        	<input type="text" name="place" id="search-box" value="<?=$bag_array['place']['name'].'-'.$bag_array['place']['name_en']?>"><em class="tip">Tip:填写关键字搜索本站的目的地，随意填写无效</em>
                 <div id="tipsList" class="tip_indschlay tip_schlay" style="display: none;"></div>
			      	</span>

            </div>
            <div class="bag-input">
                <span class="bag-input-title">标题：</span>
                <span class="bag-input-data"><input type="text" name="title" maxlength="50" value="<?=$bag_array['title']?>"></span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">内容：</span>
                <span class="bag-input-data"><input type="text" name="content" maxlength="50" value="<?=$bag_array['remark']?>"></span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">部落：</span>
                <span class="bag-input-data"><input type="text" id="place" name="place" value="<?=$bag_array['sport']['name'].'-'.$bag_array['sport']['name_en']?>"><em class="tip">Tip:填写关键字搜索本站的部落，随意填写无效</em></span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">添加装备：</span>
                <span class="bag-input-data"><img src="<?=base_url()?>images/bag_add.png" id="J-bag" style="cursor:pointer;" ></span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">已选的装备：</span>
			    	<span class="bag-input-data">
			      		<div class="bag-equipment-data" id="J-choose-equip" style="margin-left:0;">
                            <?php foreach($bag_array['suit'] as $s):?>
                                <div class="bag-equip" data-equip="<?=$s['ttid']?>">
                                    <img src="<?='/'.$this->config->item('upload_taxonomy').'/'.$s['img']?>" class="bag-equip-img">
                                    <span><?=$s['name']?></span>
                                    <div class="bag-equip-del" data-choose="1"></div>
                                </div>
                            <?php endforeach ?>
                        </div>
		      		</span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">自定义装备：</span>
                <span class="bag-input-data"><input type="text" name="equip[]" placeholder="装备名称" value="<?=$ms['name']?>"></span>
                <img src="<?=base_url()?>images/bag_add-2.png" class="bag-define">
            </div>
            <?php foreach($bag_array['my_suit'] as $ms){?>
                <div class="bag-input"><span class="bag-input-title">自定义装备：</span><span class="bag-input-data">
                <input type="text" name="my_equip[<?php echo $ms['ttid']?>]" placeholder="装备名称" value="<?=$ms['name']?>">
                </span><img src="<?=base_url()?>images/delete.png" class="bag-del"></div>
            <?php }?>
            <input type="hidden" name="equip-id" id="J-equip-id" value="<?php
            if(count($bag_array['suit']>1)){
                foreach($bag_array['suit'] as $k=>$s){
                    if($k==0){
                        $id=$s['ttid'];
                    }else{
                        $id.='-'.$s['ttid'];
                    }
                }
                echo $id;
            }else{
                echo $bag_array['suit'][0]['ttid'];

            }
            ?>">
            <!-- hidden id  james-->
            <input type="hidden" name="did" id="did" value="<?=$bag_array['place']['placeid']?>">
            <input type="hidden" name="sid" id="sid" value="<?=$bag_array['sport']['spid']?>">
            <input type="hidden" name="bag_id" value="<?=$bag_id?>">
            <input type="hidden" name="my_suit_id" value="<?=$my_suit_id?>">
            <div class="bag-input">
                <span class="bag-input-title"></span>
			    	<span class="bag-input-data">
			    		<div class="up_photo_subs" style="margin-left:140px"><a href="javascript:;">提交</a></div>
			        </span>
            </div>

        </form>
    </div>
    <!--背包-->
    <div class="clear"></div>
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('#J-bag').on('click',function(){
            $.layer({
                type: 2,
                shadeClose: true,
                title: '添加背包装备',
                closeBtn: [0, true],
                shade: [0.8, '#000'],
                border: [3,0.5,'#ddd'],
                offset: ['100px',''],
                area: ['800px', ($(window).height() - 250) +'px'],
                btns:2,
                iframe: {src: '<?php echo site_url('user/bag_equipment_add/'.$bag_id); ?>'},
                yes:function(index){
                    /*这里是点击确定按钮之后的相关操作*/
                    $equip=layer.getChildFrame('#J-equip-id',layer.index).val();//组装好的已选择的装备id

                    $('#J-equip-id').val($equip);
                    $equipdata=layer.getChildFrame('#J-equip-html',layer.index).val();
                    $equipdata=$equipdata.split('|!yehaiz!|');
                    $equipdata=$equipdata.join('');
                    $('#J-choose-equip').html($equipdata);
                    layer.msg('装备添加成功',2,1);
                    layer.close(index);
                    $('#J-choose-equip .bag-equip').on('click',function(){
                        $equip=$(this).attr('data-equip');
                        $(this).remove();
                        $equipiddata=$('#J-equip-id').val().split('-');

                        $equipindex=$.inArray($equip,$equipiddata);
                        if($equipindex!=-1){
                            $equipiddata.splice($equipindex,1);
                        }
                        $('#J-equip-id').val($equipiddata.join('-'));
                    });
                }
            });
        });
        $('.bag-define').on('click',function(){
            $parent=$(this).parents('div.bag-input');
            //$parent.clone(true).insertAfter($parent);
            $parent.after('<div class="bag-input"><span class="bag-input-title">自定义装备：</span><span class="bag-input-data"><input type="text" name="equip[]" placeholder="装备名称"><img src="/images/delete.png" class="bag-del"></span></div>')
            //取消自定义装备 james add
            $('.bag-del').click(function(){
                $(this).parents('.bag-input').remove();
            })
        });
        $('.bag-del').click(function(){
            $(this).parents('.bag-input').remove();
        })
    });
</script>
<!--  james 自动搜索-->
<script type="text/javascript">
    $(function(){
        $("#place").bigAutocomplete({
            width:410,//下拉的宽度
            data:<?=$sports?>,
            callback:function(data){
                $('#sid').val(data.result);
            }});
        //表单提交document.getElementById("myform")
        $('.up_photo_subs a').click(function(){
            //先判断输入框的数据
            var d= $('#did').val();//地点
            var s= $('#sid').val();//部落
            var title= $('input[name="title"]').val();//标题
            var content= $('input[name="content"]').val();//内容
            var outfit= $('#J-equip-id').val();//已选装备
            if(d && s && title && outfit ){
                $('#form').submit();
            }else{
                layer.msg('请完善信息',2,3);
                layer.close();
            }
        })
        $('#J-choose-equip .bag-equip').on('click',function(){
            $equip=$(this).attr('data-equip');
            $(this).remove();
            $equipiddata=$('#J-equip-id').val().split('-');

            $equipindex=$.inArray($equip,$equipiddata);
            if($equipindex!=-1){
                $equipiddata.splice($equipindex,1);
            }
            $('#J-equip-id').val($equipiddata.join('-'));
        });
    })

</script>
</body>
</html>