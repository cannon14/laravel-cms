cccomus.controller('CreateController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Categories',
    function ($scope, $window, $resource, $location, utilities,  Categories) {

        utilities.showInfo("Loading... Please Wait!");


        /**
         * Category Variables.
         */
        $scope.category = {};

        /**
         * Transform TextArea into CKEditor.
         */
        var editor = CKEDITOR.replace( 'description' );


        /**
         * Calls the server and creates the category.
         */
        $scope.create = function() {

            $scope.category.description = editor.getData();

            Categories.store($scope.category,
                function(data) {
                    if(data.message) {
                        utilities.showSuccess("Category has been created!");

                        $window.location.href= '/admin/categories';
                    }
                    else {
                        utilities.showError("Error occurred during category creation");
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
        $('#name').blur(function() {
            var name = $scope.category.name;

            $scope.category.slug = utilities.generateSlug(name);
        })

    }]);