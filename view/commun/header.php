<?php
// Determine the base path for assets and navigation links
if (!isset($base_path)) {
    $base_path = "../";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fin du Mois - Gestion Financière</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo $base_path; ?>index.php">
                <i class="bi bi-wallet2 text-gradient fs-3"></i>
                <span>Fin du Mois</span>
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-3"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>index.php">
                            <i class="bi bi-house-door"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>view/salaire.php">
                            <i class="bi bi-cash-stack"></i> Salaire
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>view/depense.php">
                            <i class="bi bi-cart"></i> Dépense
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>view/epargne.php">
                            <i class="bi bi-piggy-bank"></i> Épargne
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>view/listSalaire.php">
                            <i class="bi bi-list-columns-reverse"></i> Liste Salaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>view/listDepenses.php">
                            <i class="bi bi-list-task"></i> Liste Dépenses
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mb-5">