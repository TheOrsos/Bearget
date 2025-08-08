<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
require_once 'db_connect.php';
require_once 'functions.php';

$user_id = $_SESSION["id"];
$notes = get_notes_for_user($conn, $user_id);
$current_page = 'notes';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note - Bearget</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="theme.php">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 500: 'var(--color-primary-500)', 600: 'var(--color-primary-600)', 700: 'var(--color-primary-700)' },
                        gray: { 100: 'var(--color-gray-100)', 200: 'var(--color-gray-200)', 300: 'var(--color-gray-300)', 400: 'var(--color-gray-400)', 700: 'var(--color-gray-700)', 800: 'var(--color-gray-800)', 900: 'var(--color-gray-900)' },
                        success: 'var(--color-success)', danger: 'var(--color-danger)', warning: 'var(--color-warning)'
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: var(--color-gray-900); }
        .modal-backdrop { transition: opacity 0.3s ease-in-out; }
        .modal-content { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
        .row-fade-out { transition: opacity 0.5s ease-out; opacity: 0; }
    </style>
</head>
<body class="text-gray-300">
    <div class="flex h-screen">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 p-6 lg:p-10 overflow-y-auto">
            <header class="flex flex-wrap justify-between items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Le Tue Note
                    </h1>
                    <p class="text-gray-400 mt-1">Crea note, appunti e liste di cose da fare.</p>
                </div>
                <button id="add-note-btn" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-5 rounded-lg flex items-center transition-colors shadow-lg hover:shadow-primary-500/50">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Nuova Nota
                </button>
            </header>
            
            <div id="notes-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php if (empty($notes)): ?>
                    <div id="empty-state-notes" class="md:col-span-2 xl:col-span-4 text-center py-10">
                        <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <h3 class="mt-2 text-sm font-medium text-white">Nessuna nota trovata</h3>
                        <p class="mt-1 text-sm text-gray-500">Crea la tua prima nota per iniziare.</p>
                    </div>
                <?php else: foreach ($notes as $note): ?>
                <div class="block bg-gray-800 hover:bg-gray-700 p-6 rounded-2xl transition-colors cursor-pointer" onclick='openNoteModal(<?php echo json_encode($note); ?>)' data-note-id="<?php echo $note['id']; ?>">
                    <div class="flex justify-between items-start">
                        <h3 class="text-xl font-bold text-white truncate mb-2 note-title"><?php echo htmlspecialchars($note['title']); ?></h3>
                        <div class="tag-container">
                            <?php 
                                $todolist_items = json_decode($note['todolist_content'], true);
                                if (!empty($todolist_items) && is_array($todolist_items)):
                            ?>
                                <span class="text-xs bg-primary-600 text-white font-semibold px-2 py-1 rounded-full todo-tag">To-Do</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm h-12 overflow-hidden note-content-preview">
                        <?php echo htmlspecialchars(substr($note['content'], 0, 100)) . (strlen($note['content']) > 100 ? '...' : ''); ?>
                    </p>
                    <p class="text-xs text-gray-500 mt-4 note-date">Modificato: <?php echo date("d/m/Y", strtotime($note['updated_at'])); ?></p>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </main>
    </div>

    <!-- Modale Editor Nota -->
    <div id="note-editor-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-60 opacity-0 modal-backdrop" onclick="closeModal('note-editor-modal')"></div>
        <div class="bg-gray-800 rounded-2xl shadow-xl w-full max-w-3xl h-5/6 flex flex-col p-6 transform scale-95 opacity-0 modal-content">
            <form id="note-form" class="flex flex-col flex-grow min-h-0">
                <input type="hidden" name="note_id" id="note-id">
                <input type="hidden" name="content" id="content-input">
                <input type="hidden" name="todolist_content" id="todolist-content-input">

                <header class="flex justify-between items-center mb-6 flex-shrink-0">
                    <input type="text" name="title" id="note-title" class="text-3xl font-bold text-white bg-transparent border-0 border-b-2 border-gray-700 focus:ring-0 focus:border-primary-500 w-full mr-4" placeholder="Titolo...">
                    <div class="flex items-center space-x-2">
                        <button type="button" id="delete-note-btn" class="bg-danger hover:bg-red-700 text-white font-semibold py-2 px-5 rounded-lg">Elimina</button>
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-5 rounded-lg">Salva</button>
                    </div>
                </header>
                
                <div class="flex-grow grid grid-cols-1 lg:grid-cols-2 gap-6 min-h-0">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-semibold text-white mb-2">Testo</h3>
                        <div class="flex-grow bg-gray-900 rounded-lg">
                            <textarea id="text-content" class="w-full h-full bg-gray-900 text-gray-300 rounded-lg p-4 border-0 focus:ring-2 focus:ring-primary-500 resize-none" placeholder="Scrivi qui..."></textarea>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-lg font-semibold text-white mb-2">To-Do List</h3>
                        <div class="flex-grow bg-gray-900 rounded-lg p-4 overflow-y-auto">
                            <div id="todolist-container" class="space-y-2"></div>
                            <button type="button" id="add-item-btn" class="mt-4 text-sm text-primary-500 hover:text-primary-400 font-semibold">+ Aggiungi elemento</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modale di Conferma Eliminazione -->
    <div id="confirm-delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-60 opacity-0 modal-backdrop" onclick="closeModal('confirm-delete-modal')"></div>
        <div class="bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-6 transform scale-95 opacity-0 modal-content text-center">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-900">
                <svg class="h-6 w-6 text-red-400" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-lg leading-6 font-bold text-white mt-4">Eliminare Nota?</h3>
            <p class="mt-2 text-sm text-gray-400">L'azione è irreversibile. Sei sicuro?</p>
            <div class="mt-8 flex justify-center space-x-4">
                <button id="confirm-delete-btn" type="button" class="bg-danger hover:bg-red-700 text-white font-semibold py-2 px-5 rounded-lg">Elimina</button>
                <button type="button" onclick="closeModal('confirm-delete-modal')" class="bg-gray-700 hover:bg-gray-600 text-gray-300 font-semibold py-2 px-5 rounded-lg">Annulla</button>
            </div>
        </div>
    </div>

    <script>
        // --- FUNZIONI DI BASE (MODALI, TOAST, ESCAPE) ---
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            const backdrop = modal.querySelector('.modal-backdrop');
            const content = modal.querySelector('.modal-content');
            modal.classList.remove('hidden');
            setTimeout(() => {
                if(backdrop) backdrop.classList.remove('opacity-0');
                if(content) content.classList.remove('opacity-0', 'scale-95');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const backdrop = modal.querySelector('.modal-backdrop');
            const content = modal.querySelector('.modal-content');
            if(backdrop) backdrop.classList.add('opacity-0');
            if(content) content.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
        
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast-notification');
            if (!toast) return;
            const toastMessage = document.getElementById('toast-message');
            const toastIcon = document.getElementById('toast-icon');
            toastMessage.textContent = message;
            toast.classList.remove('bg-success', 'bg-danger');
            if (type === 'success') {
                toast.classList.add('bg-success');
                toastIcon.innerHTML = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>`;
            } else {
                toast.classList.add('bg-danger');
                toastIcon.innerHTML = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path></svg>`;
            }
            toast.classList.remove('hidden', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, 5000);
        }
        
        function escapeHTML(str) { const div = document.createElement('div'); div.textContent = str; return div.innerHTML; }

        document.addEventListener('DOMContentLoaded', function() {
            const addNoteBtn = document.getElementById('add-note-btn');
            const noteForm = document.getElementById('note-form');
            const deleteNoteBtn = document.getElementById('delete-note-btn');
            const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
            const addItemBtn = document.getElementById('add-item-btn');
            const todolistContainer = document.getElementById('todolist-container');

            // --- GESTIONE AGGIUNTA NUOVA NOTA ---
            addNoteBtn.addEventListener('click', function() {
                fetch('add_note.php', { method: 'POST' })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            addNoteToGrid(data.note);
                            openNoteModal(data.note);
                        } else {
                            showToast(data.message, 'error');
                        }
                    }).catch(err => showToast('Errore di rete.', 'error'));
            });

            // --- GESTIONE SALVATAGGIO NOTA (MODIFICA) ---
            noteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData();
                formData.append('note_id', document.getElementById('note-id').value);
                formData.append('title', document.getElementById('note-title').value);
                formData.append('content', document.getElementById('text-content').value);
                formData.append('todolist_content', JSON.stringify(getTodoListData()));

                fetch('update_note.php', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message);
                            updateNoteInGrid(data.note);
                            closeModal('note-editor-modal');
                        } else {
                            showToast(data.message, 'error');
                        }
                    }).catch(err => showToast('Errore di rete.', 'error'));
            });

            // --- GESTIONE ELIMINAZIONE NOTA ---
            deleteNoteBtn.addEventListener('click', () => {
                openModal('confirm-delete-modal');
            });

            confirmDeleteBtn.addEventListener('click', function() {
                const noteId = document.getElementById('note-id').value;
                const formData = new FormData();
                formData.append('note_id', noteId);

                fetch('delete_note.php', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message);
                            const card = document.querySelector(`[data-note-id="${noteId}"]`);
                            if (card) {
                                card.classList.add('row-fade-out');
                                setTimeout(() => card.remove(), 500);
                            }
                            closeModal('confirm-delete-modal');
                            closeModal('note-editor-modal');
                        } else {
                            showToast(data.message, 'error');
                        }
                    }).catch(err => showToast('Errore di rete.', 'error'));
            });

            // --- GESTIONE TO-DO LIST ---
            addItemBtn.addEventListener('click', () => createTodoItem());

            todolistContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item-btn')) {
                    e.target.closest('.todolist-item').remove();
                }
            });

            todolistContainer.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox') {
                    const textInput = e.target.nextElementSibling;
                    textInput.classList.toggle('line-through', e.target.checked);
                    textInput.classList.toggle('text-gray-500', e.target.checked);
                }
            });
        });

        // --- FUNZIONI PER MANIPOLARE LA UI ---
        function openNoteModal(note) {
            document.getElementById('note-id').value = note.id;
            document.getElementById('note-title').value = note.title;
            document.getElementById('text-content').value = note.content;
            
            const todolistContainer = document.getElementById('todolist-container');
            todolistContainer.innerHTML = '';
            try {
                const items = JSON.parse(note.todolist_content || '[]');
                if (Array.isArray(items)) {
                    items.forEach(item => createTodoItem(item.task, item.completed));
                }
            } catch (e) {
                console.error("Errore nel parsing della to-do list:", e);
            }
            
            openModal('note-editor-modal');
        }

        function createTodoItem(task = '', completed = false) {
            const container = document.getElementById('todolist-container');
            const itemDiv = document.createElement('div');
            itemDiv.className = 'flex items-center bg-gray-700 p-2 rounded-lg todolist-item';
            const textClasses = `flex-grow bg-transparent text-white border-0 focus:ring-0 mx-2 ${completed ? 'line-through text-gray-500' : ''}`;
            
            itemDiv.innerHTML = `
                <input type="checkbox" class="h-5 w-5 rounded bg-gray-600 border-gray-500 text-primary-600 focus:ring-primary-500" ${completed ? 'checked' : ''}>
                <input type="text" value="${escapeHTML(task)}" class="${textClasses}" placeholder="Nuova attività...">
                <button type="button" class="text-gray-500 hover:text-danger remove-item-btn text-xl">&times;</button>
            `;
            container.appendChild(itemDiv);
        }

        function getTodoListData() {
            const items = [];
            document.querySelectorAll('#todolist-container .todolist-item').forEach(itemDiv => {
                const taskInput = itemDiv.querySelector('input[type="text"]');
                const completedCheckbox = itemDiv.querySelector('input[type="checkbox"]');
                if (taskInput.value.trim() !== '') {
                    items.push({
                        task: taskInput.value,
                        completed: completedCheckbox.checked
                    });
                }
            });
            return items;
        }

        function addNoteToGrid(note) {
            const emptyState = document.getElementById('empty-state-notes');
            if (emptyState) emptyState.remove();

            const grid = document.getElementById('notes-grid');
            const newCard = document.createElement('div');
            newCard.className = 'block bg-gray-800 hover:bg-gray-700 p-6 rounded-2xl transition-colors cursor-pointer';
            newCard.setAttribute('data-note-id', note.id);
            newCard.setAttribute('onclick', `openNoteModal(${JSON.stringify(note)})`);

            const contentPreview = escapeHTML(note.content.substring(0, 100)) + (note.content.length > 100 ? '...' : '');
            const formattedDate = new Date(note.updated_at).toLocaleDateString('it-IT');

            newCard.innerHTML = `
                <div class="flex justify-between items-start">
                    <h3 class="text-xl font-bold text-white truncate mb-2 note-title">${escapeHTML(note.title)}</h3>
                    <div class="tag-container"></div>
                </div>
                <p class="text-gray-400 text-sm h-12 overflow-hidden note-content-preview">${contentPreview}</p>
                <p class="text-xs text-gray-500 mt-4 note-date">Modificato: ${formattedDate}</p>
            `;
            grid.prepend(newCard);
        }

        function updateNoteInGrid(note) {
            const card = document.querySelector(`[data-note-id="${note.id}"]`);
            if (card) {
                const contentPreview = escapeHTML(note.content.substring(0, 100)) + (note.content.length > 100 ? '...' : '');
                card.querySelector('.note-title').textContent = escapeHTML(note.title);
                card.querySelector('.note-content-preview').textContent = contentPreview;
                card.querySelector('.note-date').textContent = 'Modificato: ' + new Date().toLocaleDateString('it-IT');
                
                // --- CORREZIONE PER IL TAG TO-DO ---
                const tagContainer = card.querySelector('.tag-container');
                const todoItems = JSON.parse(note.todolist_content || '[]');
                if (Array.isArray(todoItems) && todoItems.length > 0) {
                    if (!tagContainer.querySelector('.todo-tag')) {
                        tagContainer.innerHTML = `<span class="text-xs bg-primary-600 text-white font-semibold px-2 py-1 rounded-full todo-tag">To-Do</span>`;
                    }
                } else {
                    tagContainer.innerHTML = ''; // Rimuovi il tag se non ci sono elementi
                }
                
                // Aggiorna l'attributo onclick con i nuovi dati
                const updatedNoteData = {
                    id: note.id,
                    title: note.title,
                    content: note.content,
                    todolist_content: note.todolist_content,
                    updated_at: new Date().toISOString() // Simula la data di aggiornamento
                };
                card.setAttribute('onclick', `openNoteModal(${JSON.stringify(updatedNoteData)})`);
            }
        }
    </script>
</body>
</html>