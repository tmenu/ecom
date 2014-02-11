<?php use Library\Utils ?>
<h2>
	Liste des clients
	<a class="btn btn-primary pull-right" href="<?php echo Utils::makeURL('client.add'); ?>" title="Ajouter">Ajouter</a>
</h2>
<table class="table table-hover" id="table-client">
	<tr>
		<th>#</th>
		<th>Nom</th>
		<th>Email</th>
		<th>Date d'inscription</th>
		<th>Action</th>
	</tr>
	<?php foreach ($clients_list as $client) : ?>
		<tr>
			<td><?php echo $client['id']; ?></td>
			<td><?php echo Utils::secureHTML($client['username']); ?></td>
			<td><?php echo Utils::secureHTML($client['email']); ?></td>
			<td><?php echo $client['date_subscribed']; ?></td>
			<td>
				<a class="glyphicon glyphicon-edit" href="<?php echo Utils::makeURL('client.edit',  array($client['username'], $client['id'])); ?>" title="Editer"></a>
				<a class="glyphicon glyphicon-trash" href="<?php echo Utils::makeURL('client.delete', array($client['username'], $client['id'])); ?>" title="Supprimer"></a>
		 	</td>
		</tr>
	<?php endforeach; ?>
</table>
