cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Users',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, Users, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');

        $scope.active = 'all';

        $scope.filters = {
            users: {
                user_id: '',
                first_name: '',
                last_name: ''
            },
            acl: {
               role: ''
            }
        };

        /**
         * Upload users to table
         */
        self.allUsersTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'last_name': "asc"},
            filter: $scope.filters,
            active: $scope.active
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {

                // ajax request to api
                return Users.all(params.url(), params).$promise.then(function (data) {
                    var lastPage = Math.ceil(data.totalRecords/params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.users;
                });
            }
        });

        /**
         * Filter by all, active or inactive
         */
        $scope.filterActive = function() {

            self.allUsersTableParams.reload();
        };

        /**
         * Delete a User
         * @param id
         */
        $scope.delete = function (id) {

            if (confirm("Are you sure you wish to delete this user?")) {
                Users.delete(null, {id: id}, function (data) {
                    if (data.message) {
                        utilities.showSuccess('User has been deleted');
                        self.allCategoriesTableParams.reload();
                    }
                    else {
                        utilities.showError('Error occurred during user deletion');
                    }
                })
            }
        };

        /**
         * Edit a User.
         * @param id
         */
        $scope.edit = function (id) {
            $window.location.href = '/admin/users/'+id+'/edit';
        };

    }]);