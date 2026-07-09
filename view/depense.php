<?php 
include("../bdd/bdd.php");

$error = '';
if (isset($_POST['libelle'])) {
    $libelle = trim($_POST['libelle']);
    $categorie = trim($_POST['categorie']);
    $montant = floatval($_POST['montant']);
    
    if (!empty($libelle) && !empty($categorie) && $montant > 0) {
        $requete = $bdd->prepare("INSERT INTO depense(libelle, categorie, montant) VALUES (:libelle, :categorie, :montant)");
        $requete->bindParam(':libelle', $libelle);
        $requete->bindParam(':categorie', $categorie);
        $requete->bindParam(':montant', $montant);
        $requete->execute();
        
        header('Location: listDepenses.php');
        exit();
    } else {
        $error = 'Veuillez remplir tous les champs correctement.';
    }
}

include('commun/header.php'); 
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card card-custom">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="bi bi-cart text-gradient me-2"></i>Ajouter une dépense</h3>
                <a href="listDepenses.php" class="btn btn-sm btn-custom bg-transparent border-secondary text-secondary" style="border: 1px solid var(--card-border) !important;"><i class="bi bi-list"></i> Liste</a>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.15); border-color: rgba(239, 68, 68, 0.2); color: var(--accent-danger);" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="mb-4">
                        <label for="libelle" class="form-label text-secondary fw-semibold">Nom de la dépense</label>
                        <div class="input-group">
                            <span class="input-group-text form-control-custom bg-transparent border-end-0 text-secondary" style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;"><i class="bi bi-tag"></i></span>
                            <input type="text" class="form-control form-control-custom border-start-0" style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" id="libelle" name="libelle" placeholder="Ex: Courses mensuelles" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="categorie" class="form-label text-secondary fw-semibold">Catégorie</label>
                        <div class="input-group">
                            <span class="input-group-text form-control-custom bg-transparent border-end-0 text-secondary" style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;"><i class="bi bi-grid"></i></span>
                            <input type="text" class="form-control form-control-custom border-start-0" style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" id="categorie" name="categorie" placeholder="Ex: Alimentation, Transport, Loisirs" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="montant" class="form-label text-secondary fw-semibold">Montant (€)</label>
                        <div class="input-group">
                            <span class="input-group-text form-control-custom bg-transparent border-end-0 text-secondary" style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;"><i class="bi bi-currency-euro"></i></span>
                            <input type="number" step="0.01" class="form-control form-control-custom border-start-0" style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" id="montant" name="montant" placeholder="Ex: 85.50" required>
                        </div>
                    </div>

                    <button type="submit" name="valider" class="btn btn-custom w-100 py-3 mt-2" style="background: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);">
                        <i class="bi bi-plus-circle-fill"></i> Enregistrer la dépense
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('commun/footer.php'); ?>