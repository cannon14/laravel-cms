cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Pages',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, Pages, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');


        /**
         * NG Table Filters
         * @type {{pages: {page_id: string, title: string}, templates: {name: string}, categories: {name: string}}}
         */
        $scope.filters = {
            pages: {
                page_id: '',
                title: '',
                active: '1'
            },
            templates: {name: ''},
        };

        /**
         * Upload all Pages.
         */
        self.allPagesTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'title': "asc"},
            filter: $scope.filters,
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {
                // ajax request to api
                return Pages.all(params.url(), params).$promise.then(function (data) {
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

            Pages.updateStatus({id: page_id}, {active:status}, function(data) {
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
         * Go to the assign cards page.
         * @param id
         */
        $scope.assignCards = function(id) {
            $window.location.href= '/admin/pages/cards/'+id;
        };

        /**
         * Go to the assign content blocks page.
         * @param id
         */
        $scope.assignContent = function(id) {
            $window.location.href= '/admin/pages/content-blocks/'+id;
        };

        /**
         * Show a page
         * @param id
         */
        $scope.show = function(id) {
            $window.location.href = '/staging/'+id;
        };

        /**
         * Delete a page.
         * @param id
         */
        $scope.delete = function (id) {

            if (confirm("Are you sure you wish to delete this page?")) {
                Pages.delete(null, {id: id}, function (data) {
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
         * Create a page.
         */
        $scope.create = function() {
            $window.location.href = '/admin/pages/create';
        };

        /**
         * Edit a page.
         * @param id
         */
        $scope.edit = function (id) {
            $window.location.href = '/admin/pages/edit/'+id;
        };

    }]);