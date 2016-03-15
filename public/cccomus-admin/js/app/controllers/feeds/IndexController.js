cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Feeds',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, Feeds, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait')


        /**
         * Upload cards to table
         */
        self.allFeedsTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'feed_id': "asc"}
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {
                // ajax request to api
                return Feeds.all(params.url(), params).$promise.then(function (data) {
                    var lastPage = Math.ceil(data.totalRecords/params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.feeds;
                });
            }
        });

        $scope.pull = function(id, name) {
            switch(name) {
                case 'Linkoffers Cards':
                    pullCards(id);
                    break;
                case 'Linkoffers Categories':
                    pullCategories(id);
                    break;
                default:
                    utilities.showError("Unknown Feed. Contact Administrator.");
            }
        };

        /**
         * Pull cards from feed
         * @param id
         */
        function pullCards(id) {
            $("<div class='overlay'><span class='loading'>Loading Cards...</span></div>").appendTo( document.body );
            Feeds.pullCards(null, {id: id}, function (data) {
                if(data.message) {
                    utilities.showSuccess("Cards have been updated from feed.");
                }
                else {
                    utilities.showError("Error occurred while updating from feed.");
                }
                $(".overlay").remove();
            });
        };

        /**
         * Pull products from feed
         * @param id
         */
        function pullCategories(id) {
            $("<div class='overlay'><span class='loading'>Loading Categories...</span></div>").appendTo( document.body );
            Feeds.pullCategories(null, {id: id}, function (data) {
                if(data.message) {
                    utilities.showSuccess("Categories have been updated from feed.");
                }
                else {
                    utilities.showError("Error occurred while updating from feed.");
                }
                $(".overlay").remove();
            });
        };


        /**
         * Delete a Feed.
         * @param id
         */
        $scope.deleteFeed = function (id) {

            if (confirm("Are you sure you wish to delete this feed?")) {
                Feeds.delete(null, {id: id}, function (data) {
                    if (data.message) {
                        utilities.showSuccess("Feed has been deleted.");
                        self.allCardsTableParams.reload();
                    }
                    else {
                        utilities.showError("Error occurred while deleting feed.");
                    }
                })
            }
        };

        /**
         * Edit a Feed.
         * @param id
         */
        $scope.editFeed= function (id) {
            $window.location.href = '/admin/feeds/'+id+'/edit';
        };

    }]);