<?php  $this->load->view('head');?>
</head>
<?php echo $form;?>
<table>
    <tr>
        <th colspan="4">编辑运动攻略</th>
    </tr>
    <tr>
        <td class="right" width="80">标题：</td>
        <td class="" width="30%"><input name="title" type="text" id="title" value="<?=$guide['title']?>"/></td>
        <td class="right" width="80">版本：</td>
        <td class=""><input name="version" type="text"  value="<?=$guide['version']?>"/></td>
    </tr>
    <tr>
        <td class="right">预览图：</td>
        <td class=""><input name="banner1" type="file" />jpg|gif|png<img height="30" src="<?='/'.$this->config->item('upload_guide_image').'/'.$guide['preview']; ?>"></td>

        <td class="right">封面图：</td>
        <td class=""><input name="preview" type="file" />jpg|gif|png<img height="30" src="<?='/'.$this->config->item('upload_guide_image').'/'.$guide['img']; ?>"></td>
    </tr>
    <tr>
        <td class="right">攻略文件：</td>
        <td class=""><input name="guide" type="file"  />pdf&nbsp;&nbsp;<a target="_blank" href="<?='/'.$this->config->item('upload_guide_pdf').'/'.$guide['filepath']; ?>">查看原有PDF文件</a> </td>
    </tr>
    <tr>
        <td class="right">页数：</td>
        <td class="left"><input name="pagenum" type="text"  value="<?=$guide['pagenum']?>"/></td>
        <td class="right">排序：</td>
        <td class="left"><input name="weight" type="text"  value="<?=$guide['weight']?>"/></td>
    </tr>
    <tr>
        <td class="right">描述：</td>
        <td class="left"><textarea name="description"  cols="32" /><?=$guide['description']?></textarea></td>
        <td class="right">选择等级：</td>
        <td class="">
            <select name="level">

                <?php foreach ($level as $v):?>
                    <?php if(!empty($v)):?>
                    <option value="<?=$v['ttid']?>" <?php if($v['ttid']==$guide['term_level_id']){echo "selected";}?>> <?=$v['name']?> </option>
                    <?php endif ?>
                <?php endforeach?>
            </select>

        </td>
    </tr>
    <tr>
        <td><input type="hidden" name="guide_id" value="<?=$guide['gid']?>"></td>
        <td><input type="submit" value="提交" class="submit" /></td>
        <td><input type="hidden" name="sport_id" value="<?=$guide['sport_id']?>"></td>
        <td><input type="hidden" name="pl_id" value="<?=$level_id?>"></td>
    </tr>
</table>
</form>

<script>
    $(function() {
        $("#form").validate({
            rules: {
                title: "required",
                description:"required",
                pagenum: {digits:true,required:true},
                weight: {digits:true,required:true}
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                title : "请输入标题",
                pagenum: "页数须为整数",
                description:"请填写描述",
                weight:"排序须为整数"
            }
        });
    });
</script>