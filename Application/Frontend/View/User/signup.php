<?php use Library\Utils; ?>

<h2>Inscription</h2>

<?php echo $signup_form->formStart(); ?>

    <div class="well">
        <h4>Identifiants</h4>
        <?php

        echo $signup_form->generateField('username');
        echo $signup_form->generateField('password');
        echo $signup_form->generateField('confirm_password');
        echo $signup_form->generateField('email');

        ?>
    </div>

    <div class="well">
        <h4>Coordonnées</h4>
        <?php

        echo $signup_form->generateField('lastname', 3);
        echo $signup_form->generateField('firstname', 3);
        echo $signup_form->generateField('address0', 3);
        echo $signup_form->generateField('address1', 3);
        echo $signup_form->generateField('city', 3);
        echo $signup_form->generateField('postal_code', 3);
        echo $signup_form->generateField('country', 3);

        ?>
    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-lg btn-primary">S'inscrire</button>
    </div>

<?php echo $signup_form->formEnd(); ?>