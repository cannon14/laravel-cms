cccomus.controller('EditController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'ContentBlocks',
    function ($scope, $window, $resource, $location, utilities, ContentBlocks) {

        utilities.showInfo("Loading... Please Wait!");

        /**
         * Transform TextArea into CKEditor.
         */
        var editor = CKEDITOR.replace( 'content', {
            allowedContent: true
        } );

        /**
         * content block object.
         */
        $scope.contentBlock= {};

        /**
         * Get the content block ID
         */
        var content_block_id = utilities.getIdFromUrl();


        ContentBlocks.edit(null, {'id': content_block_id}, function(data) {
            $scope.contentBlock.name = data.content_block.name;
            $scope.contentBlock.description = data.content_block.description;
            $scope.contentBlock.content = data.content_block.content;

        });

        /**
         * Calls the server and updates the content block.
         */
        $scope.update = function() {

            $scope.contentBlock.content = editor.getData();
            ContentBlocks.update({id : content_block_id}, $scope.contentBlock,
                function(data) {
                    utilities.showSuccess("Content block has been updated!");

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
        };

    }]);