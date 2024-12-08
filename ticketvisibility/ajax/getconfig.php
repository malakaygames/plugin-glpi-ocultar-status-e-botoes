<?php
include ("../../../inc/includes.php");

header("Content-Type: application/json");

// Verifica sessão
Session::checkLoginUser();

global $DB;

$config = $DB->request([
    'FROM' => 'glpi_plugin_ticketvisibility_configs',
    'WHERE' => ['id' => 1]
])->current();

echo json_encode($config);