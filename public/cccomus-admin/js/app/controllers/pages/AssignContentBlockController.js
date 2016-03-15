cccomus.controller('AssignContentBlockController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Pages',
    'ContentBlocks',
    'NgTableParams',
    function ($scope, $window, $resource, $location, utilities, Pages, ContentBlocks, NgTableParams) {

        var self = this;

        utilities.showInfo("Loading... Please Wait!");

        /**
         * Get the page ID
         */
        var page_id = utilities.getIdFromUrl();

        $scope.assignedContentBlocks = Pages.assignedContentBlocks(null, {id : page_id}, function(data) {
            return data.content_blocks;
        });

        /**
         * Upload all non-staged and non-deleted files.
         */
        self.assignedContentBlocksTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'name': "asc"},
            id: page_id
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {
                // ajax request to api
                return Pages.assignedContentBlocks(params.url(), params).$promise.then(function (data) {
                    var lastPage = Math.ceil(data.totalRecords/params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.content_blocks;
                });
            }
        });

        $scope.contentBlocks = ContentBlocks.contentBlockList(null, null, function(data) {
            return data;
        });

        $scope.selectContent = function() {

            Pages.assignContentBlock(null, {id : page_id, content_block_id : $scope.content_block_id}, function(data) {

                if(data) {
                    self.assignedContentBlocksTableParams.reload();
                    utilities.showSuccess('Content Block Added.');
                }
                else {
                    utilities.showError("Error Adding Content Block.")
                }
            });
        };


        $scope.unassignContentBlock = function(content_block_id) {
            Pages.unassignContentBlock(null, {id: page_id, content_block_id: content_block_id}, function(data) {
                if(data.message) {
                    self.assignedContentBlocksTableParams.reload();
                    utilities.showSuccess('Content Block Removed.');
                }
                else {
                    utilities.showError('Error Removing Content Block.');
                }
            });
        }
    }]);