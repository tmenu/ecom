<?php use Library\Utils; ?>

<h2>
    <?php echo $_MAIN_TITLE; ?>
    <a href="<?php echo Utils::generateUrl('backend.product.index'); ?>" class="btn btn-default pull-right" title="Liste produits">
        <span class="glyphicon glyphicon-arrow-left"></span> Liste produits
    </a>
</h2>

<?php echo $product_form->formStart(); ?>

    <div class="well row">

        <div class="col-sm-6">
            <?php

            echo $product_form->generateField('name');
            echo $product_form->generateField('price');
            echo $product_form->generateField('description');

            ?>
        </div>

        <div class="col-sm-6">
            <?php

            echo $product_form->generateField('image');

            ?>
        </div>

    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
    </div>

<?php echo $product_form->formEnd(); ?>
