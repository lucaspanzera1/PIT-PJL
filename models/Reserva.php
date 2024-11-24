<?php
require_once 'Conexao.php';
require_once 'Notification.php';

class Reserva {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }
    
    public function reservarQuadra($clienteId, $quadraId, $dataReserva, $horarioInicio, $horarioFim, $valorTotal) {
        try {
            $this->pdo->beginTransaction();
            
            if ($this->verificarSobreposicao($quadraId, $dataReserva, $horarioInicio, $horarioFim)) {
                throw new Exception("O horário selecionado não está totalmente disponível.");
            }
            
            $quadraInfo = $this->obterInformacoesQuadra($quadraId, $clienteId);
            $reservaId = $this->inserirReserva($clienteId, $quadraId, $dataReserva, $horarioInicio, $horarioFim, $valorTotal);
            $this->atualizarHorariosDisponiveis($quadraId, $dataReserva, $horarioInicio, $horarioFim);
            $this->criarNotificacaoProprietario($quadraInfo, $clienteId, $dataReserva, $horarioInicio, $horarioFim, $valorTotal, $reservaId);
            
            $this->pdo->commit();
            return "Reserva realizada com sucesso! Aguarde a confirmação do proprietário! Acesse <a href='../client/reservas.php'>Minhas reservas.</a>";
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return "Erro ao realizar a reserva: " . $e->getMessage();
        }
    }
    
    private function verificarSobreposicao($quadraId, $dataReserva, $horarioInicio, $horarioFim) {
        $stmt = $this->pdo->prepare("SELECT * FROM horarios_disponiveis 
                               WHERE quadra_id = :quadra_id 
                               AND data = :data 
                               AND (horario_inicio < :horario_fim AND horario_fim > :horario_inicio)
                               AND status != 'disponível'");
        $stmt->execute([
            ':quadra_id' => $quadraId,
            ':data' => $dataReserva,
            ':horario_inicio' => $horarioInicio,
            ':horario_fim' => $horarioFim
        ]);
        
        return $stmt->rowCount() > 0;
    }
    
    private function obterInformacoesQuadra($quadraId, $clienteId) {
        $stmt = $this->pdo->prepare("SELECT q.*, p.id as proprietario_id, p.nome_espaco, c.nome as cliente_nome 
                               FROM quadra q 
                               JOIN proprietario p ON q.proprietario_id = p.id 
                               JOIN cliente c ON c.id = :cliente_id 
                               WHERE q.id = :quadra_id");
        $stmt->execute([
            ':quadra_id' => $quadraId,
            ':cliente_id' => $clienteId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function inserirReserva($clienteId, $quadraId, $dataReserva, $horarioInicio, $horarioFim, $valorTotal) {
        $stmt = $this->pdo->prepare("INSERT INTO reservas (cliente_id, quadra_id, data, horario_inicio, horario_fim, valor) 
                               VALUES (:cliente_id, :quadra_id, :data, :horario_inicio, :horario_fim, :valor)");
        $stmt->execute([
            ':cliente_id' => $clienteId,
            ':quadra_id' => $quadraId,
            ':data' => $dataReserva,
            ':horario_inicio' => $horarioInicio,
            ':horario_fim' => $horarioFim,
            ':valor' => $valorTotal
        ]);
        
        return $this->pdo->lastInsertId();
    }
    
    private function atualizarHorariosDisponiveis($quadraId, $dataReserva, $horarioInicio, $horarioFim) {
        $stmt = $this->pdo->prepare("SELECT * FROM horarios_disponiveis 
                               WHERE quadra_id = :quadra_id 
                               AND data = :data 
                               AND (horario_inicio < :horario_fim AND horario_fim > :horario_inicio)");
        $stmt->execute([
            ':quadra_id' => $quadraId,
            ':data' => $dataReserva,
            ':horario_inicio' => $horarioInicio,
            ':horario_fim' => $horarioFim
        ]);
        
        $horariosDisponiveis = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($horariosDisponiveis as $horarioDisponivel) {
            $this->processarHorarioDisponivel($horarioDisponivel, $horarioInicio, $horarioFim, $quadraId, $dataReserva);
        }
    }
    
    private function processarHorarioDisponivel($horarioDisponivel, $horarioInicio, $horarioFim, $quadraId, $dataReserva) {
        $inicioDisponivel = strtotime($horarioDisponivel['horario_inicio']);
        $fimDisponivel = strtotime($horarioDisponivel['horario_fim']);
        $inicioReserva = strtotime($horarioInicio);
        $fimReserva = strtotime($horarioFim);
        
        if ($inicioReserva <= $inicioDisponivel && $fimReserva >= $fimDisponivel) {
            $this->atualizarStatusHorario($horarioDisponivel['id'], 'pendente');
        } else {
            $this->ajustarHorariosParciaisReserva($horarioDisponivel, $inicioReserva, $fimReserva, $quadraId, $dataReserva);
        }
    }
    
    private function criarNotificacaoProprietario($quadraInfo, $clienteId, $dataReserva, $horarioInicio, $horarioFim, $valorTotal, $reservaId) {
        $notification = new Notification();
        $mensagem = "Nova reserva realizada por " . $quadraInfo['cliente_nome'] . " em " . $quadraInfo['nome_espaco'] . " " . 
                    $quadraInfo['nome'] . " no dia " . date('d/m/Y', strtotime($dataReserva)) . 
                    " às " . date('H:i', strtotime($horarioInicio)) . 
                    " até " . date('H:i', strtotime($horarioFim)) . 
                    ". Valor: R$ " . number_format($valorTotal, 2, ',', '.');
        
        $notification->criarNotificacao(
            $quadraInfo['proprietario_id'],
            $clienteId,
            'nova_reserva',
            $mensagem,
            $reservaId
        );
    }
    
    private function atualizarStatusHorario($horarioId, $status) {
        $stmt = $this->pdo->prepare("UPDATE horarios_disponiveis SET status = :status WHERE id = :horario_id");
        $stmt->execute([
            ':status' => $status,
            ':horario_id' => $horarioId
        ]);
    }
    
    private function ajustarHorariosParciaisReserva($horarioDisponivel, $inicioReserva, $fimReserva, $quadraId, $dataReserva) {
        if ($inicioReserva > strtotime($horarioDisponivel['horario_inicio'])) {
            $stmt = $this->pdo->prepare("UPDATE horarios_disponiveis 
                                   SET horario_fim = :novo_fim 
                                   WHERE id = :horario_id");
            $stmt->execute([
                ':novo_fim' => date('H:i:s', $inicioReserva),
                ':horario_id' => $horarioDisponivel['id']
            ]);
        }

        if ($fimReserva < strtotime($horarioDisponivel['horario_fim'])) {
            $stmt = $this->pdo->prepare("INSERT INTO horarios_disponiveis 
                                   (quadra_id, data, horario_inicio, horario_fim, status) 
                                   VALUES (:quadra_id, :data, :novo_inicio, :horario_fim, 'disponível')");
            $stmt->execute([
                ':quadra_id' => $quadraId,
                ':data' => $dataReserva,
                ':novo_inicio' => date('H:i:s', $fimReserva),
                ':horario_fim' => $horarioDisponivel['horario_fim']
            ]);
        }

        $stmt = $this->pdo->prepare("UPDATE horarios_disponiveis 
                               SET horario_fim = :novo_fim, status = 'pendente' 
                               WHERE id = :horario_id");
        $stmt->execute([
            ':novo_fim' => date('H:i:s', $fimReserva),
            ':horario_id' => $horarioDisponivel['id']
        ]);
    }

    public function cancelarReserva($reservaId) {
        try {
            $this->pdo->beginTransaction();
            
            $reserva = $this->obterDetalhesReserva($reservaId);
            if (!$reserva) {
                throw new Exception("Reserva não encontrada.");
            }
            
            $this->excluirReserva($reservaId);
            $this->atualizarHorariosDisponiveisCancelamento(
                $reserva['quadra_id'],
                $reserva['data'],
                $reserva['horario_inicio'],
                $reserva['horario_fim']
            );
            
            $this->pdo->commit();
            return "Reserva cancelada com sucesso!";
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return "Erro ao cancelar a reserva: " . $e->getMessage();
        }
    }
    
    private function obterDetalhesReserva($reservaId) {
        $stmt = $this->pdo->prepare("SELECT quadra_id, data, horario_inicio, horario_fim 
                                    FROM reservas 
                                    WHERE id = :reserva_id");
        $stmt->execute([':reserva_id' => $reservaId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function excluirReserva($reservaId) {
        $stmt = $this->pdo->prepare("DELETE FROM reservas WHERE id = :reserva_id");
        $stmt->execute([':reserva_id' => $reservaId]);
    }
    
    private function atualizarHorariosDisponiveisCancelamento($quadraId, $dataReserva, $horarioInicio, $horarioFim) {
        $horariosDisponiveis = $this->buscarHorariosDisponiveis($quadraId, $dataReserva, $horarioInicio, $horarioFim);
        
        foreach ($horariosDisponiveis as $horario) {
            $this->processarHorarioDisponiveisCancelamento(
                $horario,
                $horarioInicio,
                $horarioFim,
                $quadraId,
                $dataReserva
            );
        }
    }
    
    private function buscarHorariosDisponiveis($quadraId, $dataReserva, $horarioInicio, $horarioFim) {
        $stmt = $this->pdo->prepare("SELECT * FROM horarios_disponiveis 
                                    WHERE quadra_id = :quadra_id 
                                    AND data = :data 
                                    AND (horario_inicio <= :horario_fim AND horario_fim >= :horario_inicio)");
        $stmt->execute([
            ':quadra_id' => $quadraId,
            ':data' => $dataReserva,
            ':horario_inicio' => $horarioInicio,
            ':horario_fim' => $horarioFim
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function processarHorarioDisponiveisCancelamento($horario, $horarioInicio, $horarioFim, $quadraId, $dataReserva) {
        $inicioDisponivel = strtotime($horario['horario_inicio']);
        $fimDisponivel = strtotime($horario['horario_fim']);
        $inicioReserva = strtotime($horarioInicio);
        $fimReserva = strtotime($horarioFim);
        
        if ($inicioReserva <= $inicioDisponivel && $fimReserva >= $fimDisponivel) {
            $this->atualizarStatusHorario($horario['id'], 'disponível');
        } else {
            $this->ajustarHorariosParciaisCancelamento(
                $horario,
                $inicioReserva,
                $fimReserva,
                $quadraId,
                $dataReserva
            );
        }
    }
    
    private function ajustarHorariosParciaisCancelamento($horario, $inicioReserva, $fimReserva, $quadraId, $dataReserva) {
        if ($inicioReserva > strtotime($horario['horario_inicio'])) {
            $stmt = $this->pdo->prepare("UPDATE horarios_disponiveis 
                                        SET horario_fim = :novo_fim 
                                        WHERE id = :horario_id");
            $stmt->execute([
                ':novo_fim' => date('H:i:s', $inicioReserva),
                ':horario_id' => $horario['id']
            ]);
        }
        
        if ($fimReserva < strtotime($horario['horario_fim'])) {
            $stmt = $this->pdo->prepare("INSERT INTO horarios_disponiveis 
                                        (quadra_id, data, horario_inicio, horario_fim, status) 
                                        VALUES (:quadra_id, :data, :novo_inicio, :horario_fim, 'disponível')");
            $stmt->execute([
                ':quadra_id' => $quadraId,
                ':data' => $dataReserva,
                ':novo_inicio' => date('H:i:s', $fimReserva),
                ':horario_fim' => $horario['horario_fim']
            ]);
        }
    }
    public function getReservasByClientId($clienteId) {
        try {
            $stmt = $this->pdo->prepare('
                SELECT 
                    r.*,
                    q.nome AS nome_quadra,
                    p.nome_espaco AS nome_proprietario,
                    DATE_FORMAT(r.data, "%d/%m/%Y") AS data_formatada,
                    TIME_FORMAT(r.horario_inicio, "%H:%i") AS horario_inicio_formatado,
                    TIME_FORMAT(r.horario_fim, "%H:%i") AS horario_fim_formatado
                FROM reservas r
                JOIN quadra q ON r.quadra_id = q.id
                JOIN proprietario p ON q.proprietario_id = p.id
                WHERE r.cliente_id = :cliente_id
                ORDER BY r.data DESC, r.horario_inicio DESC
            ');
            
            $stmt->execute([':cliente_id' => $clienteId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

}
?>