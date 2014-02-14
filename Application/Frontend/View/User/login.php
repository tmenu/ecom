<?php use Library\Utils; ?>

<h2>Connexion</h2>

<?php echo $login_form->formStart(); ?>

    <div class="well">
        <?php 
        echo $login_form->generateField('username'); 
        echo $login_form->generateField('password'); 
        ?>
    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-lg btn-primary">Connexion</button>
    </div>

<?php echo $login_form->formEnd(); ?>