<?php
session_start();

error_reporting(0);
ini_set('display_errors', 0);

require_once '../models/Owner.php';

if (!isset($_SESSION['client']['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'ID do proprietário não encontrado.']);
    exit;
}

$ownerId = $_SESSION['client']['id'];
$mes = isset($_GET['mes']) ? intval($_GET['mes']) : null;
$ano = isset($_GET['ano']) ? intval($_GET['ano']) : null;

try {
    $data = Owner::getDistribuicaoReservas($ownerId, $mes, $ano);
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erro ao buscar dados: ' . $e->getMessage()]);
}

?>