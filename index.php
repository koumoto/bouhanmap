<?php
$fileName = "/tmp/test.txt";
$fp = fopen($fileName, "r");
$data = array();
while(($line = fgets($fp)) != NULL){
    $point = explode(",",$line);
    $dataflow['title'] = trim($point[1]);
    $dataflow['lat'] = (double) trim($point[3]);
    $dataflow['lng'] = (double) trim(str_replace("\r\n","",$point[4]));
    array_push($data, $dataflow);
}
?>

<html>
<head>
    <meta charset='utf-8'>
    <title>安全マップ</title>
    <link href="./css/map.css" rel="stylesheet">
    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyClDcw7bRO05fpRCQMmU71Vk6fTN-cdVnM&libraries=drawing"></script>
</head>
<body onLoad="initdata(data),draw(data)">
    <script>
        var data = <?php echo json_encode($data); ?>;
    </script>
    <div id="map-canvas">ここに地図が表示されます。</div>
    <h1>兵庫県防犯マップ</h1>
    <input class="check_box" type="checkbox" checked="checked" id="koekake" onClick="show(geodata)">
    <label for="koekake" class="label">声かけ事案</label>
    <input class="check_box" type="checkbox" checked="checked" id="chikan" onClick="show(geodata)">
    <label for="chikan" class="label">チカン</label>
    <input class="check_box" type="checkbox" checked="checked" id="tsukimatoi" onClick="show(geodata)">
    <label for="tsukimatoi" class="label">つきまとい</label>
    <input class="check_box" type="checkbox" checked="checked" id="rosyustu" onClick="show(geodata)">
    <label for="rosyustu" class="label">露出</label>
    <input class="check_box"type="checkbox" checked="checked" id="fusinsha" onClick="show(geodata)">
    <label for="fusinsha" class="label">不審者</label>
    <input class="check_box"type="checkbox" checked="checked" id="sonota" onClick="show(geodata)">
    <label for="sonota" class="label">その他</label>
    <p>このマップはひょうご防犯ネットからメールで防犯情報を収集し、それを可視化したマップです。</p>
    <p>作成者:<a href="http://bensemi.com/myself">河本純一</a></p>
    <script src="./js/map.js"></script>
</body>
</html>
