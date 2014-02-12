<?php use Library\Utils; ?>
<h2>
  Edition d'un client
  <a class="btn btn-default pull-right" href="<?php echo Utils::generateUrl('backend.client.index'); ?>" title="Retour"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
</h2>
<form class="form-horizontal" role="form" id="form-client" method="POST">

  <div class="row">

    <div class="col-sm-6">

      <h3>Identifiants</h3>

      <div class="form-group  <?php echo ((isset($form_errors['username'])) ? 'has-error' : ''); ?>">
        <label for="username" class="col-sm-4 control-label">Nom d'utilisateur</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur" value="<?php echo Utils::postValue('username'); ?>">
          <?php if (isset($form_errors['username'])): ?>
           <div class="help-block"><?php echo $form_errors['username']; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group  <?php echo ((isset($form_errors['password'])) ? 'has-error' : ''); ?>">
        <label for="password" class="col-sm-4 control-label">Mot de passe</label>
        <div class="col-sm-8">
          <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
          <div class="help-block"><i>Laissez vide pour conserver le mot de passe actuelle</i></div>
          <?php if (isset($form_errors['password'])): ?>
           <div class="help-block"><?php echo $form_errors['password']; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group  <?php echo ((isset($form_errors['repassword'])) ? 'has-error' : ''); ?>">
        <label for="repassword" class="col-sm-4 control-label">Répéter mot de passe</label>
        <div class="col-sm-8">
          <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Mot de passe">
          <?php if (isset($form_errors['repassword'])): ?>
            <div class="help-block"><?php echo $form_errors['repassword']; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group  <?php echo ((isset($form_errors['email'])) ? 'has-error' : ''); ?>">
        <label for="email" class="col-sm-4 control-label">Adresse E-mail</label>
        <div class="col-sm-8">
          <input type="email" class="form-control" id="email" name="email" placeholder="exemple@exemple.fr" value="<?php echo Utils::postValue('email'); ?>">
          <?php if (isset($form_errors['email'])): ?>
              <div class="help-block"><?php echo $form_errors['email']; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group  <?php echo ((isset($form_errors['roles'])) ? 'has-error' : ''); ?>">
        <label for="roles" class="col-sm-4 control-label">Rôle(s)</label>
        <div class="col-sm-8">
          
          <select name="roles[]" id="role" multiple class="form-control">
            <?php foreach ($this->app['config']['roles'] as $key => $role): ?>
              <option value="<?php echo $key; ?>" <?php echo ((@in_array($key, $_POST['roles'])) ? 'selected' : ''); ?>><?php echo $role; ?></option>
            <?php endforeach; ?>
          </select>
          <div class="help-block"><i>Utilisez la touche CTRL pour une sélection multiple</i></div>

          <?php if (isset($form_errors['roles'])): ?>
              <div class="help-block"><?php echo $form_errors['roles']; ?></div>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <div class="col-sm-6">

      <h3>Coordonnées</h3>

      <div class="form-group  <?php echo ((isset($form_errors['lastname'])) ? 'has-error' : ''); ?>">
        <label for="lastname" class="col-sm-5 control-label">Nom</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom" value="<?php echo Utils::postValue('lastname'); ?>">
          <?php if (isset($form_errors['lastname'])): ?>
           <div class="help-block"><?php echo $form_errors['lastname']; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group  <?php echo ((isset($form_errors['firstname'])) ? 'has-error' : ''); ?>">
        <label for="firstname" class="col-sm-5 control-label">Prénom</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom" value="<?php echo Utils::postValue('firstname'); ?>">
          <?php if (isset($form_errors['firstname'])): ?>
           <div class="help-block"><?php echo $form_errors['firstname']; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group  <?php echo ((isset($form_errors['address'])) ? 'has-error' : ''); ?>">
        <label for="address" class="col-sm-5 control-label">Adresse</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" id="address" name="address[0]" placeholder="12, rue de la Liberté" value="<?php echo Utils::postValue('address.0'); ?>">
          <input type="text" class="form-control" name="address[1]" placeholder="" value="<?php echo Utils::postValue('address.1'); ?>">
          <?php if (isset($form_errors['address'])): ?>
           <div class="help-block"><?php echo $form_errors['address']; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group  <?php echo ((isset($form_errors['city'])) ? 'has-error' : ''); ?>">
        <label for="city" class="col-sm-5 control-label">Ville</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" id="city" name="city" placeholder="Paris" value="<?php echo Utils::postValue('city'); ?>">
          <?php if (isset($form_errors['city'])): ?>
           <div class="help-block"><?php echo $form_errors['city']; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group  <?php echo ((isset($form_errors['postal_code'])) ? 'has-error' : ''); ?>">
        <label for="postal_code" class="col-sm-5 control-label">Code postal</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="75000" value="<?php echo Utils::postValue('postal_code'); ?>">
          <?php if (isset($form_errors['postal_code'])): ?>
           <div class="help-block"><?php echo $form_errors['postal_code']; ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group  <?php echo ((isset($form_errors['country'])) ? 'has-error' : ''); ?>">
        <label for="country" class="col-sm-5 control-label">Pays</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" id="country" name="country" placeholder="France" value="<?php echo Utils::postValue('country'); ?>">
          <?php if (isset($form_errors['country'])): ?>
           <div class="help-block"><?php echo $form_errors['country']; ?></div>
          <?php endif; ?>
        </div>
      </div>

    </div>

  </div>

  <div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-save"></span> Editer</button>
  </div>
</form>
