cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'ContentBlocks',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, ContentBlocks, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');

        $scope.filters = {
            content_blocks: {
                content_block_id: '',
                name: '',
                description: ''
            }
        };

        /**
         * Upload content blocks to table
         */
        self.allContentBlocksTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'name': "asc"},
            filter: $scope.filters
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {
                // ajax request to api
                return ContentBlocks.all(params.url(), params).$promise.then(function (data) {
                    var lastPage = Math.ceil(data.totalRecords/params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.content_blocks;
                });
            }
        });

        /**
         * Delete a content block.
         * @param id
         */
        $scope.deleteContentBlock = function (id) {

            if (confirm("Are you sure you wish to delete this content block?")) {
                ContentBlocks.delete(null, {id: id}, function (data) {
                    if (data.message) {
                        utilities.showSuccess("Content Block Deleted");
                        self.allContentBlocksTableParams.reload();
                    }
                    else {
                        utilities.showError("Error Occurred while Deleting Content Block");
                    }
                })
            }
        };

        /**
         * Edit a content block.
         * @param id
         */
        $scope.editContentBlock = function (id) {
            $window.location.href = '/admin/content-blocks/'+id;
        };

    }]);