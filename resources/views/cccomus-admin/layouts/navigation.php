<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ route('admin.dashboard') }}"><img src="/images/logo.png" alt="Creditcards.com" width="75%"></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active"><a href="{{ route('admin.dashboard') }}">Dashboard <span class="sr-only">(current)</span></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Layouts<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin.layouts') }}">View Layouts</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('admin.layouts.create') }}">Add Layout</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Templates <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin.templates') }}">View Templates</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Content Blocks <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin.content-blocks') }}">View Content Blocks</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('admin.content-blocks.create') }}">Add Content Block</a></li>
					</ul>
				</li>
				<!--
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="">View Pages</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="">Add Page</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="">View Categories</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="">Add Category</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Issuers <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="">View Issuers</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="">Add Issuer</a></li>
					</ul>
				</li>
				-->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cards <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin.cards') }}">View Cards</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Feeds <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin.feeds') }}">View Feeds</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('admin.feeds.create') }}">Add Feed</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin.users') }}">View Users</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('admin.users.create') }}">Add User</a></li>
					</ul>
				</li>
				<li><a href="{{ route('admin.help') }}">Help</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Login</a></li>
						<li role="separator" class="divider"></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>