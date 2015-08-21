<link rel="stylesheet" href="<?php echo base_url(); ?>third_party/kindeditor/themes/default/default.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>third_party/kindeditor/kindeditor-min.js"></script>
</head>
<body onunload="GUnload()">

<?php echo $placeform; ?>
<table>
  <tr>
    <th colspan="2">修改目的地名称</th>
  </tr>
    <tr>
        <td class="left" width="60px">级别深度：</td>
        <td class="left">
            <select name="deep" id="deep">
                <option value="0" <?php if($place['deep']==0){ echo "selected"; } ?>>0</option>
                <option value="1" <?php if($place['deep']==1){ echo "selected"; } ?>>1</option>
                <option value="2" <?php if($place['deep']==2){ echo "selected"; } ?>>2</option>
                <option value="3" <?php if($place['deep']==3){ echo "selected"; } ?>>3</option>
            </select>&nbsp;&nbsp;级别深度 0-洲 1-国家 2-城市 3-场点
        </td>
    </tr>
    <?php if($place['deep']==3):?>
    <tr>
        <td class="left" width="60px">更改所属城市：</td>
        <td class="left"><input name="upcity" type="text" id="upcity" class="ex100" placeholder="不填写就不做任何更改" /></td>
    </tr>
    <?php endif?>
    <tr>
      <td class="left" width="60px">分类名称：</td>
      <td class="left"><input name="name" type="text" id="name" class="ex100" value="<?php echo $place['name'];?>"  class="required"/></td>
    </tr>
    <tr>
        <td class="left" width="60px">英文名称：</td>
        <td class="left"><input name="name_en" type="text" id="name_en" class="ex100" value="<?php echo $place['name_en'];?>"/></td>
    </tr>
    <?php if($place['deep']>0){ ?>
    <tr>
        <td class="left" width="60px">是否热门：</td>
        <td class="left"><input type="radio" name="hot" class="radio"  value="1" <?php if($place['hot']==1){echo 'checked';}?>>否 <input type="radio" name="hot" class="radio"  value="0" <?php if($place['hot']==0){echo 'checked';}?>>是</td>
    </tr>
    <?php } ?>
    <tr>
        <td class="left" width="60px">是否虚拟：</td>
        <td class="left"><input type="radio" name="virtual" class="radio" value="0" <?php if($place['virtual']==0){echo 'checked';}?>>否 <input type="radio" name="virtual"  class="radio" value="1" <?php if($place['virtual']==1){echo 'checked';}?>>是</td>
    </tr>
	  <tr>
        <td class="left" width="60px">是否允许用户更改属性：</td>
        <td class="left"><input type="radio" name="userchange" class="radio" value="0" <?php if($place['disablechange']==1){echo 'checked';}?>>否 <input type="radio" name="userchange"  class="radio" value="1" <?php if($place['disablechange']==0){echo 'checked';}?>>是</td>
    </tr>
	  <tr>
        <td class="left" width="60px">是否允许客户添加活动：</td>
        <td class="left"><input type="radio" name="useradd" class="radio" value="0" <?php if($place['disableadd']==	1){echo 'checked';}?>>否 <input type="radio" name="useradd"  class="radio" value="1" <?php if($place['disableadd']==0){echo 'checked';}?>>是</td>
    </tr>
    <tr>
        <td class="left" width="60px">描述：</td>
        <td class="left"><textarea name="content" style="width:800px;height:200px;visibility:hidden;"><?php echo $place['description']; ?></textarea></td>
    </tr>
    <tr>
        <td class="left" width="60px">排序：</td>
        <td class="left"><input name="weight" type="text" id="weight" class="ex100" value="<?php echo $place['weight'];?>"/></td>
    </tr>
    <tr>
        <td class="left" width="80px">经度 & 纬度：</td>
        <td class="left"><input name="log" type="text" id="log" style="width:300px" value="<?php if($place['longitude'] && $place['latitude']){echo '('.$place['longitude'].','.$place['latitude'].')';}?>"/>点击地图选择经纬度</td>
    </tr>
    <tr>
        <td class="left" width="60px"></td>
        <td class="left">
            <p>
                <b>Search for an address:</b>
                <input type="text" name="q" value="" class="address_input" size="40" />
                <input  name="find" value="Search" class="submit" onclick="showLocation();" />
            </p><br/>
            <div id="map" style="width: 980px; height: 550px">

            </div></td>
    </tr>
    <tr>
      <td colspan="2" class="left"><input type="hidden" name="pid" value="<?php echo $place['pid'];?>"> <input type="submit" name="Submit" value="提交" class="submit" /></td>
        <td colspan="2" class="left"><a href="<?=(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/'?>a8faPFwsc/index.php/place/manage.html">返回上一级</a></td>
    </tr>
    <tr>
        <td class="left" width="60px"></td>
        <td class="left"><div style=" height: 150px"></div></td>
    </tr>
</table>
<center><h4>图片管理</h4></center>
<iframe src="<?=(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/'?>a8faPFwsc/index.php/place/img_add/id/<?=$place['pid']?>" width="1280px"  frameBorder="0" seamless onload='javascript:resizeIframe(this)'></iframe>
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
<script>
    function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }
    $(function() {
        $("#form1").validate({
            rules: {
                name: "required",
                weight:"digits"

            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                name: "请输入目的的名称",
                weight:"请输入整数"

            }
        });
    });

</script>

<!--添加谷歌地图-->
<script src="http://ditu.google.cn/maps?file=api&amp;v=2&amp;key=ABQIAAAAzr2EBOXUKnm_jVnk0OJI7xSosDVG8KKPE1-m51RBrvYughuyMxQ-i1QfUnH94QxWIa6N4U6MouMmBA&hl=zh-CN"
        type="text/javascript"></script>
<script>
    var map;
    var polyline;
    var markers = [];
    var myIcon = new GIcon(G_DEFAULT_ICON,"http://www.yehaiz.com/a8faPFwsc/images/star.png");
    var geocoder;
    $(function(){
        var eventinfo = document.getElementById("map");
        if (GBrowserIsCompatible()) {
            var map_canvas = document.getElementById("map");
            map = new GMap2(map_canvas);

            map.setCenter(new GLatLng(29.735762444449076,94.910888671875), 4);
            //点击事件获取经纬度
            GEvent.addListener(map, 'click', function(overlay,latlng) {
                $('#log').val(latlng);
            });
            geocoder = new GClientGeocoder();
//标记自己
//            var latlng = new GLatLng(22.246992873218, 113.90215694904327);
//            map.addOverlay(createMarker(latlng,"我的标记1"));
//            var latlng = new GLatLng(22.55894272371135, 113.90369104763574);
//            map.addOverlay(createMarker(latlng,"我的标记2"));
        }
    })
    function createMarker(point,code) {
        var marker = new GMarker(point,{ icon: myIcon, draggable: true, bouncy: true });
        GEvent.addListener(marker, "click", function() {
            marker.openInfoWindowHtml(code);
        });
        return marker;
    }
    //搜索

    function addAddressToMap(response) {
        map.clearOverlays();
        if (!response || response.Status.code != 200) {
            alert("Sorry, we were unable to geocode that address");
        } else {
            place = response.Placemark[0];
            point = new GLatLng(place.Point.coordinates[1],
                place.Point.coordinates[0]);
            map.setCenter(point,14);

            // var optionss = new GMarkerOptions;
            // optionss.title = 'here';
            // optionss.icon = G_DEFAULT_ICON ;

            marker = new GMarker(point);


            map.addOverlay(marker);
            marker.openInfoWindowHtml(place.address + '<br>' + '<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
            GEvent.addListener(marker,'click',function(){
                marker.openInfoWindowHtml(place.address + '<br>' + '<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
            });
        }
    }

    // showLocation() is called when you click on the Search button
    // in the form.  It geocodes the address entered into the form
    // and adds a marker to the map at that location.
    function showLocation() {
        var address = document.forms[0].q.value;
        geocoder.getLocations(address, addAddressToMap);
    }

</script>

