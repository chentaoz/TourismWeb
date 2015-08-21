<?php  $this->load->view('head');
function filter($filter,$array){
    $rest_array=array();
    foreach($array as $key=>$arr){
        if($arr['taxonomy_id']==4){
            $rest_array[$key]=$arr['term_id'];
        }

    }
    return $rest_array;
}

?>
</head>
<form id="form" action="<?=site_url('sports/sports_edit')?>" method="post" enctype="multipart/form-data">
    <table id="table">
        <tr>
            <th height="30" colspan="2" class="left">户外运动编辑</th>
        </tr>
        <tr>
            <td width="10%" class="right">活动中文名：</td>
            <td>
              <input type="text" name="c_name" value="<?=$sports_one[0]['name']?>">
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">活动英文名：</td>
            <td>
                <input type="text" name="e_name" value="<?=$sports_one[0]['name_en']?>">
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">别名：</td>
            <td>
                <input type="text" name="alias" value="<?=$sports_one[0]['alias']?>">
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">小图标：</td>
            <td>
               <input type="file" name="icon" value=""> <img width='40'src="<?=$url.'/upload/sports_icon/'.$sports_one[0]['img']?>">
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">描述：</td>
            <td>
                <textarea  name="desc" class="textarea" maxlength="100" ><?=$sports_one[0]['description']?></textarea>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">级别：</td>
            <td>
                <select name="level">

                    <?php foreach($level as $v):?>

                     <option value="<?=$v['ttid']?>" <?php if($sports_one[0]['taxonomy_id']==1 && $sports_one[0]['term_id']==$v['ttid'] ){echo 'selected';}?> > <?=$v['name']?> </option>

                    <?php endforeach ?>
                </select><a style="text-decoration: underline" href="<?=site_url('taxonomy')?>">如没有想要的等级请先添加</a>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">人员：</td>
            <td>
                <select name="people">

                    <?php foreach($people as $v):?>

                        <option value="<?=$v['ttid']?>" <?php if($sports_one[2]['taxonomy_id']==3 && $sports_one[2]['term_id']==$v['ttid'] ){echo 'selected';}?> > <?=$v['name']?> </option>


                    <?php endforeach?>
                </select><a style="text-decoration: underline" href="<?=site_url('taxonomy')?>">如没有想要的人员请先到人员分类中添加</a>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">清单：</td>
            <td>
                <select name="list">

                    <?php foreach($list as $v):?>


                        <option value="<?=$v['ttid']?>" <?php if($sports_one[1]['taxonomy_id']==2 && $sports_one[1]['term_id']==$v['ttid'] ){echo 'selected';}?> > <?=$v['name']?> </option>


                    <?php endforeach?>

                </select><a style="text-decoration: underline" href="<?=site_url('taxonomy')?>">如没有想要的清单请到清单分类中添加</a>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">标签：</td>
            <td>
                <div style="width:100%">
                    <?php foreach($tip as $v):?>
                        <input name="tip[]" type="checkbox" value="<?=$v['ttid']?>" <?php if(in_array($v['ttid'],filter('4',$sports_one))){ echo 'checked';}?> class="radio check"> <?=$v['name']?>
                    <?php endforeach?>
                </div>
                <a style="text-decoration: underline" href="<?=site_url('taxonomy')?>">如没有想要的标签请到标签分类中添加</a>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">排序：</td>
            <td>
              <input type="text" name="order" value="<?=$sports_one[0]['weight']?>">
            </td>
        </tr>
        <input type="hidden" name="sp_id" value="<?=$sports_one[0]['spid']?>">
        <tr id="attr_tr">
            <td width="10%" class="right">运动属性：

            </td>
            <td>
                <a class="submit" id="add_attr" >添加属性</a>
            </td>
        </tr>
        <?php if(isset($attrs_super)):
            $i=1?>

            <?php foreach($attrs_super as $attr):?>
        <tr id="own_<?=$i?>">
            <td width="10%" class="right">
                <small>属性：</small>
            </td>
            <td><input type="text" id="<?=$attr["id"]?>" name='own_attr_<?=($i)?>' value="<?=$attr["attribute"]?>" placeholder="名称">
                <input type="hidden" id="attrid<?=$attr["id"]?>" name='own_attr_id<?=($i)?>' value="<?=$attr["id"]?>">
                <input type="text" id="ownattrorder<?=$attr["id"]?>" name='own_attr_order<?=($i)?>' value="<?=$attr["order"]?>" placeholder="排序（数字）">
                <a  onclick="del(0,'<?=$i?>')" >删除属性</a>
                <?php $i++;?>
            </td>
        </tr>
            <?php endforeach?>
        <?php endif?>
        <tr>
            <td></td>
            <td>
                <input style="margin-left:150px"name="Submit" type="submit" class="submit" value="提交">
            </td>
        </tr>
    </table>
      <input type="hidden" id="count" value="<?=isset($attrs_super)?count($attrs_super):0?>"/>
</form>
<script>
    $(function() {
        $("#form").validate({
            rules: {
                c_name: "required",
                e_name: "required",
                order: {digits:true,required:true}

            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                c_name: "请输入中文名",
                e_name: "请输入英文名",
                order: "请填写数字"
            }
        });
    });
    var num=1;
    var num0=parseInt(document.getElementById("count").value);
    $("#add_attr").click(function(){
        $("<tr id='add_"+num+"'><td width='10%' class='right'><small>属性:</small></td><td><input type='text' name='add_attr_"+(num)+"' placeholder='名称'/> <input type='text' name='add_attr_order"+(num)+"' placeholder='排序（数字）'/><a  onclick='del(1,num-1)'>删除属性</a></td></tr> ").insertAfter('#attr_tr');
        num++;
    });
    function del(type,n){
        if(type==1){
            if((num-1)==n){  $("#add_"+n).remove();
                num--;
            }
            else{
                alert("只能删除最后一项");
                return;
            }

        }
        else if(type==0){
            if((num0)==n){  $("#own_"+n).remove();
                num0--;
            }
            else{
                alert("只能删除最后一项");
                return;
            }
        }
    }


</script>

