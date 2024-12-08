$(document).ready(function() {
    function loadConfig() {
        $.ajax({
            url: CFG_GLPI.root_doc + '/plugins/ticketvisibility/ajax/getconfig.php',
            method: 'GET',
            success: function(config) {
                applyVisibilityRules(config);
            }
        });
    }

    function applyVisibilityRules(config) {
        // Função para ocultar botões do footer
        const hideFooterButtons = () => {
            // Mapeamento dos botões
            const buttons = {
                'hide_responder': 'Responder',
                'hide_tarefa': 'Tarefa',
                'hide_solucao': 'Solução',
                'hide_documento': 'Documento',
                'hide_validacao': 'Validação'
            };

            // Procura por todos os botões no footer
            $('.itil-footer button, .itil-footer a').each(function() {
                const buttonText = $(this).text().trim();
                
                // Verifica cada configuração
                Object.entries(buttons).forEach(([configKey, buttonLabel]) => {
                    if (config[configKey] == 1 && buttonText.includes(buttonLabel)) {
                        $(this).hide();
                    }
                });
            });
        };

        // Função para ocultar status
        const hideStatus = () => {
            const statusMap = {
                'hide_novo': 'novo',
                'hide_em_atendimento_atribuido': 'em atendimento (atribuído)',
                'hide_em_atendimento_planejado': 'em atendimento (planejado)',
                'hide_pendente': 'pendente',
                'hide_solucionado': 'solucionado',
                'hide_fechado': 'fechado'
            };

            $('select[name="status"] option, select[name*="status"] option').each(function() {
                const optionText = $(this).text().toLowerCase().trim();
                Object.keys(statusMap).forEach(configKey => {
                    if (config[configKey] == 1 && optionText === statusMap[configKey]) {
                        $(this).remove();
                    }
                });
            });
        };

        // Aplica as regras
        hideFooterButtons();
        hideStatus();

        // Adiciona CSS para garantir que os botões permaneçam ocultos
        const style = document.createElement('style');
        style.innerHTML = Object.keys(buttons).map(key => {
            if (config[key] == 1) {
                return `
                    .itil-footer button:contains("${buttons[key]}"),
                    .itil-footer a:contains("${buttons[key]}") {
                        display: none !important;
                    }
                `;
            }
        }).join('\n');
        document.head.appendChild(style);
    }

    // Função para observar mudanças no DOM
    function setupObserver() {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length > 0) {
                    // Se os novos nós contêm buttons ou links, reaplica as regras
                    mutation.addedNodes.forEach(node => {
                        if (node.classList && 
                            (node.classList.contains('itil-footer') || 
                             node.querySelector('.itil-footer'))) {
                            loadConfig();
                        }
                    });
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    // Aplica as regras em diferentes momentos
    loadConfig();
    setupObserver();

    // Quando qualquer AJAX é completado
    $(document).ajaxComplete(function() {
        loadConfig();
    });

    // Quando o documento está pronto
    $(document).ready(function() {
        loadConfig();
    });

    // Para garantir que pegue alterações dinâmicas
    setInterval(loadConfig, 1000);
});