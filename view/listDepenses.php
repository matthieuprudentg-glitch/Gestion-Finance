<?php 
include('../bdd/bdd.php');

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $deleteId = intval($_GET['id']);
    $requete = $bdd->prepare("DELETE FROM depense WHERE id = :id");
    $requete->bindParam(':id', $deleteId);
    $requete->execute();
    header('Location: listDepenses.php');
    exit();
}

// Fetch all expenses
$requete = $bdd->prepare('SELECT * FROM depense ORDER BY id DESC');
$requete->execute();
$depenses = $requete->fetchAll();

include('commun/header.php'); 
?>

<div class="row">
    <div class="col-12">
        <div class="card card-custom">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="bi bi-list-task text-gradient me-2"></i>Liste des Dépenses</h3>
                <a href="depense.php" class="btn btn-custom btn-sm" style="background: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);"><i class="bi bi-plus-lg"></i> Ajouter une dépense</a>
            </div>
            <div class="card-body p-0">
                <?php if (count($depenses) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 10%;">#</th>
                                    <th scope="col">Libellé</th>
                                    <th scope="col">Catégorie</th>
                                    <th scope="col" style="width: 20%;">Montant</th>
                                    <th scope="col" class="text-end" style="width: 20%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($depenses as $depense): ?> 
                                    <tr>
                                        <td class="fw-bold text-secondary">#<?php echo $depense['id']; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="btn-custom p-1 rounded-circle" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.2); color: var(--accent-danger); width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                                    <i class="bi bi-cart-dash"></i>
                                                </div>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($depense['libelle']); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-custom badge-expense"><?php echo htmlspecialchars($depense['categorie']); ?></span>
                                        </td>
                                        <td class="fw-bold text-danger">- <?php echo number_format($depense['montant'], 2, ',', ' '); ?> €</td>
                                        <td class="text-end">
                                            <a href="listDepenses.php?action=delete&id=<?php echo $depense['id']; ?>" class="btn-danger-custom" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette dépense ?');">
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
                        <i class="bi bi-cart-x fs-1 text-gradient mb-3 d-block" style="background: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);"></i>
                        <p class="fs-5">Aucune dépense enregistrée pour le moment.</p>
                        <a href="depense.php" class="btn btn-custom btn-sm mt-2" style="background: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);"><i class="bi bi-plus-lg"></i> Ajouter ma première dépense</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('commun/footer.php'); ?>
