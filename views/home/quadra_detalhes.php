<?php
require_once '../../models/Owner.php';
require_once '../../models/Client.php';
require_once '../../models/User.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo = Conexao::getInstance();

    // Consulta para buscar os detalhes da quadra
    $sql = "SELECT q.*, iq.nome_imagem 
            FROM quadra q
            LEFT JOIN imagem_quadra iq ON q.id = iq.id_dono
            WHERE q.id = :id";
    
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // Verifica se a quadra foi encontrada
    $quadra = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$quadra) {
        echo "Quadra não encontrada.";
        exit;
    }
} else {
    echo "ID da quadra não foi fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Quadra</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($quadra['nome_quadra']); ?></h1>
    <p>Esporte: <?php echo htmlspecialchars($quadra['esporte']); ?></p>
    <p>Valor: R$<?php echo number_format($quadra['valor'], 2, ',', '.'); ?> por hora</p>
    
    <?php if (!empty($quadra['nome_imagem'])): ?>
        <img src="../../upload/quadra_img/<?php echo htmlspecialchars($quadra['nome_imagem']); ?>" alt="Imagem da quadra">
    <?php else: ?>
        <p>Sem imagem disponível</p>
    <?php endif; ?>

    <p>Descrição: <?php echo htmlspecialchars($quadra['descricao']); ?></p>
    <!-- Adicione mais informações conforme necessário -->
</body>
</html>
