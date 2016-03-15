cccomus.controller('CreateController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Categories',
    function ($scope, $window, $resource, $location, utilities,  Categories) {

        utilities.showInfo("Loading... Please Wait!");

        var category_id = utilities.getIdFromUrl();

        /**
         * Category Variables.
         */
        $scope.category = {};

        /**
         * Transform TextArea into CKEditor.
         */
        var editor = CKEDITOR.replace( 'description' );

        /**
         * Get the current category data.
         */
        Categories.get({id:category_id}, function(data) {
            $scope.category = data.category;
            $scope.images = data.images;
            editor.setData(data.category.description);
        });

        /**
         * Calls the server and creates the category.
         */
        $scope.update = function() {

            $scope.category.description = editor.getData();

            Categories.update({id: category_id}, $scope.category,
                function(data) {
                    if(data.message) {
                        utilities.showSuccess("Category has been updated");

                        $window.location.href= '/admin/categories';
                    }
                    else {
                        utilities.showError("Error occurred during category update");
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