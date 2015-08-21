 <link rel="stylesheet" href="<?php echo base_url(); ?>third_party/kindeditor/themes/default/default.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>third_party/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
});
</script>
 <script type="text/javascript" src= "<?php echo WWW_domian;?>js/common.js"></script>
 <script>var g_siteUrl = "<?php echo WWW_domian;?>";</script>
</head>
<body>
<?php echo $form; ?>
<table>
    <tr>
      <th colspan="2"><?php echo $lang['news_add']; ?></th>
    </tr>
    <tr>
      <td class="right" width="10%"><?php echo $lang['news_classic']; ?>：</td>
      <td><select name="classic" id="classic" class="required">
          <option value=""><?php echo $lang['news_classic']; ?></option>
		  <?php foreach ($classic as $k=>$v){ ?>
          <optgroup label="<?php echo $v['name']; ?>"> <?php foreach($v['sclass'] as $i=>$j){ ?>
          <option value="<?php echo $j['id']; ?>"><?php echo $j['name']; ?></option>
          <?php } ?> </optgroup>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_title']; ?>：</td>
      <td><input name="title" type="text" id="title" class="required ex300" /></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_subhead']; ?>：</td>
      <td><input name="title2" type="text" id="title2" class="ex300" placeholder="<?php echo $lang['blank']; ?>" /></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_updated']; ?>：</td>
      <td><input type="text" name="stime" id="stime" onFocus="WdatePicker({skin:'twoer',readOnly:true,doubleCalendar:true})" class="date" value="<?php echo $date;?>" />
        <span class="fontcolorA"><?php echo $lang['news_default_time']; ?></span></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_color']; ?>：</td>
      <td><select name="color" id="color">
          <OPTION value="#000000" style="background-color:#000000"><?php echo $lang['news_default_color']; ?></OPTION>
          <OPTION value="#FFFFFF" style="background-color:#FFFFFF"></OPTION>
          <OPTION value="#ED1C24" style="background-color:#ED1C24"></OPTION>
          <OPTION value="#00A651" style="background-color:#00A651"></OPTION>
          <OPTION value="#990000" style="background-color:#990000"></OPTION>
          <OPTION value="#000080" style="background-color:#000080"></OPTION>
          <OPTION value="#00AEEF" style="background-color:#00AEEF"></OPTION>
          <OPTION value="#666666" style="background-color:#666666"></OPTION>
          <OPTION value="#FFFF00" style="background-color:#FFFF00"></OPTION>
          <OPTION value="#F26522" style="background-color:#F26522"></OPTION>
          <OPTION value="#662D91" style="background-color:#662D91"></OPTION>
          <OPTION value="#FF00FF" style="background-color:#FF00FF"></OPTION>
          <OPTION value="#FF0000" style="background-color:#FF0000"></OPTION>
          <OPTION value="#39B54A" style="background-color:#39B54A"></OPTION>
          <OPTION value="#008080" style="background-color:#003663"></OPTION>
        </select></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_keyword']; ?>：</td>
      <td><input name="keyword" type="text" id="keyword" class="ex500" />
        <span class="fontcolorA"><?php echo $lang['news_keyword_remark']; ?></span></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_description']; ?>：</td>
      <td><input name="description" type="text" id="description" class="ex500" />
        <span class="fontcolorA"><?php echo $lang['news_description_remark']; ?></span></td>
    </tr>
    <tr>
        <td class="right"><?php echo $lang['place_tag']; ?>：</td>
        <td id="place">
            <div class="destin_ser_input" id="destin_ser_input">
                    <input type="text" id="search-box" placeholder="搜索国家、城市、目的地" class="destin_input l"autocomplete="off"/>
                    <div class="clear"></div>
                <div id="tipsList" class="tip_indschlay tip_schlay" style="display: none;"></div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="right"><?php echo $lang['sport_tag']; ?>：</td>
        <td id="sport">
            <div class="destin_ser_input" id="destin_ser_input2">
                <input type="text" id="search-box2" placeholder="搜索运动" class="destin_input l"autocomplete="off"/>
                <div class="clear"></div>
                <div id="tipsList2" class="tip_indschlay tip_schlay" style="display: none;"></div>
            </div>
        </td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_from']; ?>：</td>
      <td><input name="fromwho" type="text" id="fromwho" />
        <span class="fontcolorA"><?php echo $lang['news_from_remark']; ?></span></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_author']; ?>：</td>
      <td><input name="author" type="text" id="author" />
        <span class="fontcolorA"><?php echo $lang['news_author_remark']; ?></span></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['thumb']; ?>：</td>
      <td><input name="userfile" type="file" class="file" id="userfile" />
        <span class="fontcolorA"><?php echo $lang['news_thumb_remark']; ?></span></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_status']; ?>：</td>
      <td><?php echo $lang['yes']; ?>：
        <input name="flag" type="radio" class="radio" value="1" checked="checked" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo $lang['no']; ?>：
        <input name="flag" type="radio" class="radio" value="2" /></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_focus']; ?>：</td>
      <td><?php echo $lang['yes']; ?>：
        <input name="is_focus" type="radio" class="radio" value="1" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo $lang['no']; ?>：
        <input name="is_focus" type="radio" class="radio" value="2" checked="checked" /></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_top']; ?>：</td>
      <td><?php echo $lang['yes']; ?>：
        <input name="is_top" type="radio" class="radio" value="1" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo $lang['no']; ?>：
        <input name="is_top" type="radio" class="radio" value="2" checked="checked" /></td>
    </tr>
    <tr>
        <td class="right"><?php echo $lang['news_abstract']; ?>：</td>
        <td><textarea name="abstract" style="width:900px;height:200px;"></textarea></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_content']; ?>：</td>
      <td><textarea name="content" style="width:800px;height:400px;visibility:hidden;"></textarea></td>
    </tr>
    <tr>
      <td colspan="2" class="center"><input type="submit" name="Submit" value="<?php echo $lang['submit']; ?>" class="submit" /></td>
    </tr>
</table>
</form>
</body>
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            allowFileManager : true,
            width:"900px",
            langType : 'zh_CN',
            afterBlur: function(){this.sync();}
        });
    });
</script>