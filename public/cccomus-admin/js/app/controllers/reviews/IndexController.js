cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Reviews',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, Reviews, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');

        $scope.issuerFilters = {
            issuers: {
                issuer_id: '',
                name: ''
            }
        };

        $scope.productFilters = {
            cards: {
                card_id: '',
                name: ''
            }
        };

        $scope.mapFilters = {
            product_id_to_alt_product_id_map: {
                product_id: '',
                alt_product_id: ''
            }
        };

        /**
         * Issuer Reviews Table
         */
        function populateIssuers() {
            self.allIssuersTableParams = new NgTableParams({
                page: 1,
                count: 25,
                sorting: {'name': "asc"},
                filter: $scope.issuerFilters
            }, {
                counts: [25, 50, 100],
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                getData: function (params) {
                    // ajax request to api
                    return Reviews.issuers(params.url(), params).$promise.then(function (data) {
                        var lastPage = Math.ceil(data.totalRecords / params.count());

                        params.total(data.totalRecords);

                        if (params.page() === lastPage + 1) {
                            params.page(lastPage);
                        }

                        return data.issuers;
                    });
                }
            });
        }

        /**
         * Product Reviews Table
         */
        function populateProducts() {
            self.allIssuersTableParams = new NgTableParams({
                page: 1,
                count: 25,
                sorting: {'name': "asc"},
                filter: $scope.productFilters
            }, {
                counts: [25, 50, 100],
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                getData: function (params) {
                    // ajax request to api
                    return Reviews.products(params.url(), params).$promise.then(function (data) {
                        var lastPage = Math.ceil(data.totalRecords / params.count());

                        params.total(data.totalRecords);

                        if (params.page() === lastPage + 1) {
                            params.page(lastPage);
                        }

                        return data.cards;
                    });
                }
            });
        }

        /**
         * Product Mappings Table
         */
        function populateMaps() {
            self.allMapsTableParams = new NgTableParams({
                page: 1,
                count: 25,
                sorting: {'product_id': "asc"},
                filter: $scope.mapFilters
            }, {
                counts: [25, 50, 100],
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                getData: function (params) {
                    // ajax request to api
                    return Reviews.maps(params.url(), params).$promise.then(function (data) {
                        var lastPage = Math.ceil(data.totalRecords / params.count());

                        params.total(data.totalRecords);

                        if (params.page() === lastPage + 1) {
                            params.page(lastPage);
                        }

                        return data.mappings;
                    });
                }
            });
        }

        //Get the last segment of the url
        var path = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);

        //Check which table needs to be populated.
        if(path == 'issuers') {
            populateIssuers();
        }
        else if (path == 'maps') {
            populateMaps();
        }
        else {
            populateProducts();
        }

        $scope.editMap = function(map_id) {
            $window.location.href= '/admin/reviews/maps/'+map_id+'/edit';
        };

        $scope.deleteMap = function(map_id) {
            if (confirm("Are you sure you wish to delete this map?")) {
                Reviews.deleteMap(null, {id: map_id}, function (data) {
                    if (data.message) {
                        self.allMapsTableParams.reload();
                        utilities.showSuccess("Map deleted.")
                    }
                    else {
                        utilities.showError("Error occurred deleting map.");
                    }
                })
            }
        };

    }]);