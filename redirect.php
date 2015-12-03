<?php

$client_mac = $_GET['client_mac'];
$base_grant_url = $_GET['base_grant_url'];
$user_continue_url = $_GET['user_continue_url'];
$ap_mac = $_GET['node_mac'];

header('Location: https://www.maniak.com.mx/coniak/fb-requests-index.php?client_mac='.$client_mac.'&base_grant_url='.$base_grant_url.'&user_continue_url='.$base_grant_url.'&node_mac'.$node_mac);