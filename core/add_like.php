<?php
require_once 'db_functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendErrorResponse('Method not allowed');
    exit;
}

$conn = connect_to_db();

$user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
$post_id = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';

if (empty($user_id) || empty($post_id)) {
    sendErrorResponse('Invalid request: missing user_id or post_id parameter');
    exit;
}

$success = add_like($conn, $user_id, $post_id);

if ($success) {
    sendSuccessResponse();
} else {
    sendErrorResponse('Unable to add the like');
}

function sendSuccessResponse()
{
    sendJsonResponse(['success' => true]);
}

function sendErrorResponse($error)
{
    sendJsonResponse(['success' => false, 'error' => $error]);
}

function sendJsonResponse($response)
{
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
