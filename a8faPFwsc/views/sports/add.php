<?php  $this->load->view('head');?>
</head>
<form id="form" action="<?=site_url('sports/sports_save')?>" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <th height="30" colspan="2" class="left">户外运动添加</th>
        </tr>
        <tr>
            <td width="10%" class="right">活动中文名：</td>
            <td>
              <input type="text" name="c_name" >
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">活动英文名：</td>
            <td>
                <input type="text" name="e_name">
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">别名：</td>
            <td>
                <input type="text" name="alias">
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">小图标：</td>
            <td>
               <input type="file" name="icon" value="">
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">描述：</td>
            <td>
                <textarea  name="desc" class="textarea" maxlength="100" ></textarea>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">级别：</td>
            <td>
               <select name="level">
                   <option value="">--请选择--</option>
                   <?php foreach($level as $v):?>
                       <option value="<?=$v['ttid']?>"> <?=$v['name']?> </option>
                    <?php endforeach?>
               </select><a style="text-decoration: underline" href="<?=site_url('taxonomy')?>">如没有想要的等级请先添加</a>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">人员：</td>
            <td>
                <select name="people">
                    <option value="">--请选择--</option>
                    <?php foreach($people as $v):?>
                        <option value="<?=$v['ttid']?>"><?=$v['name']?></option>
                    <?php endforeach?>
                </select><a style="text-decoration: underline" href="<?=site_url('taxonomy')?>">如没有想要的人员请先到人员分类中添加</a>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">清单：</td>
            <td>
                <select name="list">
                    <option value="">--请选择--</option>
                    <?php foreach($list as $v):?>
                        <option value="<?=$v['ttid']?>"> <?=$v['name']?> </option>
                    <?php endforeach?>
                </select><a style="text-decoration: underline" href="<?=site_url('taxonomy')?>">如没有想要的清单请到清单分类中添加</a>
            </td>
        </tr>

        <tr>
            <td width="10%" class="right">标签：</td>
            <td>
             <div style="width:100%">
                    <?php foreach($tip as $v):?>
                        <input name="tip[]" type="checkbox" value="<?=$v['ttid']?>" class="radio check"> <?=$v['name']?>
                    <?php endforeach?>
             </div>
               <a style="text-decoration: underline" href="<?=site_url('taxonomy')?>">如没有想要的标签请到标签分类中添加</a>
            </td>
        </tr>
        <tr>
            <td width="10%" class="right">排序：</td>
            <td>
              <input type="text" name="order">
            </td>
        </tr>
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
                level: "required",
                icon: "required",
                people:"required",
                list:"required",
                order: {digits:true,required:true}

            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                c_name: "请输入中文名",
                e_name: "请输入英文名",
                level: "请选择一个等级",
                icon: "请上传一个图标",
                people:"请选择",
                list:"请选择",
                order: "请填写数字"
            }
        });
    });

</script>

