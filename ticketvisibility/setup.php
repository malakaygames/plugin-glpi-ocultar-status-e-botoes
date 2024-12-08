<?php
define('TICKETVISIBILITY_VERSION', '1.0.0');

function plugin_init_ticketvisibility() {
    global $PLUGIN_HOOKS;
    
    $PLUGIN_HOOKS['csrf_compliant']['ticketvisibility'] = true;
    
    if (Session::getLoginUserID()) {
        // Hook para o formulário padrão
        $PLUGIN_HOOKS['post_item_form']['ticketvisibility'] = ['TicketVisibility', 'hideElements'];
        
        // Hooks para interceptar carregamentos AJAX
        $PLUGIN_HOOKS['post_show_item']['ticketvisibility'] = ['TicketVisibility', 'hideElements'];
        $PLUGIN_HOOKS['post_show_tab']['ticketvisibility'] = ['TicketVisibility', 'hideElements'];
        
        // Hook para modificar o JavaScript do GLPI
        $PLUGIN_HOOKS['add_javascript']['ticketvisibility'] = 'js/ticketvisibility.js';
        
        // Hook para carregar CSS personalizado
        $PLUGIN_HOOKS['add_css']['ticketvisibility'] = 'css/ticketvisibility.css';
    }

    if (Session::haveRight("config", UPDATE)) {
        $PLUGIN_HOOKS['config_page']['ticketvisibility'] = 'front/config.form.php';
    }
}

function plugin_version_ticketvisibility() {
    return [
        'name'           => 'Ticket Visibility Control',
        'version'        => TICKETVISIBILITY_VERSION,
        'author'         => 'Adriano Marinho',
        'license'        => 'GPLv2+',
        'homepage'       => 'https://github.com/malakaygames',
        'requirements'   => [
            'glpi'   => [
                'min' => '9.5',
                'max' => '10.1'
            ]
        ]
    ];
}

function plugin_ticketvisibility_check_prerequisites() {
    return true;
}

function plugin_ticketvisibility_check_config() {
    return true;
}