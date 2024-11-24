<?php
require_once 'Conexao.php';

class Chat {
    private $conn;
    private $upload_dir = "../upload/chat/";
    
    public function __construct() {
        $this->conn = Conexao::getInstance();
        
        if (!file_exists($this->upload_dir)) {
            mkdir($this->upload_dir, 0777, true);
        }
    }
    
    public function enviarMensagem($remetente_id, $destinatario_id, $mensagem, $quadra_id = null, $arquivo = null) {
        $tipo_midia = 'texto';
        $nome_arquivo = null;
        
        // Se tiver arquivo, fazer upload
        if ($arquivo && $arquivo['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
            $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi'];
            
            if (!in_array($extensao, $extensoes_permitidas)) {
                throw new Exception('Tipo de arquivo não permitido');
            }
            
            // Definir tipo de mídia
            if (in_array($extensao, ['jpg', 'jpeg', 'png', 'gif'])) {
                $tipo_midia = 'imagem';
            } else {
                $tipo_midia = 'video';
            }
            
            // Gerar nome único para o arquivo
            $nome_arquivo = uniqid() . '.' . $extensao;
            $caminho_arquivo = $this->upload_dir . $nome_arquivo;
            
            // Fazer upload do arquivo
            if (!move_uploaded_file($arquivo['tmp_name'], $caminho_arquivo)) {
                throw new Exception('Erro ao fazer upload do arquivo');
            }
        }
        
        $sql = "INSERT INTO mensagens (remetente_id, destinatario_id, mensagem, quadra_id, tipo_midia, arquivo) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $remetente_id, 
            $destinatario_id, 
            $mensagem, 
            $quadra_id, 
            $tipo_midia, 
            $nome_arquivo
        ]);
    }
    
    public function getConversas($usuario_id) {
        $sql = "SELECT DISTINCT 
                    c.id, 
                    CASE 
                        WHEN c.tipo = 'Dono' THEN p.nome_espaco 
                        ELSE c.nome 
                    END as nome,
                    c.imagem_perfil,
                    (SELECT mensagem 
                     FROM mensagens 
                     WHERE (remetente_id = c.id AND destinatario_id = ?) 
                        OR (remetente_id = ? AND destinatario_id = c.id) 
                     ORDER BY data_envio DESC 
                     LIMIT 1) as ultima_mensagem,
                    (SELECT data_envio 
                     FROM mensagens 
                     WHERE (remetente_id = c.id AND destinatario_id = ?) 
                        OR (remetente_id = ? AND destinatario_id = c.id) 
                     ORDER BY data_envio DESC 
                     LIMIT 1) as data_ultima_mensagem,
                    (SELECT COUNT(*) 
                     FROM mensagens 
                     WHERE remetente_id = c.id 
                        AND destinatario_id = ? 
                        AND lida = FALSE) as nao_lidas
                FROM cliente c
                LEFT JOIN proprietario p ON c.id = p.id
                INNER JOIN mensagens m 
                ON (m.remetente_id = c.id AND m.destinatario_id = ?) 
                    OR (m.remetente_id = ? AND m.destinatario_id = c.id)
                GROUP BY c.id
                ORDER BY data_ultima_mensagem DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuario_id, $usuario_id, $usuario_id, $usuario_id, $usuario_id, $usuario_id, $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConversasNaoLidas($usuario_id) {
        $sql = "SELECT COUNT(DISTINCT remetente_id) as total 
                FROM mensagens 
                WHERE destinatario_id = ? 
                AND lida = FALSE";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuario_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    }

    public function getMensagens($remetente_id, $destinatario_id) {
        $sql = "SELECT 
                    m.*,
                    CASE 
                        WHEN c.tipo = 'Dono' THEN p.nome_espaco 
                        ELSE c.nome 
                    END as remetente_nome,
                    c.imagem_perfil,
                    c.tipo as remetente_tipo
                FROM mensagens m
                INNER JOIN cliente c ON m.remetente_id = c.id
                LEFT JOIN proprietario p ON c.id = p.id
                WHERE (remetente_id = ? AND destinatario_id = ?)
                    OR (remetente_id = ? AND destinatario_id = ?)
                ORDER BY data_envio ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$remetente_id, $destinatario_id, $destinatario_id, $remetente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function marcarComoLida($remetente_id, $destinatario_id) {
        $sql = "UPDATE mensagens 
                SET lida = TRUE 
                WHERE remetente_id = ? AND destinatario_id = ? AND lida = FALSE";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$remetente_id, $destinatario_id]);
    }
}