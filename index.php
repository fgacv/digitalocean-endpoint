<?php

error_reporting(-1);

require 'vendor/autoload.php';

use DigitalOceanV2\Adapter\BuzzAdapter;
use DigitalOceanV2\DigitalOceanV2;

$adapter = new BuzzAdapter('902975e63848a47b1d52b4d18e3e3b547d8113f0cc3ced75f1f5b80eea4dc95b');

$digitalocean = new DigitalOceanV2($adapter);

$domain = $digitalocean->domain();

$domains = $domain->getAll();

// URL arguments
$filter = $_GET['filter'];
$action = $_GET['action'];
$target = $_GET['target'];

if($filter == 'domain') {
    if($action == 'list-all') {
        echo json_encode($domains);
    }
}

?>