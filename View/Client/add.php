<?php use Library\Utils; ?>
<h2>
	Ajouter
	<a class="btn btn-default pull-right" href="<?php echo Utils::makeURL('client.index'); ?>" title="Retour">Retour</a>
</h2>
<form class="form-horizontal" role="form" id="form-client" method="POST">
  <div class="form-group">
    <label for="username" class="col-sm-4 control-label">Nom d'utilisateur</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur" value="<?php echo Utils::postValue('username'); ?>">
      <?php if (isset($form_errors['username'])): ?>
				<span class="input-error"><?php echo $form_errors['username']; ?></span>
			<?php endif; ?>
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="col-sm-4 control-label">Mot de passe</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
      <?php if (isset($form_errors['password'])): ?>
				<span class="input-error"><?php echo $form_errors['password']; ?></span>
			<?php endif; ?>
    </div>
  </div>
  <div class="form-group">
    <label for="repassword" class="col-sm-4 control-label">Répéter mot de passe</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Mot de passe">
      <?php if (isset($form_errors['repassword'])): ?>
				<span class="input-error"><?php echo $form_errors['repassword']; ?></span>
			<?php endif; ?>
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="col-sm-4 control-label">Adresse E-mail</label>
    <div class="col-sm-8">
      <input type="email" class="form-control" id="email" name="email" placeholder="exemple@exemple.fr" value="<?php echo Utils::postValue('email'); ?>">
      <?php if (isset($form_errors['email'])): ?>
				<span class="input-error"><?php echo $form_errors['email']; ?></span>
			<?php endif; ?>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
  </div>
</form>
