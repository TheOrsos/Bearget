<?php
// File: add_note.php (Versione AJAX)
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accesso non autorizzato.']);
    exit;
}

$user_id = $_SESSION["id"];
$title = "Nuova Nota";
$content = "";
$todolist_content = "[]"; // Inizia con una to-do list vuota

$sql = "INSERT INTO notes (user_id, title, content, todolist_content) VALUES (?, ?, ?, ?)";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("isss", $user_id, $title, $content, $todolist_content);
    if ($stmt->execute()) {
        $new_note_id = $conn->insert_id;
        echo json_encode([
            'success' => true,
            'message' => 'Nota creata!',
            'note' => [
                'id' => $new_note_id,
                'title' => $title,
                'content' => $content,
                'todolist_content' => $todolist_content,
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Errore durante la creazione della nota.']);
    }
    $stmt->close();
}
$conn->close();
exit();
?>