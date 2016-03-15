cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Issuers',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, Issuers, NgTableParams) {

    var self = this;

        utilities.showInfo('Loading... Please Wait');

        $scope.filters = {
            issuers: {
                issuer_id: '',
                name: '',
                active: '1'
            }
        };

        /**
         *
          * @type {NgTableParams}
         */
    self.allIssuersTableParams = new NgTableParams({
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
            return Issuers.all(params.url(), params).$promise.then(function (data) {
                var lastPage = Math.ceil(data.totalRecords/params.count());

                params.total(data.totalRecords);

                if (params.page() === lastPage + 1) {
                    params.page(lastPage);
                }

                return data.issuers;
            });
        }
    });

    /**
     * Delete a issuer.
     * @param id
     */
    $scope.deleteIssuer = function (id) {

        if (confirm("Are you sure you wish to delete this issuer?")) {
            Issuers.delete(null, {id: id}, function (data) {
                if (data.message) {
                    self.allIssuersTableParams.reload();
                }
                else {
                    utilities.showErrMsg("Error occurred deleting issuer.");
                }
            })
        }
    };

        /**
         * Edit a issuer.
         * @param id
         */
        $scope.editIssuer = function (id) {
            $window.location.href = '/admin/issuers/'+id+'/edit';
        };

        /**
         * Set a issuer either active or inactive
         * @param status
         */
        $scope.changeStatus = function(issuer_id, status) {

            if(status == 1) {
                status = 0;
            }
            else {
                status = 1;
            }

            Issuers.updateStatus({id: issuer_id}, {active:status}, function(data) {
                if (data.message) {
                    utilities.showSuccess('Issuer status has been updated');
                    self.allIssuersTableParams.reload();
                }
                else {
                    utilities.showError('Error occurred updating issuer status')
                }
            });
        };

}]);