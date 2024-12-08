<?php
include ("../../../inc/includes.php");

// Verifica permissões
Session::checkRight("config", UPDATE);

global $DB;

// Se for uma atualização
if (isset($_POST['update'])) {
    $input = [
        'id' => 1,
        'hide_responder' => isset($_POST['hide_responder']) ? 1 : 0,
        'hide_tarefa' => isset($_POST['hide_tarefa']) ? 1 : 0,
        'hide_solucao' => isset($_POST['hide_solucao']) ? 1 : 0,
        'hide_documento' => isset($_POST['hide_documento']) ? 1 : 0,
        'hide_validacao' => isset($_POST['hide_validacao']) ? 1 : 0,
        'hide_novo' => isset($_POST['hide_novo']) ? 1 : 0,
        'hide_em_atendimento_atribuido' => isset($_POST['hide_em_atendimento_atribuido']) ? 1 : 0,
        'hide_em_atendimento_planejado' => isset($_POST['hide_em_atendimento_planejado']) ? 1 : 0,
        'hide_pendente' => isset($_POST['hide_pendente']) ? 1 : 0,
        'hide_solucionado' => isset($_POST['hide_solucionado']) ? 1 : 0,
        'hide_fechado' => isset($_POST['hide_fechado']) ? 1 : 0
    ];
    
    $DB->update(
        'glpi_plugin_ticketvisibility_configs',
        $input,
        ['id' => 1]
    );
    
    Session::addMessageAfterRedirect("Configurações salvas com sucesso!");
}

// Busca configuração atual
$config = $DB->request([
    'FROM' => 'glpi_plugin_ticketvisibility_configs',
    'WHERE' => ['id' => 1]
])->current();

Html::header('Ticket Visibility Control', $_SERVER["PHP_SELF"], 'config', 'plugins');

// Formulário
echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
echo "<div class='center'>";
echo "<table class='tab_cadre_fixe'>";

echo "<tr><th colspan='2'>Configurações de Visibilidade dos Botões</th></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar botão Responder</td>";
echo "<td><input type='checkbox' name='hide_responder' ".($config['hide_responder'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar botão Tarefa</td>";
echo "<td><input type='checkbox' name='hide_tarefa' ".($config['hide_tarefa'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar botão Solução</td>";
echo "<td><input type='checkbox' name='hide_solucao' ".($config['hide_solucao'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar botão Documento</td>";
echo "<td><input type='checkbox' name='hide_documento' ".($config['hide_documento'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar botão Validação</td>";
echo "<td><input type='checkbox' name='hide_validacao' ".($config['hide_validacao'] ? 'checked' : '')."></td></tr>";

echo "<tr><th colspan='2'>Configurações de Visibilidade dos Status</th></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar status Novo</td>";
echo "<td><input type='checkbox' name='hide_novo' ".($config['hide_novo'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar status Em atendimento (atribuído)</td>";
echo "<td><input type='checkbox' name='hide_em_atendimento_atribuido' ".($config['hide_em_atendimento_atribuido'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar status Em atendimento (planejado)</td>";
echo "<td><input type='checkbox' name='hide_em_atendimento_planejado' ".($config['hide_em_atendimento_planejado'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar status Pendente</td>";
echo "<td><input type='checkbox' name='hide_pendente' ".($config['hide_pendente'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar status Solucionado</td>";
echo "<td><input type='checkbox' name='hide_solucionado' ".($config['hide_solucionado'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_1'><td>Ocultar status Fechado</td>";
echo "<td><input type='checkbox' name='hide_fechado' ".($config['hide_fechado'] ? 'checked' : '')."></td></tr>";

echo "<tr class='tab_bg_2'><td colspan='2' class='center'>";
echo "<input type='submit' name='update' value='Salvar' class='submit'>";
echo "</td></tr>";

echo "</table>";
echo "</div>";
Html::closeForm();

Html::footer();