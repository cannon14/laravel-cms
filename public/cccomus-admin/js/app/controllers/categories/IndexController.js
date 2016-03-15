cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Categories',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, Categories, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');

        $scope.filters = {
            categories: {
                category_id: '',
                name: '',
                active: '1'
            }
        };

        /**
         * Upload categories to table
         */
        self.allCategoriesTableParams = new NgTableParams({
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
                return Categories.all(params.url(), params).$promise.then(function (data) {
                    var lastPage = Math.ceil(data.totalRecords/params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.categories;
                });
            }
        });

        /**
         * Delete a Category
         * @param id
         */
        $scope.deleteCategory = function (id) {

            if (confirm("Are you sure you wish to delete this category?")) {
                Categories.delete(null, {id: id}, function (data) {
                    if (data.message) {
                        utilities.showSuccess('Category has been deleted');
                        self.allCategoriesTableParams.reload();
                    }
                    else {
                        utilities.showError('Error occurred during category deletion');
                    }
                })
            }
        };

        /**
         * Edit a Category.
         * @param id
         */
        $scope.editCategory = function (id) {
            $window.location.href = '/admin/categories/'+id+'/edit';
        };

        /**
         * Set a category either active or inactive
         * @param status
         */
        $scope.changeStatus = function(category_id, status) {

            if(status == 1) {
                status = 0;
            }
            else {
                status = 1;
            }

            Categories.updateStatus({id: category_id}, {active:status}, function(data) {
                if (data.message) {
                    utilities.showSuccess('Category status has been updated');
                    self.allCategoriesTableParams.reload();
                }
                else {
                    utilities.showError('Error occurred updating category status')
                }
            });
        };

    }]);