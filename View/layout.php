<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title><?php echo ((isset($_MAIN_TITLE)) ? $_MAIN_TITLE.' - ' : '') . $this->app['config']['site_name']; ?></title>
		
		<?php foreach ($css_files as $file): ?>
			<link rel="stylesheet" href="/css/<?php echo $file; ?>">
		<?php endforeach; ?>

		<?php foreach ($js_files as $file): ?>
			<script src="/js/<?php echo $file; ?>"></script>
		<?php endforeach; ?>
	</head>

	<body>

		<div class="container">

			<nav class="navbar navbar-inverse" role="navigation">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"><?php echo $this->app['config']['site_name']; ?></a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">

							<?php foreach ($this->app['config']['menu'] as $title => $data):
								$active = ($data['url'] == $this->app['request']->requestUri()) ? 'active ' : '';

						  		if (isset($data['sub'])): ?>
						  			<li class="<?php echo $active; ?>dropdown">
						  				<a href="<?php echo $data['url']; ?>" class="dropdown-toggle" data-toggle="dropdown">
							        		<?php echo $title; ?> <b class="caret"></b>
							        	</a>
							        	<ul class="dropdown-menu" role="menu">
						        			<?php foreach ($data['sub'] as $title_sub => $data_sub): ?>

						        				<?php if ($title_sub == 'divider'): ?>
						        					<li class="divider"></li>
							        			<?php else: ?>
							        				<li><a href="<?php echo $data_sub['url']; ?>"><?php echo $title_sub; ?></a></li>
							        			<?php endif; ?>
											    
											<?php endforeach; ?>
										</ul>
						        	</li>
						  		<?php else: ?>
						  			<li class="<?php echo $active; ?>">
						  				<a href="<?php echo $data['url']; ?>">
							        		<?php echo $title; ?>
							        	</a>
							        </li>
							    <?php endif; ?>

						    <?php endforeach; ?>

						</ul>
						<form class="form-inline navbar-form navbar-right" role="form">
							<div class="form-group">
								<label class="sr-only" for="username">Login</label>
								<input type="email" class="form-control input-sm" id="username" name="username" placeholder="Login">
							</div>
							<div class="form-group">
								<label class="sr-only" for="password">Mot de passe</label>
								<input type="password" class="form-control input-sm" id="password" name="password" placeholder="Mot de passe">
							</div>
							<button type="submit" class="btn btn-sm btn-default">Connexion</button>
						</form>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>

			<div class="main-container row">

				<div class="col-sm-9">

					<?php if (($flashs = $this->app['session']->getFlashMessage()) !== false): ?>

						<?php foreach ($flashs as $flash): ?>
							<div class="alert alert-<?php echo $flash['type']; ?> alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  								<strong><?php echo ucfirst($flash['type']); ?> :</strong> <?php echo $flash['message']; ?>
							</div>
						<?php endforeach; ?>

					<?php endif; ?>

					<?php echo $__CONTENT; ?>

				</div>

				<div class="col-sm-3">
					<div class="sidebar-module sidebar-module-inset">
						<h4>About</h4>
						<p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
					</div>
					<div class="sidebar-module">
						<h4>Archives</h4>
						<ol class="list-unstyled">
							<li><a href="#">January 2014</a></li>
							<li><a href="#">December 2013</a></li>
							<li><a href="#">November 2013</a></li>
							<li><a href="#">October 2013</a></li>
							<li><a href="#">September 2013</a></li>
							<li><a href="#">August 2013</a></li>
							<li><a href="#">July 2013</a></li>
							<li><a href="#">June 2013</a></li>
							<li><a href="#">May 2013</a></li>
							<li><a href="#">April 2013</a></li>
							<li><a href="#">March 2013</a></li>
							<li><a href="#">February 2013</a></li>
						</ol>
					</div>
					<div class="sidebar-module">
						<h4>Elsewhere</h4>
						<ol class="list-unstyled">
							<li><a href="#">GitHub</a></li>
							<li><a href="#">Twitter</a></li>
							<li><a href="#">Facebook</a></li>
						</ol>
					</div>
				</div><!-- /.blog-sidebar -->

			</div>

		</div>

		<footer>
			<p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
			<p>
				<a href="#">Back to top</a>
			</p>
		</footer>

		<?php foreach ($js_end_files as $file): ?>
			<script src="/js/<?php echo $file; ?>"></script>
		<?php endforeach; ?>

	</body>
</html>