<?php use Library\Utils; ?>

<h2>
    Liste des produits
    <a href="<?php echo Utils::generateUrl('product.add'); ?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> Créer produit</a>
</h2>

<table class="table table-hover">

    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Date ajout</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($products_list as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td>
                    <a href="<?php echo Utils::generateUrl('product.show', array(Utils::slugify($product['name']), $product['id'])); ?>">
                        <?php echo Utils::secure($product['name']); ?>
                    </a>
                </td>
                <td><?php echo $product['price']; ?> &euro;</td>
                <td><?php echo $product['date_created']; ?></td>
                <td>
                    <a href="<?php echo Utils::generateUrl('product.edit', array(Utils::slugify($product['name']), $product['id'])); ?>" title="Editer">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>&nbsp;
                    <a href="<?php echo Utils::generateUrl('product.delete', array(Utils::slugify($product['name']), $product['id'])); ?>" title="Supprimer">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>