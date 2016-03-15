cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Templates',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, Templates, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');


        $scope.filters = {
            templates: {
                template_id: '',
                name: '',
                type: '',
                description: '',
                version: ''
            }
        };

        /**
         * Upload templates to table
         */
        self.allTemplatesTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'name': "asc"},
            filter: $scope.filters
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {
                // ajax request
                return Templates.all(params.url(), params).$promise.then(function (data) {
                    var lastPage = Math.ceil(data.totalRecords/params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.templates;
                });
            }
        });


        /**
         * Edit template code.
         * @param id
         */
        $scope.edit = function(id) {
            $window.location = '/admin/code/'+id+'/edit';
        };

    }]);