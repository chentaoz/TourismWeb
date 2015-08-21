<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--main-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>6));?>
    <!-- spoor_city_add -->
    <div class="spoor member_index">
        <div class="spoor-total">我去过的：国家&nbsp;<?php echo $country?>&nbsp;&nbsp;城市&nbsp;<?=$city?></div>
        <div class="spoor-city-add">
            <ul class="spoor-city-been-want">
                <li class="spoor-city-been focus" value="1"><span>添加去过 &nbsp;</span><img src="<?=base_url()?>images/been.png"></li>
                <li class="spoor-city-want" value="0"> <span>添加想去&nbsp;</span><img src="<?=base_url()?>images/want.png"></li>
            </ul>
            <!--遍历州-->
            <ul class="spoor-area ">
                <?php foreach($place_parent as $k=>$v):?>
                    <li <?php if($k==0){echo 'class="focus"';}?>><a href="javascript:;"><?php echo $v['name']; ?></a></li>
                <?php endforeach?>
            </ul>
            <!--遍历国家-->
            <?php if($place_parent){?><!--遍历国家-->
            <?php  foreach($place_parent as $k=>$v):?>
                <div <?php if($k!=0){echo 'style="display:none"';}?>class="spoor-countries c">
                    <h2><?php echo $v['name']; ?>&nbsp;<?php echo $v['name_en']; ?><span class="info"></span></h2>
                    <?php if($v['child']){?>
                        <ul class="spoor-country-all clear" id="ui-country">
                            <?php foreach($v['child'] as $j=>$i):?>
                                <li countryid="<?=$i['pid']?>"><a href="javascript:;"><?php echo $i['name'].'&nbsp;'.$i['name_en']; ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    <?php }?>
                </div>
            <?php endforeach?>
            <?php }?>

            <h1 class="spoor-countries-country"></h1>
            <div class="spoor-countries cc" style="display:none">
                <ul class="spoor-country-all clear city" id="ui-city" >
                    <span style="display:block;width:100%;text-align: center">加载中...</span>
                </ul>
            </div>


            <h1 class=" level3"></h1>
            <div class="spoor-countries cc_3" style="display:none">
                <ul class="spoor-country-all  last_city clear" id="ui-city3" >
                    <span style="display:block;width:100%;text-align: center">加载中...</span>
                </ul>
            </div>
            <!--存放每次ajax生成的html-->
            <span id="last_leve"></span>
            <input type="hidden" name="flag" id="flag" value="1" />
            <input type="hidden" name="country" id="ui-country-data" />
            <input type="hidden" id="city" />
            <input type="hidden" name="city" id="ui-city-data" />
            <div class="submit"><input type="submit" name="submit" value="提交" onclick="add_spoor()"/></div>
        </div>
    </div>
    <!-- spoor_city_add -->
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    var cid='';
    $(document).ready(function() {
        $('.spoor-city-been-want li').bind('click',function(){
            $('.spoor-city-been-want li').removeClass('focus');
            $(this).addClass('focus');
            $('#ui-city-data').val('');
            var f=$(this).attr('value');
            $('#flag').val(f);
            //选择去过想去  如果这个id下有子集
            var exit=$('#ui-city3').children('li');
            $('#last_leve').html('');
            if(exit.length){
                layer.msg('加载中...',3,9);
                var country_id=$('#country_id').val();
                var ct_id=$('#city').val();
                var url4='<?php echo site_url('user/get_child_city')?>';
                $.post(url4, {'city':ct_id,'country_id':country_id,'flag':f},function(info){

                    $('#ui-city3').html('');
                    var lengs= info.length;
                    for(var i=0; i<lengs; i++){
                        if(info[i]['gone']==1){
                            $('#ui-city3').append("<li cityid="+info[i]['pid']+"><a title='已经添加过' class='gone' href='javascript:;'>"+info[i]['name']+'&nbsp;'+info[i]['name_en']+"</a></li>");
                        }else{
                            $('#ui-city3').append("<li cityid="+info[i]['pid']+"><a href='javascript:;' child="+info[i]['gone']+">"+info[i]['name']+'&nbsp;'+info[i]['name_en']+"</a></li>");
                        }
                    }
                    my_bind();
                },'json');

            }

        });
        $('#ui-country li a').bind('click',function(){
            //全部清楚数据
            $('#ui-country-data').val('');
            $('#ui-city-data').val('');
            $(".cc_3").hide();
            $(".level3").html('');
            $("#ui-city3").html('');
            $('#last_leve').html('');
            $('#city').val('');//城市
            //再次赋值
            $('#ui-country-data').val($(this).parent().attr('countryid'));
            $('#ui-country li a').removeClass('focus');
            $(this).addClass('focus');
            cid= $('#ui-country-data').val();//获取国家的id
            if(cid==''){
                alert('出错了');
            }
            //变化国家效果
            //获取点击的国家
            var country=$(this).html();
            $('.spoor-countries-country').html(country);
            $('#ui-city').html(' <span style="display:block;width:100%;text-align: center">加载中...</span>');
            $('.cc').show();
            //ajax 获取城市
            var fa=parseInt($('#flag').val());
            var url="<?=site_url('user/get_city')?>";
            $.post(url, {'country':cid,'fla':fa},function(r){
                var l=  r.length;
                if(l==0){
                    $('#ui-city').html(' <span style="display:block;width:100%;text-align: center">对不起无数据!</span>');
                }else{
                    $('#ui-city').html('');
                    for(var i=0; i<l; i++){
                        if(r[i]['gone']==1){
                            $('#ui-city').append("<li cityid="+r[i]['pid']+"><a title='已经添加过' class='gone' href='javascript:;'>"+r[i]['name']+'&nbsp;'+r[i]['name_en']+"</a></li>");
                        }else{
                            $('#ui-city').append("<li cityid="+r[i]['pid']+"><a href='javascript:;' >"+r[i]['name']+'&nbsp;'+r[i]['name_en']+"</a></li>");
                        }
                    }
                    //点击选择城市的时候效果  是否还有显示第三级的信息
                    $('.city li a').bind('click',function(){

                        $('#last_leve').html('');
                        $('#city').val('');//清空城市
                        var style= $(this).attr("class");//获取有没有默认去过的样式
                        var children= $(this).attr("child"); //有下一集的标识
                        var city_name= $(this).html();//获取点击的城市名字
                        // if(style!='gone'){
                        layer.msg('加载中...',6,9);
                        var city_id=  $(this).parent().attr('cityid');
                        $('#city').val(city_id);//重新添加城市
                        $('#ui-city li a').removeClass('focus');
                        $(this).addClass('focus');
                        //在来ajax抓去是否有下一级别的信息
                        $('#ui-city-data').val('');//有数据清楚id
                        var flags=$('#flag').val();//获取类型
                        $('#ui-city3').html(' <span style="display:block;width:100%;text-align: center">加载中...</span>');

                        ajax_get(city_id,cid,flags,city_name);

                        // }
                        return false;
                    });

                }
            },'json');
            return false;
        });

    });
</script>
<!--james -->
<script type="text/javascript">
    $(".spoor-area li a").each(function(i){
        $(this).click(function(){
            $('.spoor-area li').removeClass('focus');
            $(this).parent().addClass('focus');
            //切换州的时候清空所有数据和样式
            $('#ui-country li a').removeClass('focus');
            $('#ui-country-data').val('');
            $('#ui-city-data').val('');
            $('.spoor-countries-country').html('');
            $(".cc").hide();
            $(".c").hide();
            $(".c").eq(i).show();
            $(".cc_3").hide();
            $(".level3").html('');
            $('#ui-city3').html('');
            $('#last_leve').html('');//最后一级都清空
        })
    })
    //提交添加
    function add_spoor(){
        var new_flag=parseInt($('#flag').val());//类型
        var cid=parseInt($('#ui-country-data').val());//国家id
        var city_data=parseInt($('#ui-city-data').val());//最后目的地id
        var city= $('#city').val();//城市的id
        if(cid && city){
            layer.msg('请稍等...',3,9);
            //ajax 添加足迹
            var url="<?=site_url('user/spoor_city_add')?>";
            $.post(url, {'f':new_flag,'c':cid,'dire_id':city_data,'citys':city},function(r){
                console.log(r);
                switch (r) {
                    case '1': layer.msg('添加成功',2,1);
                        break;
                    case '2':layer.msg('添加失败',2,3);
                        break;
                    case '3':layer.msg('已经添加过了,请选择其他地点！',2,3);
                        break;
                    case '4':layer.msg('此地点为虚拟的请选择下一级！',2,3);
                        break;
                    default: layer.msg('发生错误!',2,3);
                }
            });
        }else{
            layer.msg('请选择城市或缺少数据不能提交!',2,3);
            return false;
        }

    }
    //判断生成html
    function append_html(it,last,this_name){
        var  myst=$('#flag').val();
        layer.msg('加载中...',6,9);
        if(it){
            var v_name=$(it).html();//获取点击的城市名字
            var oit=$(it);//变成对象
            //改变选中样式
            oit.parents('.spoor-country-all').find('li a').removeClass('focus');
            oit.addClass('focus');
            // $('#ui-city-data').val(oit.parent().attr('cityid'));

            var ob_next=oit.parent().parent().parent().parent().nextAll('.my_append');//删除元素
            var next_parent= ob_next.length;
            if(next_parent>0){
                ob_next.remove();
                put_html(last,v_name,myst)
            }else{
                put_html(last,v_name,myst)
            }

        }else{

            put_html(last,this_name,myst)

        }


    }
    //输出的html

    function put_html(view_id,vn,on_style){
        $('#ui-city-data').val(view_id);//清楚最后的足迹id
        var put_id=view_id;
        var url3='<?php echo site_url('user/get_child_city')?>';
        $.post(url3, {'city':view_id,'flag':on_style},function(last_viw){
//            console.log(last_viw);
            //如果有子集生成html代码
            var leng=last_viw.length;
            if(leng>0){
                var $li='';
                for(var l=0;l<leng;l++){
                    var last_pid= last_viw[l]['pid'];
                    if(last_viw[l]['gone']){
                        var str_html='<li cityid='+last_pid+'><a class="gone" href="javascript:;" onclick="append_html(this,'+last_pid+')">'+last_viw[l]['name']+'&nbsp;<em>'+last_viw[l]['name_en']+'</em></a></li>';

                    }else{
                        str_html='<li cityid='+last_pid+'><a href="javascript:;" onclick="append_html(this,'+last_pid+')">'+last_viw[l]['name']+'&nbsp;<em>'+last_viw[l]['name_en']+'</em></a></li>';
                    }
                    $li+=str_html;
                }
                var $content=$('<div class="my_append"><fieldset style="border:1px solid #ddd;margin-top: 20px;padding: 20px;"> <legend style="margin-left:10px;font-size: 16px;">'+vn+'</legend><ul class="spoor-country-all  clear">'+$li+'</ul></fieldset></div>');
                $('#last_leve').append($content);
                layer.closeAll();
            }else{//不生成直接赋值
                $('#ui-city li a').each(function(){
                    var t= $(this).hasClass('focus');
                    if(t){
                        $('#city').val($(this).parent().attr('cityid'));
                    }

                });//赋值城市的id

                layer.closeAll();
            }
        },'json');
    }
    function ajax_get(city_id,cid,flags,city_name){
        var url2='<?php echo site_url('user/get_child_city')?>';
        $.post(url2, {'city':city_id,'country_id':cid,'flag':flags},function(result){
            layer.closeAll();
            var length= result.length;
            if(length>0){//有数据的时候
                $('.level3').html(city_name);//赋值城市标题 以及显示出来
                $('.cc_3').show();
                $('#ui-city3').html('');
                for(var i=0; i<result.length; i++){
                    if(result[i]['gone']==1){
                        $('#ui-city3').append("<li cityid="+result[i]['pid']+"><a title='已经添加过' class='gone' href='javascript:;'>"+result[i]['name']+'&nbsp;<em>'+result[i]['name_en']+"</em></a></li>");
                    }else{
                        $('#ui-city3').append("<li cityid="+result[i]['pid']+"><a href='javascript:;' child="+result[i]['gone']+">"+result[i]['name']+'&nbsp;<em>'+result[i]['name_en']+"</em></a></li>");
                    }
                }
            }else{
                $(".cc_3").hide();
                $(".level3").html('');
                $('#ui-city3').html('');//没有的时候第三级的全部隐藏
                //$('#ui-city-data').val(city_id);//没有子集的时候赋值
            }
            //点击事件
            my_bind();

        },'json');
    }
    function my_bind(){
        $('.last_city li a').bind('click',function(){
            $('#last_leve').html('');//最后一级都清空
            var view_class= $(this).attr("class");//获取有没有默认去过的样式
            $(this).parents('.spoor-country-all').find('li a').removeClass('focus');
            $(this).addClass('focus');
            //$('#ui-city-data').val($(this).parent().attr('cityid'));
            var last_id= $(this).parent().attr('cityid');//赋值的最后的id

            $('#ui-city-data').val(last_id);//赋值城市的id
            append_html('',last_id,$(this).html());
        });
    }
</script>
</body>
</html>