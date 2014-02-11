<?php use Library\Utils ?>
<h2>Liste des clients</h2>

<table class="table table-hover" id="table-client">
	<tr>
		<th>#</th>
		<th>Nom</th>
		<th>Email</th>
		<th>Date d'inscription</th>
	</tr>
	<?php foreach ($clients_list as $client) : ?>
		<tr>
			<td><?php echo $client['id']; ?></td>
			<td><?php echo Utils::secureHTML($client['username']); ?></td>
			<td><?php echo Utils::secureHTML($client['email']); ?></td>
			<td><?php echo $client['date_subscribed']; ?></td>
		</tr>
	<?php endforeach;?>
</table>
