<?php

require 'vendor/autoload.php';

use DigitalOceanV2\Adapter\BuzzAdapter;
use DigitalOceanV2\DigitalOceanV2;

$adapter = new BuzzAdapter('902975e63848a47b1d52b4d18e3e3b547d8113f0cc3ced75f1f5b80eea4dc95b');

$digitalocean = new DigitalOceanV2($adapter);

// URL arguments

function cli_or_not ( ) {
    if( PHP_SAPI === 'cli' ) {
        return true;
    }
    return false;
}

$domain = $digitalocean->domain ( );
$droplet = $digitalocean->droplet ( );
$actions = $digitalocean->action ( );

function get_dropplet_ip( $droplet ) {
    return array(
            'id'    =>  $droplet[0]->id,
            'ip'    =>  $droplet[0]->networks[0]->ipAddress
            );
}

function droplet_actions( $action ) {
    // get all droplets information
    global $droplet;
    if ( $action === 'dropletinfo' ) {
        foreach ( $droplet->getAll( ) as $drplt ) {
            $object = new stdClass;
            $object->id          =   $drplt->id;
            $object->createdAt   =   $drplt->createdAt;
            $object->disk        =   $drplt->disk;
            $object->ip          =   $drplt->networks[0]->ipAddress;
            $object->image       =   $drplt->image->slug;
        }
    } else if ( $action === 'dropletip' ) {
        $object = get_dropplet_ip( $droplet->getAll( ) );
    }
    return $object;
}

/*function get_data ( $filter, $action, $target ) {
    global $domain;
    global $droplet;
    global $actions;
    if( $action === 'list-all' ) {
        if( $filter === 'domain' ) {
            return $domain->getAll ( );
        }
        if( $filter === 'droplet' ) {
            return $droplet->getAll ( );
        }
        if( $filter === 'actions' ) {
            foreach ( $actions->getAll ( ) AS $action_detail ) {
                $array[] = array(
                            'type'          =>  $action_detail->type,
                            'startedAt'     =>  $action_detail->startedAt,
                            'status'        =>  $action_detail->status,
                            'completedAt'   =>  $action_detail->completedAt
                    );
            }
            return $array;
        }
    } else if( $action === 'shutdown' ) {
        if( $target === '' ) {
            return array(
                    'error'     =>  500,
                    'message'   =>  'you have to specify the droplet id for the shutdown action.'
                );
        } else {

            return $droplet->shutdown ( $target );
        }
    }
}*/

$filter = ( cli_or_not () ? $argv[1] : $_GET['filter'] );
$action = ( cli_or_not () ? $argv[2] : $_GET['action'] );
$target = ( cli_or_not () ? $argv[3] : $_GET['target'] );

/*$get_data = get_data( $filter, $action, $target );

if( cli_or_not ( ) ) {
    print_r( $get_data );
} else {
    echo json_encode( droplet_actions( ) );
}*/
echo json_encode( droplet_actions( $action ) );
//print_r($_GET);
?>