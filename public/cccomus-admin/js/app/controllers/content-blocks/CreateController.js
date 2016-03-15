cccomus.controller('CreateController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'ContentBlocks',
    function ($scope, $window, $resource, utilities, ContentBlocks) {

        utilities.showInfo("Loading... Please Wait!")

        /**
         * Transform TextArea into CKEditor.
         */
        var editor = CKEDITOR.replace( 'content' );

        $scope.contentBlock = {};

        /**
         * Calls the server and creates the page.
         */
        $('#create').click(function() {
            $scope.contentBlock.content= editor.getData();
            ContentBlocks.create($scope.contentBlock,
                function(data) {
                    utilities.showSuccess("Content Block has been created!");

                    $window.location.href= '/admin/content-blocks';
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
        });

    }]);