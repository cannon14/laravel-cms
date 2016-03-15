cccomus.controller('CreateController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Pages',
    function ($scope, $window, $resource, $location, utilities,  Pages) {

        utilities.showInfo("Loading... Please Wait!");

        /**
         * Transform TextArea into CKEditor.
         */
        var editor = CKEDITOR.replace( 'description', {
            allowedContent: true
        } );

        /**
         * Page Variables.
         */
        $scope.page = {};
        $scope.page.active = 1;
        $scope.page.title = $location.search().title;

        /**
         * Calls the server and creates the page.
         */
        $scope.create = function() {

            $scope.page.description = editor.getData();

            Pages.store($scope.page,
                function(data) {
                    if(data.message) {
                        utilities.showSuccess("Page has been created!");
                        $window.location.href= '/admin/pages';
                    }
                    else {
                        utilities.showError("Error occurred during page creation");
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