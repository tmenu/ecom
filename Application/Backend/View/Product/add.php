<?php use Library\Utils; ?>

<h2>
    Création d'un nouveau produit
    <a href="<?php echo Utils::generateUrl('backend.product.index'); ?>" class="btn btn-default pull-right"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
</h2>

<form class="form-horizontal" role="form" method="post">

    <?php include 'product_form.php'; ?>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Ajouter</button>
        </div>
    </div>

</form>

