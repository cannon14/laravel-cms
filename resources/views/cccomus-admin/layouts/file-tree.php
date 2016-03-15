<!-- Nested node template -->
<div ng-controller="NodeController">
	<script type="text/ng-template" id="nodes_renderer.html">
		<div ui-tree-handle class="tree-node tree-node-content">
			<a class="btn btn-success btn-xs" ng-if="node.type == 'directory'" data-nodrag ng-click="toggle(this)">
				<span class="glyphicon"
					  ng-class="{'glyphicon-folder-close': collapsed,'glyphicon-folder-open': !collapsed}"></span>
			</a>
			<span class="glyphicon glyphicon-file" ng-show="node.type == 'file'"></span>
			<a href="#" ng-if="node.type == 'file' || node.type == 'template'" data-nodrag ng-click="editCode(this)">
			{{node.title}}
			</a>
			<span ng-show="node.type == 'directory'">
			{{node.title}}
			</span>

			<!--Delete function if node type is a directory-->
			<a class="pull-right btn btn-danger btn-xs" data-nodrag ng-click="deleteDirectory(this)"
			   ng-show="node.type == 'directory' && node.title != '/'" style="margin-right:8px">
				<span class="glyphicon glyphicon-remove"></span></a>

			<!--Delete function if node type is a file-->
			<a class="pull-right btn btn-danger btn-xs" data-nodrag ng-click="deleteFile(this)"
			   ng-show="node.type == 'file'" style="margin-right:8px">
				<span class="glyphicon glyphicon-remove"></span></a>

			<!--Edit function if node type is a file-->
			<a class="pull-right btn btn-warning btn-xs" data-nodrag ng-click="edit(this)"
			   ng-show="node.type == 'file'" style="margin-right: 8px ">
				<span class="glyphicon glyphicon-pencil"></span></a>

			<!--Add file function if node type is a directory-->
			<a class="pull-right btn btn-info btn-xs" data-nodrag ng-click="addFile(this)"
			   ng-show="node.type == 'directory'" style="margin-right: 8px;">
				<span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-file"></span></a>

			<!--Add a directory if node type is the root directory-->
			<a class="pull-right btn btn-primary btn-xs" data-nodrag ng-click="addDirectory(this)"
			   ng-show="node.type == 'directory'" style="margin-right: 8px;">
				<span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-folder-close"></span></a>
		</div>
		<ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}">
			<li ng-repeat="node in node.nodes" ui-tree-node ng-include="'nodes_renderer.html'">
			</li>
		</ol>
	</script>

	<div class="row">
		<div class="col-lg-12">
			<h3>File Tree</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div ui-tree="treeOptions" id="tree-root">
				<ol ui-tree-nodes ng-model="data">
					<li ng-repeat="node in data" data-nodrag ui-tree-node ng-include="'nodes_renderer.html'"></li>
				</ol>
			</div>
		</div>
	</div>
</div>
