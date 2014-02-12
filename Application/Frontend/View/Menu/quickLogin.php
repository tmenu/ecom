<?php use Library\Utils; ?>

<?php if ($this->app['session']->isAuth()): ?>
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Mon compte">Mon compte <b class="caret"></b></a>
            <ul class="dropdown-menu" role="account">
                <li><a href="" title="Mon panier">Mon panier</a></li>
                <li><a href="" title="Mes informations">Mes informations</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo Utils::generateUrl('frontend.user.logout'); ?>" title="Deconnexion">Deconnexion</a></li>
            </ul>
        </li>
    </ul>
<?php else: ?>
    <form class="form-inline navbar-form navbar-right" role="form" method="post" action="<?php echo Utils::generateUrl('frontend.user.login'); ?>">
        <div class="form-group">
            <label class="sr-only" for="username">Login</label>
            <input type="text" class="form-control input-sm" id="username" name="username" placeholder="Nom d'utilisateur">
        </div>
        <div class="form-group">
            <label class="sr-only" for="password">Mot de passe</label>
            <input type="password" class="form-control input-sm" id="password" name="password" placeholder="Mot de passe">
        </div>
        <button type="submit" class="btn btn-sm btn-default">Connexion</button>
    </form>
<?php endif; ?>