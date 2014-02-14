<?php use Library\Utils ?>
<h2>
	Liste des clients
	<span class="pull-right">
		<a class="btn btn-primary" href="<?php echo Utils::generateUrl('backend.client.add'); ?>" title="Créer client">
			<span class="glyphicon glyphicon-plus"></span> Créer client
		</a>
		<a class="btn btn-default" href="<?php echo Utils::generateUrl('backend.admin.index'); ?>" title="Administration">
			<span class="glyphicon glyphicon-arrow-left"></span> Administration
		</a>
	</span>
</h2>

<table class="table table-hover" id="table-client">

	<thead>
		<tr>
			<th>#</th>
			<th>Nom d'utilisateur</th>
			<th>Email</th>
			<th>Nom prénom</th>
			<th>Date d'inscription</th>
			<th>Droit(s)</th>
			<th>Action</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($clients_list as $client) : ?>
			<tr>
				<td><?php echo $client['id']; ?></td>
				<td><?php echo Utils::secure($client['username']); ?></td>
				<td><?php echo Utils::secure($client['email']); ?></td>
				<td><?php echo Utils::secure($client['lastname'] . ' ' . $client['firstname']); ?></td>
				<td><?php echo $client['date_subscribed']; ?></td>
				<td class="text-left">
					<ul>
					<?php foreach ($client['roles'] as $role): ?>
						<li><?php echo $this->app['config']['roles'][$role]; ?></li>
					<?php endforeach; ?>
					</ul>
				</td>
				<td>
					<a class="glyphicon glyphicon-edit" href="<?php echo Utils::generateUrl('backend.client.edit',  array(Utils::slugify($client['username']), $client['id'])); ?>" title="Editer"></a>
					<a class="glyphicon glyphicon-trash" href="<?php echo Utils::generateUrl('backend.client.delete', array(Utils::slugify($client['username']), $client['id'])); ?>" title="Supprimer"></a>
			 	</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
