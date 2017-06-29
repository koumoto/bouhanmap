<?php
require_once 'Mail/mimeDecode.php';

mb_internal_encoding("UTF-8");
mb_language("japanese");

$mail = file_get_contents("php://stdin");
if(!$mail){
    exit(1);//fail reading
}

//mail analysis
$params['include_bodies'] = true;
$params['decode_bodies']  = true;
$params['decode_headers'] = true;
$decoder = new Mail_mimeDecode($mail);
$structure = $decoder -> decode($params);
$subject = $structure -> headers['subject'];
$subject = mb_substr($subject, 5);
$body = mb_convert_encoding($structure -> body, "UTF-8" );
$body = str_replace(array("\r\n", "\r", "\n"), '', $body);
$start = mb_strpos($body, "、"  , 0) + 1;
$stop  = mb_strpos($body, "付近", 0);
$crimeName =  mb_substr($subject, 0, mb_strpos($subject, "（",0));
$place = mb_substr($body, $start, $stop - $start);
$point = get_gps_from_address($place);
if($point['lat'] == NULL OR $point['lat'] == ""){
    exit(1);
}
if($point['lng'] == NULL OR $point['lng'] == ""){
    exit(1);
}
$fileName = "/tmp/test.txt";
$fp = fopen($fileName, "a+");
fputs($fp, date("Y/m/d H:i:s") . ", ");
fputs($fp, $crimeName . ", ");
fputs($fp, $place . ", ");
fputs($fp, $point['lat'] . ", ");
fputs($fp, $point['lng'] . "\n");
//echo mb_strpos($body , "付近") .", ";
//echo mb_strpos($body , "、");
fclose($fp);


function get_gps_from_address( $address='' ){
    $res = array();
    $req = 'http://maps.google.com/maps/api/geocode/xml';
    $req .= '?address='.urlencode($address);
    $req .= '&sensor=false';    
    $xml = simplexml_load_file($req) or die('XML parsing error');
    if ($xml->status == 'OK') {
        $location = $xml->result->geometry->location;
        $res['lat'] = (string)$location->lat[0];
        $res['lng'] = (string)$location->lng[0];
    }
    return $res;
}
