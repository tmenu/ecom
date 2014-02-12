<?php use Library\Utils; ?>

<h2>
    Edition d'un produit
    <a href="<?php echo Utils::generateUrl('backend.product.index'); ?>" class="btn btn-default pull-right" title="Liste produits">
        <span class="glyphicon glyphicon-arrow-left"></span> Liste produits
    </a>
</h2>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

    <div class="row well">

        <div class="col-sm-6">

            <div class="form-group <?php echo ((isset($form_errors['name'])) ? 'has-error' : ''); ?>">
                <label for="name" class="col-sm-3 control-label">Nom</label>

                <div class="col-sm-9">

                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo Utils::postValue('name'); ?>">

                    <?php if (isset($form_errors['name'])): ?>
                        <div class="help-block"><?php echo $form_errors['name']; ?></div>
                    <?php endif; ?>

                </div>
            </div>

            <div class="form-group <?php echo ((isset($form_errors['price'])) ? 'has-error' : ''); ?>">
                <label for="price" class="col-sm-3 control-label">Prix</label>

                <div class="col-sm-9">

                    <input type="number" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo Utils::postValue('price'); ?>">

                    <?php if (isset($form_errors['price'])): ?>
                        <div class="help-block"><?php echo $form_errors['price']; ?></div>
                    <?php endif; ?>

                </div>
            </div>

            <div class="form-group <?php echo ((isset($form_errors['description'])) ? 'has-error' : ''); ?>">
                <label for="description" class="col-sm-3 control-label">Description</label>

                <div class="col-sm-9">

                    <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description"><?php echo Utils::postValue('description'); ?></textarea>

                    <?php if (isset($form_errors['description'])): ?>
                        <div class="help-block"><?php echo $form_errors['description']; ?></div>
                    <?php endif; ?>

                </div>
            </div>

        </div>

        <div class="col-sm-6">

            <div class="form-group <?php echo ((isset($form_errors['image'])) ? 'has-error' : ''); ?>">
                <label for="image" class="col-sm-3 control-label">Image</label>

                <div class="col-sm-9">

                    <div class="form-group">
                        <span class="btn btn-default btn-file pull-left">
                            <span class="glyphicon glyphicon-picture"></span> Parcourir <input type="file" name="image" id="image">
                        </span>
                        <div class="file-title pull-left">N/A</div>
                    </div>
                    <div class="help-block"><i>Laissez vide pour conserver l'image actuelle</i></div>

                    <?php if (isset($form_errors['image'])): ?>
                        <div class="help-block"><?php echo $form_errors['image']; ?></div>
                    <?php endif; ?>

                    <div class="help-block">
                        Image actuelle :
                        <img src="<?php echo Utils::postValue('image'); ?>" alt="Image" class="product-image thumbnail" />
                    </div>

                </div>
            </div>

        </div>

    </div>
    
    <div class="form-group text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-save"></span> Editer</button>
    </div>

</form>

