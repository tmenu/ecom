<?php use Library\Utils; ?>
<h2>
  Edition d'un client
  <a class="btn btn-default pull-right" href="<?php echo Utils::generateUrl('client.index'); ?>" title="Retour"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
</h2>
<form class="form-horizontal" role="form" id="form-client" method="POST">
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
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Ajouter</button>
    </div>
  </div>
</form>
