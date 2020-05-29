<?php
$domain = base_url(); 

$url = explode("/",trim($_SERVER["PATH_INFO"],"/"));
$count = 0;

$length = count($url);
for ($i = 1; $i <= $length; $i++) {
  $_GET[$i] = $url[$i-1];
}

function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){

     if (isset($_SERVER['HTTP_HOST'])) {
        $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
        $hostname = $_SERVER['HTTP_HOST'];
        $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
        $core = $core[0];

        $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
        $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
        $base_url = sprintf( $tmplt, $http, $hostname, $end );
        
    }
    else $base_url = 'http://localhost/';

    if ($parse) {
        $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
    }
    
    return $base_url;
}

function getAllDataOverview() {
    $data = file_get_contents( "https://corona.lmao.ninja/all" );
    $characters = json_decode($data, true);

    return $characters;

}

function getCountryList(){
    $data = file_get_contents( "https://corona.lmao.ninja/countries?sort=country" );
    $characters = json_decode($data, true); // decode the JSON feed
    usort($characters,function ($a, $b) {return strnatcasecmp($a['country'],$b['country']);});

    return $characters;
}

function getStatistic(){
    $data = file_get_contents( "https://corona.lmao.ninja/countries" );
    $characters = json_decode($data, true); // decode the JSON feed

    return $characters;
}

function getDataView($negara){
    $url = 'https://corona.lmao.ninja/v2/historical/'.strtolower($negara);
    $data = file_get_contents($url);
    $characters = json_decode($data, true); // decode the JSON feed

    $first = $characters["timeline"]['cases'];
    $second = $characters["timeline"]['recovered'];
    $third = $characters["timeline"]['deaths'];

    $dataSet = array();

    $no = 0;
    foreach($first as $key=>$option ) {
        $dataSet[$no][0] = $key;
        $dataSet[$no][1] = $option;
        $no++;
    }
    
    $no = 0;
    foreach($second as $key=>$option ) {
        $dataSet[$no][2] = $option;
        $no++;
    }

    $no = 0;

    foreach($third as $key=>$option ) {
        $dataSet[$no][3] = $option;
        $no++;
    }
    
    return $dataSet;
}

function getOverviewCountry($negara){
    $url = 'https://corona.lmao.ninja/countries/'.$negara;
    $data = file_get_contents($url);
    $characters = json_decode($data, true); // decode the JSON feed

    if($characters['message']){
        return null;
    }else{
        return $characters;
    }
}

function getTime($time){
    $time = $time + (8*60*60);
    $dt = new DateTime("@$time");
    $newTime = $dt->format('d M Y - h:i A');

    return $newTime;
}

    

/**
$array = getDataView();
print_r($ARRAY);
**/
?>