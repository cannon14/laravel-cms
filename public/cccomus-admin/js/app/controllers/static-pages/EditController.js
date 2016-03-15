cccomus.controller('EditController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'StaticPages',
    function ($scope, $window, $resource, $location, utilities, StaticPages) {

        utilities.showInfo("Loading... Please Wait!");

        /**
         * Transform TextArea into CKEditor.
         */
        var editor = CKEDITOR.replace( 'content', {
            allowedContent: true
        });

        /**
         * Page Variables.
         */
        $scope.page = {};

        /**
         * Get the node id from node tree.
         */
        var node_id = utilities.getIdFromUrl();

        StaticPages.get({'id': node_id}, function(data) {

            $scope.page = data.pg;

            editor.setData(data.pg.content);
        });

        /**
         * Calls the server and update the page.
         */
        $scope.update = function() {

            $scope.page.content = editor.getData();
            StaticPages.update({id: node_id}, $scope.page,
                function(data) {
                    if(data.message) {
                        utilities.showSuccess("Page has been updated!");
                        $window.location.href= '/admin/static/pages';
                    }
                    else {
                        utilities.showError("Error occurred during page update.")
                    }
                },
                function(data) {
                    if(data.status == 422) {
                        angular.forEach(data.data, function (value, key) {
                            utilities.showError(value);
                        });
                    }
                    else {
                        utilities.showError(data.status + " Error Occurred");
                    }
                });
        };

        /**
         * Automatically generates the slug.
         */
        $('#title').blur(function() {
            var name = $scope.page.title;

            $scope.page.slug = utilities.generateSlug(name);
        })


    }]);