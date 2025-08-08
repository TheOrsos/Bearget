<?php
// File: update_note.php (Versione AJAX)
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accesso non autorizzato.']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["id"];
    $note_id = trim($_POST['note_id']);
    $title = trim($_POST['title']);
    $content = $_POST['content'];
    $todolist_content = $_POST['todolist_content'];

    if (empty($note_id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'ID nota mancante.']);
        exit();
    }
    if (empty($title)) {
        $title = "Senza Titolo";
    }

    $sql = "UPDATE notes SET title = ?, content = ?, todolist_content = ? WHERE id = ? AND user_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssii", $title, $content, $todolist_content, $note_id, $user_id);
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Nota salvata!',
                'note' => [
                    'id' => intval($note_id),
                    'title' => $title,
                    'content' => $content,
                    'todolist_content' => $todolist_content
                ]
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Errore durante il salvataggio.']);
        }
        $stmt->close();
    }
    $conn->close();
    exit();
}
?>
