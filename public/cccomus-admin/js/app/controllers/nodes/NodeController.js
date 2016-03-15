/**
 * Created by cannon14 on 11/14/15.
 */
cccomus.controller('NodeController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Nodes',
    'Pages',
    function ($scope, $window, $resource, utilities, Nodes, Pages) {

        /**
         * Options for the File Tree
         * @type {{removed: Function}}
         */
        $scope.treeOptions = {
            removed: function(node) {
            }
        };

        /**
         * Delete a directory.
         * @param scope
         */
        $scope.deleteDirectory = function(scope) {
            var nodeData = scope.$modelValue,
                confirm = $window.confirm('Are you sure you wish to delete this directory?');

            if(confirm) {
                Nodes.delete({id : nodeData.id}, function (data) {
                    if (data.message) {
                        scope.remove();
                        utilities.showSuccess('Directory has been deleted.');
                    }
                    else {
                        utilities.showError('Error occurred deleting Directory.');
                    }
                });
            }
        };

        /**
         * Delete a node from the file tree.
         * @param scope
         */
        $scope.deleteFile = function (scope) {

            var nodeData = scope.$modelValue,
                confirm = $window.confirm('Are you sure you wish to delete this file?');

            if(confirm) {
                Pages.delete({id : nodeData.id}, function (data) {
                    if (data.message) {
                        Nodes.delete({id: nodeData.id}, function (data) {
                            if(data.message) {
                                utilities.showSuccess('Page has been deleted.');
                                scope.remove();
                            }
                            else {
                                utilities.showError('Error occurred deleting.');
                            }
                        });
                    }
                    else {
                        utilities.showError('Error occurred deleting.');
                    }
                });

            }
        };


        /**
         * Redirect to page edit.
         * @param scope
         */
        $scope.edit = function(scope) {
            var nodeData = scope.$modelValue;
            $window.location = '/admin/pages/edit/'+nodeData.id;
        };

        /**
         * Show the page.
         * @param scope
         */
        $scope.editCode = function(scope) {
            var nodeData = scope.$modelValue;
            $window.location = '/admin/code/edit/'+nodeData.id;
        };

        /**
         * Toggle expansion.
         * @param scope
         */
        $scope.toggle = function (scope) {
            scope.toggle();
        };

        /**
         * Add a directory to the file tree.
         * @param scope
         */
        $scope.addDirectory = function (scope) {

            var nodeData = scope.$modelValue,
                title = window.prompt("Enter Directory Name",""),
                id = nodeData.id,
                type = 'directory';

            Nodes.store(null, {node_id: id, title:title, type:type}, function (data) {

                console.log(data.node);

                if(data.node) {
                    nodeData.nodes.push({
                        id: data.node.node_id,
                        title: data.node.title,
                        type: data.node.type,
                        nodes: []
                    });
                }
                else {
                    utilities.showError('An error occurred adding directory');
                }
            });
        };

        /**
         * Add a file to the file tree.
         * @param scope
         */
        $scope.addFile = function (scope) {
            var nodeData = scope.$modelValue,
                title = window.prompt("Enter File Name",""),
                id = nodeData.id,
                type = 'file';

            Nodes.store(null, {node_id: id, title:title, type:type}, function (data) {
                if(Object.keys(data).length > 0) {
                    Pages.store(null, {node_id: data.node.node_id, title:title}, function(pageData) {
                        if(pageData.message) {
                            nodeData.nodes.push({
                                id: data.node.node_id,
                                title: data.node.title,
                                type: data.node.type,
                                nodes: []
                            });
                            $window.location = '/admin/pages/edit/'+data.node.node_id+'/#?title='+title;
                        }
                        else {
                            utilities.showError('An error occurred adding file');
                        }
                    });
                }
                else {
                    utilities.showError('An error occurred adding file');
                }
            });
        };

        $scope.collapseAll = function () {
            $scope.$broadcast('collapseAll');
        };

        $scope.expandAll = function () {
            $scope.$broadcast('expandAll');
        };

        /**
         * Get all the nodes for the file tree.
         */
        Nodes.all(null, null, function (data) {
            $scope.data = data.nodes;
        });
    }]);
