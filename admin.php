<?php
session_start();
// Sicurezza: solo l'utente con ID 1 può accedere a questa pagina.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["id"] != 1) {
    header("location: dashboard.php");
    exit;
}
require_once 'db_connect.php';
require_once 'functions.php';

// --- LOGICA DI PAGINAZIONE E RICERCA ---
$users_per_page = 20; // Quanti utenti mostrare per pagina
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$search_term = $_GET['search'] ?? '';

// Recupera gli utenti paginati e il numero totale di pagine
$user_data = get_users_paginated_and_searched($conn, $search_term, $current_page, $users_per_page);
$users_list = $user_data['users'];
$total_pages = $user_data['total_pages'];

// Recupera le statistiche generali
$stats = get_admin_stats($conn);


?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello Admin - Bearget</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Inter', sans-serif; background-color: var(--color-gray-900); }
        .modal-backdrop { transition: opacity 0.3s ease; }
        .modal-content { transition: transform 0.3s ease; }
    </style>
</head>
<body class="text-gray-300">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-gray-800 p-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center mb-10">
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-xl">B</div>
                    <span class="ml-3 text-2xl font-extrabold text-white">Bearget</span>
                </div>
                <nav class="space-y-2">
                    <?php if (isset($_SESSION['id']) && $_SESSION['id'] == 1): ?>
                        <a href="admin.php" class="flex items-center px-4 py-2.5 text-white bg-gray-900 rounded-lg font-semibold">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Admin
                        </a>
                    <?php endif; ?>
                    <a href="dashboard.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="transactions.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Transazioni
                    </a>
                    <a href="accounts.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Conti
                    </a>
                    <a href="categories.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Categorie
                    </a>
                    <a href="reports.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Report
                    </a>
                    <a href="budgets.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        Budget
                    </a>
                    <a href="goals.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.25278C12 6.25278 10.8333 5 9.5 5C8.16667 5 7 6.25278 7 6.25278V9.74722C7 9.74722 8.16667 11 9.5 11C10.8333 11 12 9.74722 12 9.74722V6.25278ZM12 6.25278C12 6.25278 13.1667 5 14.5 5C15.8333 5 17 6.25278 17 6.25278V9.74722C17 9.74722 15.8333 11 14.5 11C13.1667 11 12 9.74722 12 9.74722V6.25278Z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11V14"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14H15"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17H15"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20H14"></path></svg>
                        Obiettivi
                    </a>
                    <a href="recurring.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5m11 2a9 9 0 11-2.93-6.93"></path></svg>
                        Ricorrenti
                    </a>
                    <a href="shared_funds.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.122-1.28-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.122-1.28.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Fondi Comuni
                    </a>
                    <a href="notifications.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors relative">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Notifiche
                        <?php if($notification_count > 0): ?>
                        <span class="absolute top-1 right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full"><?php echo $notification_count; ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="notes.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Note
                    </a>
                </nav>
            </div>
            <div class="border-t border-gray-700 pt-4">
                <a href="settings.php" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.096 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Impostazioni
                </a>
                <a href="bearget_info.html" target="_blank" class="flex items-center px-4 py-2.5 mt-2 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Info & Supporto
                </a>
                <a href="logout.php" class="flex items-center px-4 py-2.5 mt-2 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition-colors">Logout</a>
            </div>
        </aside>

        <main class="flex-1 p-6 lg:p-10 overflow-y-auto">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-white">Pannello Amministrazione</h1>
                <p class="text-gray-400">Statistiche e gestione utenti.</p>
            </header>

            <!-- SEZIONE STATISTICHE -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gray-800 p-6 rounded-2xl">
                    <h3 class="text-gray-400 text-sm font-medium">Utenti Totali</h3>
                    <p class="text-3xl font-bold text-white mt-1"><?php echo $stats['total_users']; ?></p>
                </div>
                <div class="bg-gray-800 p-6 rounded-2xl">
                    <h3 class="text-gray-400 text-sm font-medium">Utenti Pro</h3>
                    <p class="text-3xl font-bold text-green-400 mt-1"><?php echo $stats['pro_users']; ?></p>
                </div>
                <div class="bg-gray-800 p-6 rounded-2xl">
                    <h3 class="text-gray-400 text-sm font-medium">Utenti Free</h3>
                    <p class="text-3xl font-bold text-yellow-400 mt-1"><?php echo $stats['free_users']; ?></p>
                </div>
                <div class="bg-gray-800 p-6 rounded-2xl">
                    <h3 class="text-gray-400 text-sm font-medium">Nuovi (30 giorni)</h3>
                    <p class="text-3xl font-bold text-indigo-400 mt-1"><?php echo $stats['new_users_last_30_days']; ?></p>
                </div>
            </div>

            <!-- FORM DI RICERCA -->
            <div class="bg-gray-800 rounded-2xl p-4 mb-6">
                <form action="admin.php" method="GET" class="flex items-center gap-4">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Cerca per username o email..." class="w-full bg-gray-700 text-white rounded-lg px-3 py-2 text-sm focus:ring-primary-500 focus:border-primary-500">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg">Cerca</button>
                    <a href="admin.php" class="bg-gray-600 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg">Resetta</a>
                </form>
            </div>

            <div class="bg-gray-800 rounded-2xl p-2">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="text-sm text-gray-400 uppercase">
                            <tr>
                                <th class="p-4">ID Utente</th>
                                <th class="p-4">Username</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Stato Attuale</th>
                                <th class="p-4">Modifica Stato</th>
                                <th class="p-4 text-center">Info</th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            <?php if (empty($users_list)): ?>
                                <tr><td colspan="6" class="text-center p-6 text-gray-400">Nessun utente trovato.</td></tr>
                            <?php else: ?>
                                <?php foreach ($users_list as $user): ?>
                                <tr class="border-b border-gray-700 last:border-b-0">
                                    <td class="p-4"><?php echo $user['id']; ?></td>
                                    <td class="p-4 font-semibold"><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td class="p-4"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 font-semibold leading-tight text-xs rounded-full <?php 
                                            switch($user['subscription_status']) {
                                                case 'active': echo 'bg-green-700 text-green-100'; break;
                                                case 'lifetime': echo 'bg-indigo-700 text-indigo-100'; break;
                                                default: echo 'bg-gray-700 text-gray-100';
                                            }
                                        ?>">
                                            <?php echo ucfirst($user['subscription_status']); ?>
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <form action="update_user_status.php" method="POST" class="flex items-center gap-2">
                                            <input type="hidden" name="user_id_to_update" value="<?php echo $user['id']; ?>">
                                            <select name="new_status" class="bg-gray-700 text-white rounded-md px-2 py-1 text-sm">
                                                <option value="free" <?php if($user['subscription_status'] == 'free') echo 'selected'; ?>>Free</option>
                                                <option value="active" <?php if($user['subscription_status'] == 'active') echo 'selected'; ?>>Active</option>
                                                <option value="lifetime" <?php if($user['subscription_status'] == 'lifetime') echo 'selected'; ?>>Lifetime</option>
                                            </select>
                                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-3 py-1 rounded-md text-sm">Salva</button>
                                        </form>
                                    </td>
                                    <td class="p-4 text-center">
                                        <!-- MODIFICATO: Aggiunto pulsante Impersonate -->
                                        <div class="flex items-center justify-center space-x-2">
                                            <button onclick='openUserInfoModal(<?php echo json_encode($user); ?>)' class="p-2 hover:bg-gray-700 rounded-full" title="Mostra dettagli utente">
                                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                            <?php if ($user['id'] != 1): // Non mostrare il pulsante per l'admin stesso ?>
                                                <a href="impersonate.php?id=<?php echo $user['id']; ?>" class="p-2 hover:bg-gray-700 rounded-full" title="Accedi come <?php echo htmlspecialchars($user['username']); ?>">
                                                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CONTROLLI DI PAGINAZIONE -->
            <div class="flex justify-between items-center mt-6">
                <span class="text-sm text-gray-400">Pagina <?php echo $current_page; ?> di <?php echo $total_pages > 0 ? $total_pages : 1; ?></span>
                <div class="flex gap-2">
                    <?php if ($current_page > 1): ?>
                        <a href="?page=<?php echo $current_page - 1; ?>&search=<?php echo urlencode($search_term); ?>" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg">&laquo; Precedente</a>
                    <?php endif; ?>
                    <?php if ($current_page < $total_pages): ?>
                        <a href="?page=<?php echo $current_page + 1; ?>&search=<?php echo urlencode($search_term); ?>" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg">Successivo &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Modale Dettagli Utente -->
    <div id="user-info-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeUserInfoModal()"></div>
        <div class="bg-gray-800 rounded-2xl w-full max-w-lg p-6 relative shadow-lg">
            <h2 class="text-2xl font-bold text-white mb-4">Dettagli Utente: <span id="modal-username" class="text-primary-400"></span></h2>
            <div class="space-y-2 text-gray-300">
                <p><strong>ID Utente:</strong> <span id="modal-userid" class="font-mono"></span></p>
                <p><strong>Email:</strong> <span id="modal-email"></span></p>
                <p><strong>Stato Abbonamento:</strong> <span id="modal-status" class="font-semibold"></span></p>
                <p><strong>Codice Amico:</strong> <span id="modal-friendcode" class="font-mono"></span></p>
                <hr class="border-gray-600 my-3">
                <p><strong>Stripe Customer ID:</strong> <span id="modal-stripe-customer" class="font-mono text-sm"></span></p>
                <p><strong>Stripe Subscription ID:</strong> <span id="modal-stripe-sub" class="font-mono text-sm"></span></p>
                <p><strong>Fine/Rinnovo Abbonamento:</strong> <span id="modal-sub-end"></span></p>
                <hr class="border-gray-600 my-3">
                <p><strong>Account Creato il:</strong> <span id="modal-created-at"></span></p>
            </div>
            <div class="mt-6 flex justify-between items-center">
                <button onclick="openUserEditModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg">Modifica Utente</button>
                <button onclick="closeUserInfoModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-5 rounded-lg">Chiudi</button>
            </div>
        </div>
    </div>

    <!-- Modale per Modificare l'Utente -->
    <div id="user-edit-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeUserEditModal()"></div>
        <div class="bg-gray-800 rounded-2xl w-full max-w-lg p-6 relative shadow-lg">
            <h2 class="text-2xl font-bold text-white mb-6">Modifica Utente</h2>
            <form id="edit-user-form" action="admin_update_user.php" method="POST">
                <input type="hidden" name="user_id" id="edit-user-id">
                <div class="space-y-4">
                    <div>
                        <label for="edit-email" class="block text-sm font-medium text-gray-300 mb-1">Indirizzo Email</label>
                        <input type="email" name="email" id="edit-email" required class="w-full bg-gray-700 text-white rounded-lg px-3 py-2">
                    </div>
                    <!-- NUOVO CAMPO CODICE AMICO -->
                    <div>
                        <label for="edit-friend-code" class="block text-sm font-medium text-gray-300 mb-1">Codice Amico</label>
                        <input type="text" name="friend_code" id="edit-friend-code" required class="w-full bg-gray-700 text-white rounded-lg px-3 py-2 font-mono uppercase" maxlength="8">
                    </div>
                    <div>
                        <label for="edit-password" class="block text-sm font-medium text-gray-300 mb-1">Nuova Password (lasciare vuoto per non modificare)</label>
                        <input type="password" name="new_password" id="edit-password" class="w-full bg-gray-700 text-white rounded-lg px-3 py-2">
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="closeUserEditModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-5 rounded-lg">Annulla</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-5 rounded-lg">Salva Modifiche</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const userInfoModal = document.getElementById('user-info-modal');
        const userEditModal = document.getElementById('user-edit-modal');
        let currentUserData = null;

        function formatDate(dateString) {
            if (!dateString || dateString === '0000-00-00 00:00:00' || dateString === null) return 'N/A';
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return new Date(dateString).toLocaleDateString('it-IT', options);
        }

        function openUserInfoModal(user) {
            currentUserData = user;
            
            document.getElementById('modal-username').textContent = user.username;
            document.getElementById('modal-userid').textContent = user.id;
            document.getElementById('modal-email').textContent = user.email;
            document.getElementById('modal-status').textContent = user.subscription_status;
            document.getElementById('modal-friendcode').textContent = user.friend_code || 'N/A';
            
            const customerIdSpan = document.getElementById('modal-stripe-customer');
            if (user.stripe_customer_id) {
                const stripeUrl = `https://dashboard.stripe.com/test/customers/${user.stripe_customer_id}`;
                customerIdSpan.innerHTML = `<a href="${stripeUrl}" target="_blank" class="text-indigo-400 hover:underline">${user.stripe_customer_id}</a>`;
            } else {
                customerIdSpan.textContent = 'N/A';
            }

            document.getElementById('modal-stripe-sub').textContent = user.stripe_subscription_id || 'N/A';
            document.getElementById('modal-sub-end').textContent = formatDate(user.subscription_end_date);
            document.getElementById('modal-created-at').textContent = formatDate(user.created_at);
            
            userInfoModal.classList.remove('hidden');
        }

        function closeUserInfoModal() {
            userInfoModal.classList.add('hidden');
        }

        function openUserEditModal() {
            if (!currentUserData) return;
            
            document.getElementById('edit-user-id').value = currentUserData.id;
            document.getElementById('edit-email').value = currentUserData.email;
            // NUOVO: Popola il campo codice amico
            document.getElementById('edit-friend-code').value = currentUserData.friend_code;
            document.getElementById('edit-password').value = '';

            closeUserInfoModal();
            userEditModal.classList.remove('hidden');
        }

        function closeUserEditModal() {
            userEditModal.classList.add('hidden');
        }        
    </script>
</body>
</html>