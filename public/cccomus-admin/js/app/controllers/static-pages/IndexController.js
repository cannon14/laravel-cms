cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'StaticPages',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, StaticPages, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');


        /**
         * NG Table Filters
         * @type {{pages: {page_id: string, title: string}, templates: {name: string}, categories: {name: string}}}
         */
        $scope.filters = {
            static_pages: {
                page_id: '',
                title: '',
                active: '1'
            }
        };

        /**
         * Upload all Pages.
         */
        self.allPagesTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'title': "asc"},
            filter: $scope.filters
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {
                // ajax request to api
                return StaticPages.all(params.url(), params).$promise.then(function (data) {
                    var lastPage = Math.ceil(data.totalRecords/params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.pages;
                });
            }
        });

        /**
         * Set a page either active or inactive
         * @param page_id
         * @param status
         */
        $scope.changeStatus = function(page_id, status) {

            if(status == 1) {
                status = 0;
            }
            else {
                status = 1;
            }

            StaticPages.updateStatus({id: page_id}, {active:status}, function(data) {
                if (data.message) {
                    utilities.showSuccess('Page status has been updated');
                    self.allPagesTableParams.reload();
                }
                else {
                    utilities.showError('Error occurred updating page status')
                }
            });
        };


        /**
         * Delete a page.
         * @param id
         */
        $scope.delete = function (id) {

            if (confirm("Are you sure you wish to delete this page?")) {
                StaticPages.delete(null, {id: id}, function (data) {
                    if (data.message) {
                        utilities.showSuccess('Page has been deleted')
                        self.allPagesTableParams.reload();
                    }
                    else {
                        utilites.showError('Error occurred deleting page');
                    }
                })
            }
        };

        /**
         * Edit a page.
         * @param id
         */
        $scope.edit = function (id) {
            $window.location.href = '/admin/static/pages/'+id+'/edit';
        };

    }]);