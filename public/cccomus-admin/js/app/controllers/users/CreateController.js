cccomus.controller('CreateController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Users',
    function ($scope, $window, $resource, utilities, Users) {

        utilities.showInfo("Loading... Please Wait!")

        /**
         * Users Variables.
         */
        $scope.user = {};
        $scope.user.active = 1;

        /**
         * Calls the server and creates the page.
         */
        $scope.create = function() {
            Users.store($scope.user,
                function(data) {

                    if(data.message) {
                        utilities.showSuccess("User has been created!");

                        //$window.location.href= '/admin/users';
                    }
                    else {
                        utilities.showError("Error occurred during user creation");
                    }
                },
                function(data) {
                    angular.forEach(data.data, function(value, key) {
                        utilities.showError(value);
                    });
                });
        };

    }]);