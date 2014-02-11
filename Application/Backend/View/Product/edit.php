<?php use Library\Utils; ?>

<h2>
    Edition d'un produit
    <a href="<?php echo Utils::generateUrl('product.index'); ?>" class="btn btn-default pull-right"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
</h2>

<form class="form-horizontal" role="form" method="post">

    <div class="form-group <?php echo ((isset($form_errors['name'])) ? 'has-error' : ''); ?>">

        <label for="name" class="col-sm-2 control-label">Nom</label>

        <div class="col-sm-10">

            <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo Utils::postValue('name'); ?>">

            <?php if (isset($form_errors['name'])): ?>
                <div class="help-block"><?php echo $form_errors['name']; ?></div>
            <?php endif; ?>

        </div>

    </div>

    <div class="form-group <?php echo ((isset($form_errors['price'])) ? 'has-error' : ''); ?>">

        <label for="price" class="col-sm-2 control-label">Prix</label>

        <div class="col-sm-10">

            <input type="number" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo Utils::postValue('price'); ?>">

            <?php if (isset($form_errors['price'])): ?>
                <div class="help-block"><?php echo $form_errors['price']; ?></div>
            <?php endif; ?>

        </div>
    </div>

    <div class="form-group">

        <label for="image" class="col-sm-2 control-label">Image</label>

        <div class="col-sm-10">

            <span class="btn btn-default btn-file pull-left">
                <span class="glyphicon glyphicon-picture"></span> Parcourir <input type="file" name="image" id="image">
            </span>
            <div class="file-title pull-left">N/A</div>

            <?php if (isset($form_errors['image'])): ?>
                <div class="help-block"><?php echo $form_errors['image']; ?></div>
            <?php endif; ?>

        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Editer</button>
        </div>
    </div>

</form>

