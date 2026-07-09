<?php 
include('../bdd/bdd.php');

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $deleteId = intval($_GET['id']);
    $requete = $bdd->prepare("DELETE FROM salaire WHERE id = :id");
    $requete->bindParam(':id', $deleteId);
    $requete->execute();
    header('Location: listSalaire.php');
    exit();
}

// Fetch all salaries
$requete = $bdd->prepare('SELECT * FROM salaire ORDER BY id DESC');
$requete->execute();
$salaires = $requete->fetchAll();

include('commun/header.php'); 
?>

<div class="row">
    <div class="col-12">
        <div class="card card-custom">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="bi bi-list-columns-reverse text-gradient me-2"></i>Liste des Salaires</h3>
                <a href="salaire.php" class="btn btn-custom btn-sm"><i class="bi bi-plus-lg"></i> Ajouter un salaire</a>
            </div>
            <div class="card-body p-0">
                <?php if (count($salaires) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 10%;">#</th>
                                    <th scope="col">Libellé</th>
                                    <th scope="col" style="width: 25%;">Montant</th>
                                    <th scope="col" class="text-end" style="width: 20%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($salaires as $salaire): ?> 
                                    <tr>
                                        <td class="fw-bold text-secondary">#<?php echo $salaire['id']; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="btn-custom p-1 rounded-circle" style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                                    <i class="bi bi-building"></i>
                                                </div>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($salaire['libelle']); ?></span>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-success">+ <?php echo number_format($salaire['montant'], 2, ',', ' '); ?> €</td>
                                        <td class="text-end">
                                            <a href="listSalaire.php?action=delete&id=<?php echo $salaire['id']; ?>" class="btn-danger-custom" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce salaire ?');">
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
                        <i class="bi bi-cash-stack fs-1 text-gradient mb-3 d-block"></i>
                        <p class="fs-5">Aucun salaire enregistré pour le moment.</p>
                        <a href="salaire.php" class="btn btn-custom btn-sm mt-2"><i class="bi bi-plus-lg"></i> Ajouter mon premier salaire</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('commun/footer.php'); ?>
