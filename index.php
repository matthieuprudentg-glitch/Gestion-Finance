<?php
$base_path = "";
include('bdd/bdd.php');

// Fetch total salaries
$query_salaires = $bdd->query("SELECT SUM(montant) as total FROM salaire");
$res_salaires = $query_salaires->fetch();
$total_salaires = $res_salaires['total'] ?? 0;

// Fetch total expenses
$query_depenses = $bdd->query("SELECT SUM(montant) as total FROM depense");
$res_depenses = $query_depenses->fetch();
$total_depenses = $res_depenses['total'] ?? 0;

// Calculate balance
$solde = $total_salaires - $total_depenses;

include('view/commun/header.php');
?>

<div class="row mb-5 text-center text-md-start">
    <div class="col-12">
        <h1 class="display-5 fw-bold mb-2">Tableau de bord</h1>
        <p class="text-secondary fs-5">Aperçu en temps réel de votre situation financière ce mois-ci.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Card Revenus -->
    <div class="col-md-4">
        <div class="card card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-secondary fw-semibold">Revenus Totaux</span>
                <span class="badge badge-custom badge-income"><i class="bi bi-arrow-up-right"></i> Revenu</span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="metric-val text-gradient"><?php echo number_format($total_salaires, 2, ',', ' '); ?> €</span>
            </div>
            <div class="mt-3">
                <a href="view/salaire.php" class="btn btn-custom w-100 btn-sm"><i class="bi bi-plus-lg"></i> Ajouter un salaire</a>
            </div>
        </div>
    </div>
    
    <!-- Card Dépenses -->
    <div class="col-md-4">
        <div class="card card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-secondary fw-semibold">Dépenses Totales</span>
                <span class="badge badge-custom badge-expense"><i class="bi bi-arrow-down-left"></i> Dépense</span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="metric-val text-gradient"><?php echo number_format($total_depenses, 2, ',', ' '); ?> €</span>
            </div>
            <div class="mt-3">
                <a href="view/depense.php" class="btn btn-custom w-100 btn-sm"><i class="bi bi-plus-lg"></i> Ajouter une dépense</a>
            </div>
        </div>
    </div>

    <!-- Card Solde -->
    <div class="col-md-4">
        <div class="card card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-secondary fw-semibold">Solde Restant</span>
                <span class="badge badge-custom <?php echo $solde >= 0 ? 'badge-income' : 'badge-expense'; ?>">
                    <i class="bi <?php echo $solde >= 0 ? 'bi-emoji-smile' : 'bi-emoji-frown'; ?>"></i> Statut
                </span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <span class="metric-val text-gradient"><?php echo number_format($solde, 2, ',', ' '); ?> €</span>
            </div>
            <div class="mt-3">
                <a href="view/epargne.php" class="btn btn-custom w-100 btn-sm"><i class="bi bi-piggy-bank"></i> Gérer mon épargne</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Quick Stats & Actions -->
    <div class="col-lg-6">
        <div class="card card-custom h-100">
            <div class="card-header-custom">
                <h4 class="mb-0"><i class="bi bi-lightning-charge-fill text-gradient me-2"></i>Actions Rapides</h4>
            </div>
            <div class="card-body p-4">
                <div class="list-group list-group-flush bg-transparent">
                    <a href="view/listSalaire.php" class="list-group-item list-group-item-action bg-transparent border-0 text-white d-flex justify-content-between align-items-center px-0 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="btn-custom p-2 rounded-3"><i class="bi bi-cash-stack fs-5"></i></div>
                            <div>
                                <h6 class="mb-0">Consulter les salaires</h6>
                                <small class="text-secondary">Voir l'historique complet de vos revenus</small>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </a>
                    <a href="view/listDepenses.php" class="list-group-item list-group-item-action bg-transparent border-0 text-white d-flex justify-content-between align-items-center px-0 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="btn-custom p-2 rounded-3" style="background: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);"><i class="bi bi-cart fs-5"></i></div>
                            <div>
                                <h6 class="mb-0">Consulter les dépenses</h6>
                                <small class="text-secondary">Analyser et suivre vos sorties d'argent</small>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Balance breakdown -->
    <div class="col-lg-6">
        <div class="card card-custom h-100">
            <div class="card-header-custom">
                <h4 class="mb-0"><i class="bi bi-pie-chart-fill text-gradient me-2"></i>Répartition du Budget</h4>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <?php 
                $percentage = 0;
                if ($total_salaires > 0) {
                    $percentage = min(100, round(($total_depenses / $total_salaires) * 100));
                }
                ?>
                <h6 class="text-secondary mb-3">Pourcentage de dépenses par rapport aux revenus :</h6>
                <div class="progress mb-4" style="height: 25px; background-color: rgba(255,255,255,0.05); border-radius: 12px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" 
                         style="width: <?php echo $percentage; ?>%; border-radius: 12px; font-weight: bold;" 
                         aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                        <?php echo $percentage; ?>%
                    </div>
                </div>
                <p class="text-secondary">
                    <?php if ($percentage > 80): ?>
                        <span class="text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i> Attention ! Vous dépensez plus de 80% de vos revenus.</span>
                    <?php elseif ($percentage > 0): ?>
                        <span class="text-success"><i class="bi bi-check-circle-fill me-2"></i> Situation saine. Vous dépensez <?php echo $percentage; ?>% de vos revenus et pouvez épargner le reste.</span>
                    <?php else: ?>
                        <span class="text-info"><i class="bi bi-info-circle-fill me-2"></i> Ajoutez des salaires et des dépenses pour voir l'analyse de votre budget.</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include('view/commun/footer.php'); ?>