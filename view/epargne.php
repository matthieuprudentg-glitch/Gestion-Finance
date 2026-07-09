<?php 
include('../bdd/bdd.php');

// Helper to format French months
function format_french_month($date_str) {
    $months = [
        '01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril',
        '05' => 'Mai', '06' => 'Juin', '07' => 'Juillet', '08' => 'Août',
        '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
    ];
    $parts = explode('-', $date_str);
    if (count($parts) >= 2) {
        return $months[$parts[1]] . ' ' . $parts[0];
    }
    return $date_str;
}

// Fetch totals for calculation
$query_salaires = $bdd->query("SELECT SUM(montant) as total FROM salaire");
$res_salaires = $query_salaires->fetch();
$total_salaires = $res_salaires['total'] ?? 0;

$query_depenses = $bdd->query("SELECT SUM(montant) as total FROM depense");
$res_depenses = $query_depenses->fetch();
$total_depenses = $res_depenses['total'] ?? 0;

$reste_a_epargner = $total_salaires - $total_depenses;
$current_month = date('Y-m-01');

// Handle saving action
if (isset($_POST['enregistrer_epargne'])) {
    $reste = floatval($_POST['reste_value']);
    
    // Check if record exists for this month
    $check = $bdd->prepare("SELECT id FROM epargne WHERE periode = :periode");
    $check->bindParam(':periode', $current_month);
    $check->execute();
    
    if ($check->rowCount() > 0) {
        $update = $bdd->prepare("UPDATE epargne SET reste = :reste WHERE periode = :periode");
        $update->bindParam(':reste', $reste);
        $update->bindParam(':periode', $current_month);
        $update->execute();
        $success_msg = "Épargne du mois mise à jour avec succès !";
    } else {
        $insert = $bdd->prepare("INSERT INTO epargne(periode, reste) VALUES (:periode, :reste)");
        $insert->bindParam(':periode', $current_month);
        $insert->bindParam(':reste', $reste);
        $insert->execute();
        $success_msg = "Épargne du mois enregistrée avec succès !";
    }
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $deleteId = intval($_GET['id']);
    $delete = $bdd->prepare("DELETE FROM epargne WHERE id = :id");
    $delete->bindParam(':id', $deleteId);
    $delete->execute();
    header('Location: epargne.php');
    exit();
}

// Fetch savings history
$requete = $bdd->prepare("SELECT * FROM epargne ORDER BY periode DESC");
$requete->execute();
$epargnes = $requete->fetchAll();

include('commun/header.php'); 
?>

<div class="row g-4">
    <!-- Calculator Section -->
    <div class="col-lg-5">
        <div class="card card-custom h-100">
            <div class="card-header-custom">
                <h3 class="mb-0"><i class="bi bi-piggy-bank text-gradient me-2"></i>Calculateur d'Épargne</h3>
            </div>
            <div class="card-body p-4">
                <?php if (isset($success_msg)): ?>
                    <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.15); border-color: rgba(16, 185, 129, 0.2); color: var(--accent-success);" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> <?php echo $success_msg; ?>
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <span class="text-secondary d-block mb-1">Mois en cours</span>
                    <h4 class="fw-bold text-white"><?php echo format_french_month(date('Y-m-d')); ?></h4>
                </div>

                <hr style="border-color: var(--card-border);">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary">Total des revenus</span>
                    <span class="fw-semibold text-success">+ <?php echo number_format($total_salaires, 2, ',', ' '); ?> €</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary">Total des dépenses</span>
                    <span class="fw-semibold text-danger">- <?php echo number_format($total_depenses, 2, ',', ' '); ?> €</span>
                </div>

                <hr style="border-color: var(--card-border);">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold fs-5">Solde Épargnable</span>
                    <span class="fw-bold fs-4 text-gradient" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo number_format($reste_a_epargner, 2, ',', ' '); ?> €</span>
                </div>

                <form action="" method="post">
                    <input type="hidden" name="reste_value" value="<?php echo $reste_a_epargner; ?>">
                    <button type="submit" name="enregistrer_epargne" class="btn btn-custom w-100 py-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="bi bi-cloud-arrow-up-fill"></i> Sauvegarder l'épargne du mois
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- History Section -->
    <div class="col-lg-7">
        <div class="card card-custom h-100">
            <div class="card-header-custom">
                <h3 class="mb-0"><i class="bi bi-clock-history text-gradient me-2"></i>Historique des Épargnes</h3>
            </div>
            <div class="card-body p-0">
                <?php if (count($epargnes) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Période</th>
                                    <th scope="col">Épargne</th>
                                    <th scope="col" class="text-end" style="width: 25%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($epargnes as $ep): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="btn-custom p-1 rounded-circle" style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.2); color: var(--accent-warning); width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                                    <i class="bi bi-calendar-event"></i>
                                                </div>
                                                <span class="fw-semibold"><?php echo format_french_month($ep['periode']); ?></span>
                                            </div>
                                        </td>
                                        <td class="fw-bold <?php echo $ep['reste'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                            <?php echo ($ep['reste'] >= 0 ? '+ ' : '') . number_format($ep['reste'], 2, ',', ' '); ?> €
                                        </td>
                                        <td class="text-end">
                                            <a href="epargne.php?action=delete&id=<?php echo $ep['id']; ?>" class="btn-danger-custom" onclick="return confirm('Supprimer cet enregistrement d\'épargne ?');">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-5 text-center text-secondary">
                        <i class="bi bi-piggy-bank fs-1 text-gradient mb-3 d-block" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);"></i>
                        <p class="fs-5">Aucune épargne enregistrée dans l'historique.</p>
                        <p class="small text-muted">Utilisez le calculateur à gauche pour sauvegarder l'épargne du mois en cours.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('commun/footer.php'); ?>