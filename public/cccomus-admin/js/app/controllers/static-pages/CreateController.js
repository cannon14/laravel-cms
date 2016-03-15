cccomus.controller('CreateController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'StaticPages',
    function ($scope, $window, $resource, $location, utilities,  StaticPages) {

        utilities.showInfo("Loading... Please Wait!");

        /**
         * Transform TextArea into CKEditor.
         */
        var editor = CKEDITOR.replace( 'content', {
            allowedContent: true
        } );

        /**
         * Page Variables.
         */
        $scope.page = {};
        $scope.page.active = 1;

        /**
         * Calls the server and creates the page.
         */
        $scope.create = function() {

            $scope.page.content = editor.getData();

            StaticPages.store($scope.page,
                function(data) {
                    if(data.message) {
                        utilities.showSuccess("Page has been created!");
                        $window.location.href= '/admin/static/pages';
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
            var title = $scope.page.title;

            $scope.page.slug = utilities.generateSlug(title);
        })

    }]);