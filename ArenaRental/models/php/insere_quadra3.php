<?php
require('../../controllers/conexao.php');
include '../../models/php/funcao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtendo os valores dos campos do formulário
    $hora_abre = $_POST['hora-abre'];
    $hora_fecha = $_POST['hora-fecha'];
    $dias_semana = isset($_POST['dias']) ? $_POST['dias'] : []; // Captura os dias selecionados

    // Obtenha o usuário atual
    $id_user = $_SESSION['id'];
    $nome_dono = $_SESSION['nome'];

    // Buscar os dados do usuário no banco de dados
    $sql = "SELECT * FROM quadra WHERE id_user = :id_user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->execute();
    $quadra = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($quadra) {
        // Remover espaços e caracteres especiais do nome da quadra para evitar problemas no nome da tabela
        $nome_tabela = 'intervalos_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $id_user);

        // Validar os dados
        if (!empty($hora_abre) && !empty($hora_fecha)) {
            try {
                // Iniciar transação
                if (!$pdo->inTransaction()) {
                    $pdo->beginTransaction();
                }

                // Atualizar os dados na tabela quadra
                $sql = "UPDATE quadra SET horario_abre = :hora_abre, horario_fecha = :hora_fecha WHERE id_user = :id_user";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':hora_abre', $hora_abre);
                $stmt->bindParam(':hora_fecha', $hora_fecha);
                $stmt->bindParam(':id_user', $id_user);
                $stmt->execute();

                // Criar a nova tabela dinamicamente para os intervalos (se ainda não existir)
                $sql = "CREATE TABLE IF NOT EXISTS $nome_tabela (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    horario VARCHAR(13) NOT NULL,
                    data DATE NOT NULL,
                    dia_semana VARCHAR(20) NOT NULL,
                    disponivel BOOLEAN NOT NULL DEFAULT TRUE
                )";
                $pdo->exec($sql);

                // Exibir mensagem de sucesso
                echo "<h2>Tabela '$nome_tabela' criada com sucesso!</h2>";

                // Exibir os dias da semana selecionados
                echo "<h3>Dias da semana selecionados:</h3>";
                echo "<ul>";
                foreach ($dias_semana as $dia) {
                    echo "<li>" . htmlspecialchars($dia) . "</li>";
                }
                echo "</ul>";

                // Identificar o dia e a data atual
                $dataAtual = date('d/m/Y'); // Ex: 15/08/2024
                echo "<p>Hoje é $dataAtual.</p>";

                // Mapeamento de nomes de dias da semana em inglês para português
                $diasMap = [
                    'domingo' => 'Sunday',
                    'segunda' => 'Monday',
                    'terca' => 'Tuesday',
                    'quarta' => 'Wednesday',
                    'quinta' => 'Thursday',
                    'sexta' => 'Friday',
                    'sabado' => 'Saturday'
                ];

                // Array para armazenar as datas organizadas por semana
                $datasPorSemana = [];

                $hoje = new DateTime();
                $ultimoDiaMes = new DateTime('last day of this month');

                // Inicializar o array de semanas
                $semanaAtual = 1;
                while ($hoje <= $ultimoDiaMes) {
                    $diaSemana = strtolower($hoje->format('l')); // Nome do dia em inglês (lowercase)
                    $diaPortugues = array_search($diaSemana, array_map('strtolower', $diasMap));

                    // Se a data atual for um dos dias selecionados, adicione ao array correspondente
                    if (in_array($diaPortugues, $dias_semana)) {
                        $datasPorSemana[$semanaAtual][$diaPortugues] = $hoje->format('d/m/Y');

                        // Inserir todos os horários disponíveis para esta data na tabela
                        list($abreHora, $abreMinuto) = explode(':', $hora_abre);
                        list($fechaHora, $fechaMinuto) = explode(':', $hora_fecha);

                        while ($abreHora < $fechaHora || ($abreHora == $fechaHora && $abreMinuto < $fechaMinuto)) {
                            $fimHora = ($abreMinuto + 60) >= 60 ? $abreHora + 1 : $abreHora;
                            $fimMinuto = ($abreMinuto + 60) % 60;

                            if ($fimHora > 23) break;

                            $horario_inicio = sprintf("%02d:%02d", $abreHora, $abreMinuto);
                            $horario_fim = sprintf("%02d:%02d", $fimHora, $fimMinuto);
                            $intervalo_completo = $horario_inicio . " - " . $horario_fim;

                            $data = $hoje->format('Y-m-d'); // Formato de data para o banco de dados

                            // Inserir o horário, a data e a disponibilidade na tabela
                            $sql = "INSERT INTO $nome_tabela (horario, data, dia_semana, disponivel) VALUES (:horario, :data, :dia_semana, TRUE)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':horario', $intervalo_completo);
                            $stmt->bindParam(':data', $data);
                            $stmt->bindParam(':dia_semana', $diaPortugues);
                            $stmt->execute();

                            // Avançar para o próximo intervalo
                            $abreHora = $fimHora;
                            $abreMinuto = $fimMinuto;
                        }
                    }

                    // Avance para o próximo dia
                    $hoje->modify('+1 day');

                    // Verificar se começou uma nova semana
                    if ($hoje->format('w') == 0) { // Se for domingo, começa uma nova semana
                        $semanaAtual++;
                    }
                }

                // Exibir os dados presentes na nova tabela de intervalos
                echo "<h3>Informações na tabela '$nome_tabela':</h3>";

                // Selecionar e exibir todos os registros da tabela criada
                $sql = "SELECT * FROM $nome_tabela ORDER BY data, horario";
                $stmt = $pdo->query($sql);
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($resultados) > 0) {
                    echo "<table border='1'>
                            <tr>
                                <th>ID</th>
                                <th>Horário</th>
                                <th>Data</th>
                                <th>Dia da Semana</th>
                                <th>Disponível</th>
                            </tr>";
                    foreach ($resultados as $row) {
                        // Converter a data para o formato d/m/Y para exibição
                        $dataFormatada = (new DateTime($row['data']))->format('d/m/Y');

                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['horario'] . "</td>
                                <td>" . $dataFormatada . "</td>
                                <td>" . $row['dia_semana'] . "</td>
                                <td>" . ($row['disponivel'] ? 'Sim' : 'Não') . "</td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Nenhum dado encontrado na tabela '$nome_tabela'.</p>";
                }

                // Confirmar transação
                if ($pdo->inTransaction()) {
                    $pdo->commit();
                }

            } catch (PDOException $e) {
                // Reverter transação em caso de erro, se estiver ativa
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                echo "Erro: " . $e->getMessage();
            }
        } else {
            echo "Por favor, preencha todos os campos.";
        }
    } else {
        echo "Quadra não encontrada para o usuário atual.";
    }
} else {
    echo "Método de requisição não suportado.";
}
?>
