<?php use Library\Utils; ?>

<h2>Connexion</h2>

<form class="form-horizontal" role="form" id="form-client" method="POST">

    <div class="well">

        <div class="form-group  <?php echo ((isset($form_errors['username'])) ? 'has-error' : ''); ?>">
            <label for="username" class="col-sm-4 control-label">Nom d'utilisateur</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur" value="<?php echo Utils::postValue('username'); ?>">
            </div>
        </div>

        <div class="form-group  <?php echo ((isset($form_errors['password'])) ? 'has-error' : ''); ?>">
            <label for="password" class="col-sm-4 control-label">Mot de passe</label>
                <div class="col-sm-8">
                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember_me"> Se souvenir de moi
                    </label>
                </div>
            </div>
        </div>

    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-save"></span> Connexion</button>
    </div>

</form>