// キャンパスの要素を取得する
var canvas = document.getElementById( 'map-canvas' ) ;
var latlng = new google.maps.LatLng( 34.69427352939781, 135.1944923400879 );
var mapOptions = {
    zoom: 10 ,	// ズーム値
    center: latlng ,	// 中心座標 [latlng]
};
var map = new google.maps.Map( canvas, mapOptions ) ;
var geodata = new Array;
var markers = new Array;
function initdata(data){
    for(var i = 0; i < data.length; i++){
        var typedata;
        if(data[i]['title'] == '声かけ事案発生'){
            typedata= '声かけ';
        }else if(data[i]['title']== 'チカン発生'){
            typedata='チカン';
        }else if(data[i]['title']== 'つきまとい事案発生'){
            typedata='つきまとい';
        }else if(data[i]['title'] == '露出事件発生'){
            typedata = '露出';
        }else if(data[i]['title']== '不審者情報'){
            typedata='不審者';
        }else{
            typedata='その他';
        }
        geodata.push({
        position: new google.maps.LatLng(data[i]['lat'], data[i]['lng']),
        content: data[i]['title'],
        crimeType: typedata ,
        });
    }
    console.log(geodata);
}
function draw(data){
    for(var i = 0; i < geodata.length ; i++){
        var color;
        if(geodata[i]['crimeType'] == '声かけ'){
            color = 'blue';
        }else if(geodata[i]['crimeType'] == 'チカン'){
            color = 'yellow';
        }else if(geodata[i]['crimeType'] == 'つきまとい'){
            color = 'red';
        }else if(geodata[i]['crimeType'] == '露出'){
            color = 'green';
        }else if(geodata[i]['crimeType'] == '不審者'){
            color = 'purple';
        }else {
            color = 'pink';
        }
        var url = 'http://maps.google.com/mapfiles/ms/icons/'+ color +'-dot.png';
        var icon = new google.maps.MarkerImage(url,
                                               new google.maps.Size(31, 31),
                                               new google.maps.Point(0, 0), 
                                               new google.maps.Point(16, 16));
        var options ={
        position: geodata[i].position,
        map: map, 
        icon: icon,
        };
        var myMarker = new google.maps.Marker(options);
        attachMessage(myMarker, geodata[i].content);
        markers.push(myMarker);
    }
}


function attachMessage(marker, msg) {
    google.maps.event.addListener(marker, 'click', function ($) {
        new google.maps.InfoWindow({
            content: msg
        }).open(marker.getMap(), marker);
    });
}

function show(geodata){
    for(var i = 0; i < data.length; i++){
        if(geodata[i]['crimeType'] == '声かけ'){
            if(document.getElementById("koekake").checked == true){
                markers[i].setVisible(true);
            }else{
                markers[i].setVisible(false)
            }
        }
        if(geodata[i]['crimeType'] == 'チカン'){
            if(document.getElementById("chikan").checked == true){
                markers[i].setVisible(true);
            }else{
                markers[i].setVisible(false)
            }
        }
        if(geodata[i]['crimeType'] == '露出'){
            if(document.getElementById("rosyustu").checked == true){
                markers[i].setVisible(true);
            }else{
                markers[i].setVisible(false)
            }
        }
        if(geodata[i]['crimeType'] == 'つきまとい'){
            if(document.getElementById("tsukimatoi").checked == true){
                markers[i].setVisible(true);
            }else{
                markers[i].setVisible(false)
            }
        }
        if(geodata[i]['crimeType'] == '不審者'){
            if(document.getElementById("fusinsha").checked == true){
                markers[i].setVisible(true);
            }else{
                markers[i].setVisible(false)
            }
        }
        if(geodata[i]['crimeType'] == 'その他'){
            if(document.getElementById("sonota").checked == true){
                markers[i].setVisible(true);
            }else{
                markers[i].setVisible(false)
            }
        }
    }
}
