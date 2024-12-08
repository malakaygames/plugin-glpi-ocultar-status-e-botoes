<?php
function plugin_ticketvisibility_install() {
    global $DB;

    if (!$DB->tableExists("glpi_plugin_ticketvisibility_configs")) {
        $query = "CREATE TABLE `glpi_plugin_ticketvisibility_configs` (
            `id` int NOT NULL AUTO_INCREMENT,
            `hide_responder` tinyint(1) NOT NULL DEFAULT '0',
            `hide_tarefa` tinyint(1) NOT NULL DEFAULT '0',
            `hide_solucao` tinyint(1) NOT NULL DEFAULT '0',
            `hide_documento` tinyint(1) NOT NULL DEFAULT '0',
            `hide_validacao` tinyint(1) NOT NULL DEFAULT '0',
            `hide_novo` tinyint(1) NOT NULL DEFAULT '0',
            `hide_em_atendimento_atribuido` tinyint(1) NOT NULL DEFAULT '0',
            `hide_em_atendimento_planejado` tinyint(1) NOT NULL DEFAULT '0',
            `hide_pendente` tinyint(1) NOT NULL DEFAULT '0',
            `hide_solucionado` tinyint(1) NOT NULL DEFAULT '0',
            `hide_fechado` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $DB->query($query);
        $DB->query("INSERT INTO `glpi_plugin_ticketvisibility_configs` VALUES (1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
    }
    return true;
}

function plugin_ticketvisibility_uninstall() {
    global $DB;
    $DB->query("DROP TABLE IF EXISTS `glpi_plugin_ticketvisibility_configs`");
    return true;
}