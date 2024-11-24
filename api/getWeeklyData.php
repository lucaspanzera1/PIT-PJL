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
$periodo = $_GET['periodo'] ?? 'semana';
$dataInicio = $_GET['dataInicio'] ?? null;
$dataFim = $_GET['dataFim'] ?? null;

try {
    $data = Owner::getWeeklyOcupacaoData($ownerId, $periodo, $dataInicio, $dataFim);
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erro ao buscar dados: ' . $e->getMessage()]);
}
?>