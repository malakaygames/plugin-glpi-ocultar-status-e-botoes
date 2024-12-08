<?php
class TicketVisibility extends CommonDBTM {
    private static function getConfig() {
        global $DB;
        $config = $DB->request([
            'FROM' => 'glpi_plugin_ticketvisibility_configs',
            'WHERE' => ['id' => 1]
        ])->current();
        return $config;
    }

    public static function hideElements($params) {
        if (isset($params['item']) && $params['item'] instanceof Ticket) {
            $config = self::getConfig();
            
            $script = "<script type='text/javascript'>";
            $script .= "document.addEventListener('DOMContentLoaded', function() {
                const config = " . json_encode($config) . ";

                function hideButtons() {
                    // Mapeamento de botões com suas classes específicas
                    const buttonMap = {
                        'hide_responder': '[data-bs-target=\"#new-ITILFollowup-block\"]',
                        'hide_tarefa': '[data-bs-target=\"#new-ITILTask-block\"]',
                        'hide_solucao': '[data-bs-target=\"#new-ITILSolution-block\"]',
                        'hide_documento': '[data-bs-target=\"#new-Document_Item-block\"]',
                        'hide_validacao': '[data-bs-target=\"#new-ITILValidation-block\"]'
                    };

                    // Itera sobre o mapa de botões e oculta conforme configuração
                    Object.keys(buttonMap).forEach(configKey => {
                        if (config[configKey]) {
                            const button = document.querySelector(buttonMap[configKey]);
                            if (button) {
                                button.style.setProperty('display', 'none', 'important');
                            }
                        }
                    });
                }

                function hideStatus() {
                    const statusSelect = document.querySelector('select[name=\"status\"]');
                    if (!statusSelect) return;

                    const statusMap = {
                        'hide_novo': 'novo',
                        'hide_em_atendimento_atribuido': 'em atendimento (atribuído)',
                        'hide_em_atendimento_planejado': 'em atendimento (planejado)',
                        'hide_pendente': 'pendente',
                        'hide_solucionado': 'solucionado',
                        'hide_fechado': 'fechado'
                    };

                    Array.from(statusSelect.options).forEach(option => {
                        const optionText = option.text.toLowerCase().trim();
                        Object.keys(statusMap).forEach(configKey => {
                            if (config[configKey] && optionText === statusMap[configKey]) {
                                option.remove();
                            }
                        });
                    });
                }

                // Função para observar mudanças dinâmicas
                function setupObserver() {
                    const observer = new MutationObserver(() => {
                        hideButtons();
                        hideStatus();
                    });

                    observer.observe(document.body, {
                        childList: true,
                        subtree: true
                    });
                }

                // Execução inicial
                hideButtons();
                hideStatus();
                setupObserver();

                // Adiciona listener para quando o DOM é modificado dinamicamente
                document.addEventListener('DOMNodeInserted', function(e) {
                    if (e.target.classList && e.target.classList.contains('itil-footer')) {
                        hideButtons();
                    }
                });
            });";
            $script .= "</script>";
            
            echo $script;
        }
    }
}