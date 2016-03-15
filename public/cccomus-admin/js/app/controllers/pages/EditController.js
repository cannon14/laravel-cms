cccomus.controller('EditController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Pages',
    function ($scope, $window, $resource, $location, utilities, Pages) {

        utilities.showInfo("Loading... Please Wait!");

        /**
         * Transform TextArea into CKEditor.
         */
        var editor = CKEDITOR.replace( 'description', {
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

        Pages.edit({'id': node_id}, function(data) {

            $scope.page = data.pg;

            editor.setData(data.pg.description);

            $scope.templates = data.templates;
            $scope.categories = data.categories;
            $scope.schumerTypes = data.schumerTypes;
            $scope.pageTypes = data.pageTypes;

        });

        /**
         * Calls the server and update the page.
         */
        $scope.update = function() {

            $scope.page.description = editor.getData();
            Pages.update({id: node_id}, $scope.page,
                function(data) {
                    if(data.message) {
                        utilities.showSuccess("Page has been updated!");
                        $window.location.href= '/admin/pages';
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

        $('#assign-cards-button').click(function() {
            $window.location.href= '/admin/pages/cards/'+node_id;
        });

        /**
         * Automatically generates the slug.
         */
        $('#title').blur(function() {
            var name = $scope.page.title;

            $scope.page.slug = utilities.generateSlug(name);
        })


    }]);