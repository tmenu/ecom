<h1>Espace privé</h1>
<div id="admin-panel">
	<!-- Gestion des news -->
	<?php if ($this->app['session']->hasRole('ROLE_ADMIN') || $this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE')): ?>
		<div class="area area-news">
			<h3>News</h3>
			<ul>
				<li><a href="<?php echo makeURL('backend.news.index'); ?>">Liste</a></li>
				<li><a href="<?php echo makeURL('backend.news.add'); ?>">Ajouter</a></li>
			</ul>
		</div><!-- .area -->
	<?php endif; ?>
	
	<!-- Gestion des membres -->
	<?php if ($this->app['session']->hasRole('ROLE_ADMIN')): ?>
		<div class="area area-member">
			<h3>Membres</h3>
			<ul>
				<li><a href="<?php echo makeURL('backend.member.index'); ?>">Liste</a></li>
				<li><a href="<?php echo makeURL('backend.member.add'); ?>">Ajouter</a></li>
			</ul>
		</div><!-- .area -->
	<?php endif; ?>
	
	<!-- Gestion des professeurs -->
	<?php if ($this->app['session']->hasRole('ROLE_ADMIN') || $this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE')): ?>
		<div class="area area-teacher">
			<h3>Professeurs</h3>
			<ul>
				<li><a href="<?php echo makeURL('backend.professor.index'); ?>">Liste</a></li>
				<li><a href="<?php echo makeURL('backend.professor.add'); ?>">Ajouter</a></li>
			</ul>
		</div><!-- .area area-teacher -->
	<?php endif; ?>

	<!-- Gestion des tuteurs -->
	<?php if ($this->app['session']->hasRole('ROLE_ADMIN') || $this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE') || $this->app['session']->hasRole('RESPONSABLE_ENTREPRISE')): ?>
		<div class="area area-tutor">
			<h3>Tuteurs</h3>
			<ul>
				<li><a href="<?php echo makeURL('backend.tutor.index'); ?>">Liste</a></li>
				<li><a href="<?php echo makeURL('backend.tutor.add'); ?>">Ajouter</a></li>
			</ul>
		</div><!-- .area area-tutor -->
	<?php endif; ?>

	<!-- Gestion des student -->
	<?php if ($this->app['session']->hasRole('ROLE_ADMIN') || $this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE') || $this->app['session']->hasRole('RESPONSABLE_ENTREPRISE')): ?>
		<div class="area area-student">
			<h3>Etudiants</h3>
			<ul>
				<li><a href="<?php echo makeURL('backend.student.index'); ?>">Liste</a></li>
				<li><a href="<?php echo makeURL('backend.student.add'); ?>">Ajouter</a></li>
			</ul>
		</div><!-- .area area-student -->
	<?php endif; ?>

	<!-- Gestion du planning -->
	<div class="area area-planning">
		<h3>Planning</h3>
		<ul>
			<li><a href="<?php echo makeURL('backend.lesson.index'); ?>">Consulter</a></li>

			<?php if ($this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE') || $this->app['session']->hasRole('ROLE_ADMIN')): ?>
				<li><a href="<?php echo makeURL('backend.lesson.add'); ?>">Créer un cours</a></li>
			<?php endif; ?>
		</ul>
	</div><!-- .area -->

	<!-- Gestion des contrats -->
	<?php if ($this->app['session']->hasRole('ROLE_ADMIN') || $this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE') || $this->app['session']->hasRole('RESPONSABLE_ENTREPRISE')): ?>
		<div class="area area-contract">
			<h3>Contrats</h3>
			<ul>
				<li><a href="<?php echo makeURL('backend.contract.index'); ?>">Liste</a></li>
				<li><a href="<?php echo makeURL('backend.contract.add'); ?>">Ajouter</a></li>
			</ul>
		</div><!-- .area area-contract -->
	<?php endif; ?>

	<!-- Gestion des salles -->
	<?php if ($this->app['session']->hasRole('ROLE_ADMIN') || $this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE')): ?>
		<div class="area area-room">
			<h3>Salles</h3>
			<ul>
				<li><a href="<?php echo makeURL('backend.room.index'); ?>">Liste</a></li>
				<li><a href="<?php echo makeURL('backend.room.add'); ?>">Ajouter</a></li>
			</ul>
		</div><!-- .area -->
	<?php endif; ?>

	<!-- Gestion des classes -->
	<?php if ($this->app['session']->hasRole('ROLE_ADMIN') || $this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE')): ?>
		<div class="area area-classroom">
			<h3>Classes</h3>
			<ul>
				<li><a href="<?php echo makeURL('backend.classroom.index'); ?>">Liste</a></li>
				<li><a href="<?php echo makeURL('backend.classroom.add'); ?>">Ajouter</a></li>
			</ul>
		</div><!-- .area -->
	<?php endif; ?>

	<!-- Gestion des présences -->
	<div class="area area-presence">
		<h3>Présences</h3>
		<ul>
			<li><a href="<?php echo makeURL('backend.presence.index'); ?>">Liste</a></li>
			<?php if ($this->app['session']->hasRole('ROLE_ADMIN') || $this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE')): ?>
				<li><a href="<?php echo makeURL('backend.presence.add'); ?>">Ajouter</a></li>
			<?php endif; ?>
		</ul>
	</div><!-- .area -->
	
	<!-- Gestion des evaluation -->
		<div class="area area-evaluation">
			<h3>Evaluation</h3>
			<ul>
				<li><a href="<?php echo makeURL('backend.evaluation.index'); ?>">Liste</a></li>
				<?php if ($this->app['session']->hasRole('ROLE_ADMIN') || $this->app['session']->hasRole('SECRETAIRE_PEDAGOGIQUE')): ?>
					<li><a href="<?php echo makeURL('backend.evaluation.add'); ?>">Ajouter</a></li>
				<?php endif; ?>
			</ul>
		</div><!-- .area -->
</div><!-- #admin -->