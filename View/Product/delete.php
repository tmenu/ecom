<?php use Library\Utils; ?>

<h2>
    Supression d'un produit
    <a href="<?php echo Utils::generateUrl('product.index'); ?>" class="btn btn-default pull-right"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
</h2>

<form class="form-horizontal" role="form" method="post">

    <div class="alert alert-warning">
        <strong>Attention :</strong> Êtes-vous sûr de vouloir supprimer le produit <b><?php echo Utils::secure($product_name); ?></b> ?
    </div>
    
    <div class="form-group text-center">
        <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Supprimer</button>
        <a href="<?php echo Utils::generateUrl('product.index'); ?>" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
    </div>

</form>

