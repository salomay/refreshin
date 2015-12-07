<?php
include "../../application.php";
$appx= new app();
$dbu = new db();
$dbu->connect();


if(isset($_POST['lat'], $_POST['lng'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    $url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s&key=%s", $lat, $lng,'AIzaSyBr32XSlSuufKiolpfBEzaH2UH--2BY3qg');

    $content = file_get_contents($url); // get json content

    $metadata = json_decode($content, true); //json decoder

    if(count($metadata['results']) > 0) {
        // for format example look at url
        // https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452
        $result = $metadata['results'][0];
        //print_r($result);
        // save it in db for further use
        //echo $result['formatted_address'];
        //$hasil[nomer] = $result[address_components][0][long_name];
        $hasil[alamat] = $result[address_components][0][long_name];
        $hasil[kelurahan] = $result[address_components][1][long_name];
        $hasil[kecamatan] = $result[address_components][2][long_name];
        $hasil[kota] = $result[address_components][3][long_name];
        $hasil[provinsi] = $result[address_components][4][long_name];
        $hasil[negara] = $result[address_components][5][long_name];
        $hasil[kodepos] = $result[address_components][6][long_name];
        $hasil[lat_asli] = strval($result[geometry][location][lat]);
        $hasil[lng_asli] = strval($result[geometry][location][lng]);
        $hasil[lat] = $lat;
        $hasil[lng] = $lng;
        $hasil[detil] = $result['formatted_address'];
        //$_SESSION[nearby]=$hasil;

    header('Content-Type: application/json');
    echo json_encode($hasil);
    }
    else {
        echo "gagal";
    }
}

?>
