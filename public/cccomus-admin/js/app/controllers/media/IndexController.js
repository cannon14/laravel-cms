cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Media',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, Media, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');


        $scope.filters = {
            media: {
                media_id: '',
                name: '',
                filename: ''
            },
            media_types: {
                name: ''
            }
        };

        /**
         * Media Table
         */
        self.allMediaTableParams = new NgTableParams({
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
                return Media.all(params.url(), params).$promise.then(function (data) {
                    var lastPage = Math.ceil(data.totalRecords / params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.issuers;
                });
            }
        });

    }]);