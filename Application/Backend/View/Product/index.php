<?php use Library\Utils; ?>

<h2>
    Liste des produits
    <span class="pull-right">
        <a href="<?php echo Utils::generateUrl('backend.product.add'); ?>" class="btn btn-primary" title="Créer produit">
            <span class="glyphicon glyphicon-plus"></span> Créer produit
        </a>
        <a class="btn btn-default" href="<?php echo Utils::generateUrl('backend.admin.index'); ?>" title="Administration">
            <span class="glyphicon glyphicon-arrow-left"></span> Administration
        </a>
    </span>
</h2>

<table class="table table-hover">

    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Date ajout</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($products_list)): ?>
            <tr>
                <td colspan="5" class="text-center">Aucun produit</td>
        <?php else: ?>
            <?php foreach ($products_list as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td>
                        <a href="<?php echo Utils::generateUrl('backend.product.show', array(Utils::slugify($product['name']), $product['id'])); ?>">
                            <?php echo Utils::secure($product['name']); ?>
                        </a>
                    </td>
                    <td><?php echo $product['price']; ?> &euro;</td>
                    <td><?php echo $product['date_created']; ?></td>
                    <td><?php echo nl2br(Utils::secure(Utils::truncate($product['description'], 60))); ?></td>
                    <td>
                        <a href="<?php echo Utils::generateUrl('backend.product.edit', array(Utils::slugify($product['name']), $product['id'])); ?>" title="Editer"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;
                        <a href="<?php echo Utils::generateUrl('backend.product.delete', array(Utils::slugify($product['name']), $product['id'])); ?>" title="Supprimer"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>

</table>