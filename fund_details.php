<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
require_once 'db_connect.php';
require_once 'functions.php';

$user_id = $_SESSION["id"];
$fund_id = $_GET['id'] ?? 0;
$current_page = 'shared_funds';

// Recupera i dettagli del fondo, ma solo se l'utente attuale ne è membro
$fund = get_shared_fund_details($conn, $fund_id, $user_id);
if (!$fund) {
    // Se l'utente non è membro o il fondo non esiste, non può vederlo
    header("location: shared_funds.php?message=Fondo non trovato o accesso non autorizzato.&type=error");
    exit;
}

$members = get_fund_members($conn, $fund_id);
$contributions = get_fund_contributions($conn, $fund_id);
$accounts = get_user_accounts($conn, $user_id);
$fundCategory = get_category_by_name($conn, 'Fondi Comuni', $user_id);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli Fondo - Bearget</title>
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
    </style>
</head>
<body class="text-gray-300">
    <div class="flex h-screen">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 p-6 lg:p-10 overflow-y-auto">
            <header class="flex flex-wrap justify-between items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white"><?php echo htmlspecialchars($fund['name']); ?></h1>
                    <p class="text-gray-400 mt-1">Dettagli e contributi del fondo comune.</p>
                </div>
                <button onclick="openModal('add-contribution-modal')" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-5 rounded-lg flex items-center transition-colors shadow-lg hover:shadow-primary-500/50">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Aggiungi Contributo
                </button>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Colonna Principale -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-800 rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Riepilogo</h2>
                        <?php 
                            $percentage = ($fund['target_amount'] > 0) ? ($fund['total_contributed'] / $fund['target_amount']) * 100 : 0;
                        ?>
                        <div class="w-full bg-gray-700 rounded-full h-4 mb-2">
                            <div class="bg-green-500 h-4 rounded-full text-center text-white text-xs font-bold" style="width: <?php echo min($percentage, 100); ?>%"><?php echo round($percentage); ?>%</div>
                        </div>
                        <div class="flex justify-between text-lg text-gray-300">
                            <span class="font-bold text-white">€<?php echo number_format($fund['total_contributed'], 2, ',', '.'); ?></span>
                            <span class="text-gray-400">di €<?php echo number_format($fund['target_amount'], 2, ',', '.'); ?></span>
                        </div>
                    </div>
                    <div class="bg-gray-800 rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Storico Contributi</h2>
                        <div class="space-y-2">
                            <?php if(empty($contributions)): ?>
                                <div class="text-center py-8 text-gray-500">
                                    <p>Nessun contributo ancora versato.</p>
                                </div>
                            <?php else: foreach($contributions as $c): ?>
                            <div class="flex items-center justify-between p-2 rounded-lg transition-colors hover:bg-gray-700/50">
                                <div>
                                    <p class="font-semibold text-white"><?php echo htmlspecialchars($c['username']); ?></p>
                                    <p class="text-sm text-gray-400"><?php echo date("d/m/Y", strtotime($c['contribution_date'])); ?></p>
                                </div>
                                <p class="font-bold text-success">+€<?php echo number_format($c['amount'], 2, ',', '.'); ?></p>
                            </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Colonna Laterale -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-gray-800 rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Membri</h2>
                        <div class="space-y-3">
                            <?php foreach($members as $member): ?>
                            <div class="flex items-center p-2 rounded-lg transition-colors hover:bg-gray-700/50">
                                <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-sm mr-3 flex-shrink-0"><?php echo strtoupper(substr($member['username'], 0, 1)); ?></div>
                                <span><?php echo htmlspecialchars($member['username']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="bg-gray-800 rounded-2xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Invita Membro</h2>
                        <form action="invite_member.php" method="POST" class="space-y-3">
                            <input type="hidden" name="fund_id" value="<?php echo $fund_id; ?>">
                            <div>
                                <label for="friend_code" class="block text-sm font-medium text-gray-400 mb-1">Codice Amico</label>
                                <input type="text" name="friend_code" id="friend_code" required class="w-full bg-gray-700 text-white rounded-lg px-3 py-2" placeholder="ABC123DE">
                            </div>
                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Invita
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modale Aggiungi Contributo -->
    <div id="add-contribution-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50 opacity-0 modal-backdrop" onclick="closeModal('add-contribution-modal')"></div>
        <div class="bg-gray-800 rounded-2xl w-full max-w-md p-6 transform scale-95 opacity-0 modal-content">
            <h2 class="text-2xl font-bold text-white mb-6">Versa nel Fondo</h2>
            <form action="add_fund_contribution.php" method="POST" class="space-y-4">
                <input type="hidden" name="fund_id" value="<?php echo $fund_id; ?>">
                <input type="hidden" name="category_id" value="<?php echo $fundCategory['id'] ?? ''; ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Importo (€)</label>
                    <input type="number" step="0.01" name="amount" required class="w-full bg-gray-700 text-white rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Dal tuo conto</label>
                    <select name="account_id" required class="w-full bg-gray-700 text-white rounded-lg px-3 py-2">
                        <?php foreach($accounts as $account): ?><option value="<?php echo $account['id']; ?>"><?php echo htmlspecialchars($account['name']); ?></option><?php endforeach; ?>
                    </select>
                </div>
                <?php if (!isset($fundCategory['id'])): ?>
                    <p class="text-sm text-yellow-400">Attenzione: Categoria 'Fondi Comuni' non trovata. Il contributo non creerà una transazione di spesa personale.</p>
                <?php endif; ?>
                <div class="pt-4 flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('add-contribution-modal')" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-5 rounded-lg">Annulla</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-5 rounded-lg">Conferma</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            const backdrop = modal.querySelector('.modal-backdrop');
            const content = modal.querySelector('.modal-content');
            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                content.classList.remove('opacity-0', 'scale-95');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const backdrop = modal.querySelector('.modal-backdrop');
            const content = modal.querySelector('.modal-content');
            backdrop.classList.add('opacity-0');
            content.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>