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
    <table>
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
        <tr>
            <td></td>
            <td>
                <input style="margin-left:150px"name="Submit" type="submit" class="submit" value="提交">
            </td>
        </tr>
    </table>

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

</script>

