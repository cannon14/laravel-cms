cccomus.controller('ParserController', [
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
            parsers: {
                parser_id: ''
            }
        };

        /**
         * Parsers Table
         */
        self.allParsersTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'parser_id': "asc"},
            filter: $scope.filters
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {
                // ajax request to pi
                return Reviews.parsers(params.url(), params).$promise.then(function (data) {
                    var lastPage = Math.ceil(data.totalRecords / params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.parsers;
                });
            }
        });

        $scope.editParser = function (parser_id) {
            $window.location.href = '/admin/reviews/parsers/' + parser_id + '/edit';
        };

        $scope.deleteParser = function (parser_id) {
            if (confirm("Are you sure you wish to delete this parser?")) {
                Reviews.deleteParser({id: parser_id}, function (data) {
                    if (data.message) {
                        self.allParsersTableParams.reload();
                    }
                    else {
                        utilities.showErrMsg("Error occurred deleting map.");
                    }
                })
            }
        };

        //Initially display 2 fields.
        $scope.parser = {};
        $scope.parser.issuer_id = '';
        $scope.parser.data = [{parser_field: '', database_field: ''}, {parser_field: '', database_field: ''}];

        /**
         * Add a field
         */
        $scope.addField = function () {
            $scope.parser.data.push({parser_field: '', database_field: ''});
        };

        /**
         * Remove a field
         */
        $scope.removeField = function () {
            var lastItem = $scope.parser.data.length - 1;
            $scope.parser.data.splice(lastItem);
        };

        $scope.createParser = function () {

            Reviews.storeParser(null, $scope.parser, function (data) {
                    if (data.message) {
                        utilities.showSuccess("Parser has been created!");
                        $window.location.href = '/admin/reviews/parsers';
                    }
                    else {
                        utilities.showError("Error occurred during parser creation");
                    }
                },
                function (data) {
                    if (data.status == 422) {
                        angular.forEach(data.data, function (value, key) {
                            utilities.showError(value);
                        });
                    }
                    else {
                        utilities.showError(data.status + " Error Occurred");
                    }
                });
        };

        $scope.$watch(function () {
            return $scope.parser;
        });

        $scope.toLowerCase = function(field) {
            return field.replace(/\s+/g, '_').toLowerCase();
        }

    }]);