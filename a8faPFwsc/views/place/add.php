<link rel="stylesheet" href="<?php echo base_url(); ?>third_party/kindeditor/themes/default/default.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>third_party/kindeditor/kindeditor-min.js"></script>
</head>
<body>

<?php echo $placeform; ?>
<table>
    <tr>
        <th colspan="2">新增目的地</th>
    </tr>
    <tr>
        <td class="left" width="60px">级别深度：</td>
        <td class="left">
            <select name="deep" id="deep">
                <option value="1" selected>1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>&nbsp;&nbsp;级别深度 0-洲 1-国家 2-城市 3-场点
        </td>
    </tr>
    <tr>
        <td class="left" width="60px">子类名称：</td>
        <td class="left"><input name="name" type="text" id="name" class="ex100"  class="required"/></td>
    </tr>
    <tr>
        <td class="left" width="60px">英文名称：</td>
        <td class="left"><input name="name_en" type="text" id="name_en" class="ex100"/></td>
    </tr>
    <tr>
        <td class="left" width="60px">是否热门：</td>
        <td class="left"><input type="radio" name="hot" class="radio" value="1" checked>否 <input type="radio" name="hot"  class="radio" value="0">是</td>
    </tr>
    <tr>
        <td class="left" width="60px">是否虚拟：</td>
        <td class="left"><input type="radio" name="virtual" class="radio" value="0" checked>否 <input type="radio" name="virtual"  class="radio" value="1">是</td>
    </tr>
    <tr>
        <td class="left" width="60px">详细信息：</td>
        <td class="left"><textarea name="content" style="width:800px;height:200px;visibility:hidden;"></textarea></td>
    </tr>
    <tr>
        <td class="left" width="60px">排序：</td>
        <td class="left"><input name="weight" type="text" id="weight" class="ex100" value="255"/></td>
    </tr>
    <tr>
        <td class="left" width="80px">精度 & 纬度：</td>
        <td class="left"><input name="log" type="text" id="log" style="width:300px" value=""/>点击地图选择经纬度</td>
    </tr>
    <tr>
        <td class="left" width="60px"></td>
        <td class="left">
            <p>
                <b>Search for an address:</b>
                <input type="text" name="q" value="" class="address_input" size="40" />
                <input  name="find" value="Search" class="submit" onclick="showLocation();" />
            </p><br/>
            <div id="map" style="width: 980px; height: 450px">



            </div></td>
    </tr>
    <tr>
        <td colspan="2" class="left"><input type="hidden" name="parent" value="<?php echo $parent;?>"> <input type="submit" name="Submit" value="提交" class="submit" /></td>
    </tr>
</table>

</form>
<script>
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
                name: "请输入子类名称",
                weight:"请输入整数"

            }
        });
    });

</script>
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