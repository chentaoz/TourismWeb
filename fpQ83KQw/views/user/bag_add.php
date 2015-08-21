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
        <div class="bag-title">创建背包</div>
        <form action="<?=site_url('user/bag_add')?>" method="post" id="form">
            <div class="bag-input" id="destin_ser_input">
                <span class="bag-input-title">目的地：</span><span class="bag-input-data">
			        	<input type="text" name="place" id="search-box"><em class="tip">Tip:填写关键字搜索本站的目的地，随意填写无效</em>
                 <div id="tipsList" class="tip_indschlay tip_schlay" style="display: none;"></div>
			      	</span>

            </div>
            <div class="bag-input">
                <span class="bag-input-title">标题：</span>
                <span class="bag-input-data"><input type="text" name="title" maxlength="50"></span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">内容：</span>
                <span class="bag-input-data"><input type="text" name="content" maxlength="50"></span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">部落：</span>
                <span class="bag-input-data"><input type="text" id="place" name="place"><em class="tip">Tip:填写关键字搜索本站的部落，随意填写无效</em></span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">添加装备：</span>
                <span class="bag-input-data"><img src="<?=base_url()?>images/bag_add.png" id="J-bag" style="cursor:pointer;" ></span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">已选的装备：</span>
			    	<span class="bag-input-data">
			      		<div class="bag-equipment-data" id="J-choose-equip" style="margin-left:0;">还未添加装备</div>
		      		</span>
            </div>
            <div class="bag-input">
                <span class="bag-input-title">自定义装备：</span>
                <span class="bag-input-data"><input type="text" name="equip[]" placeholder="装备名称"></span>
                <img src="../images/bag_add-2.png" class="bag-define">
            </div>
            <input type="hidden" name="equip-id" id="J-equip-id" value="">
            <!-- hidden id  james-->
            <input type="hidden" name="did" id="did" value="">
            <input type="hidden" name="sid" id="sid" value="">

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
                iframe: {src: '<?php echo site_url('user/bag_equipment_add'); ?>'},
                yes:function(index){
                    /*这里是点击确定按钮之后的相关操作*/
                    var $equip=layer.getChildFrame('#J-equip-id',layer.index).val();//组装好的已选择的装备id
                    var suit_id=$('#J-equip-id').val();//已经添加的装备ID
                    if(suit_id==''){
                        $('#J-equip-id').val($equip);
                        var $equipdata=layer.getChildFrame('#J-equip-html',layer.index).val();
                        $equipdata=$equipdata.split('|!yehaiz!|');//子页面的数组

                        $('#J-choose-equip').append($equipdata);
                        $equipdata=$equipdata.join('');
                        $('#J-choose-equip').html($equipdata);
                    }else{
                        suit_id_arr=suit_id.split('-');//已选的分隔成数组
                        $equip=$equip.split('-');//分隔成数组
                        for(var i=0;i<$equip.length;i++){
                            if($.inArray($equip[i],suit_id_arr)=='-1'){
                                var nid= $equip[i];
                                suit_id+='-'+nid;
                                $('#J-equip-id').val(suit_id);//赋值回去
                                var $equipdata=layer.getChildFrame('#J-equip-html',layer.index).val();
                                $equipdata=$equipdata.split('|!yehaiz!|');//子页面的数组
                                for(var j=0;j<$equipdata.length;j++){
                                    var suid=$($equipdata[j]).attr('data-equip');
                                    if(nid==suid){
                                        $('#J-choose-equip').append($equipdata[j]);
                                    }
                                }

                            }
                        }

                    }
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
    })
    function inArray2(needle,array,bool){
        if(typeof needle=="string"||typeof needle=="number"){
            var len=array.length;
            for(var i=0;i<len;i++){
                if(needle===array[i]){
                    if(bool){
                        return i;
                    }
                    return true;
                }
            }
            return false;
        }
    }
</script>
</body>
</html>