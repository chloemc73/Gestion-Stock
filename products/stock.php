<?php
/**
 * stock.php
 * @package default
 */
$page_title = 'tous le stock';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);

$all_stock = find_all('stock');
$all_products = find_all('products');
?>

<?php include_once '../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Notification pour les stocks bas -->
        <div id="low-stock-alert" class="alert alert-warning" style="display: none;">
            <strong>Alerte !</strong> Certains produits ont un stock bas. Veuillez les réapprovisionner.
        </div>

        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Journal d'inventaire</span>
                </strong>
                <div class="pull-right">
                    <a href="../products/add_stock.php" class="btn btn-primary" style="background-color:rgb(255, 143, 99)"
                    >Ajouter le stock</a>
                </div>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">produits</th>
                            <th class="text-center" style="width: 50px;">Quantité</th>
                            <th class="text-center" style="width: 50px;">Commentaire</th>
                            <th class="text-center" style="width: 50px;">Date</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($all_stock as $stock): ?>
                        <tr>
                            <td class="text-center">
                                <a href="../products/view_product.php?id=<?php echo (int)$stock['product_id']; ?>">
                                    <?php
                                    foreach ($all_products as $product) {
                                        if ($stock['product_id'] == $product['id']) {
                                            echo $product['name'];
                                        }
                                    }
                                    ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <?php echo $stock['quantity']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $stock['comments']; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $stock['date']; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="../products/edit_stock.php?id=<?php echo (int)$stock['id']; ?>"
                                       class="btn btn-xs btn-warning" data-toggle="tooltip" title="Modifier">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a href="../products/delete_stock.php?id=<?php echo (int)$stock['id']; ?>"
                                       onClick="return confirm('Êtes-vous sûr de vouloir supprimer?')"
                                       class="btn btn-xs btn-danger" data-toggle="tooltip" title="Supprimer">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Vérifier si le stock est bas
    const lowStockAlert = document.getElementById('low-stock-alert');
    const stockRows = document.querySelectorAll('tbody tr');
    let lowStockPresent = false;

    stockRows.forEach(row => {
        const quantityCell = row.querySelector('td:nth-child(2)'); // La deuxième colonne est la quantité
        if (parseInt(quantityCell.textContent) < 5) { // Vérifie si la quantité est inférieure à 5
            lowStockPresent = true;
        }
    });

    // Afficher l'alerte si un stock bas est détecté
    if (lowStockPresent) {
        lowStockAlert.style.display = 'block'; // Affiche l'alerte si le stock est bas
    }
</script>

<?php include_once '../layouts/footer.php'; ?>