<?php use Library\Utils; ?>
<h2>
	Suppression d'un client
	<a class="btn btn-default pull-right" href="<?php echo Utils::generateUrl('client.index'); ?>" title="Retour"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
</h2>
<form class="form-horizontal" role="form" method="post">

    <div class="alert alert-warning">
        <strong>Attention :</strong> Êtes-vous sûr de vouloir supprimer le client <b><?php echo Utils::secure($client_name); ?></b> ?
    </div>
    
    <div class="form-group text-center">
        <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Supprimer</button>
        <a href="<?php echo Utils::generateUrl('client.index'); ?>" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
    </div>

</form>