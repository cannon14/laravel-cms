cccomus.controller('EditController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Users',
    function ($scope, $window, $resource, $location, utilities, Users) {

        utilities.showInfo("Loading... Please Wait!");

        /**
         * Get the user ID
         */
        var user_id = utilities.getIdFromUrl();

        /**
         * User Variables.
         */
        $scope.user = {};

        Users.edit(null, {'id': user_id}, function(data) {
            $scope.user = data;
        });

        /**
         * Calls the server and update the user.
         */
        $scope.update = function() {

            Users.update({id: $scope.user.user_id}, $scope.user,
                function(data) {
                    if(data.message) {
                        utilities.showSuccess("User has been updated.");

                        $window.location.href= '/admin/users';
                    }
                    else {
                        utilities.showError("Error occurred updating user.");
                    }
                },
                function(data) {
                    if(data.status == 422) {
                        angular.forEach(data.data, function (value, key) {
                            utilities.showError(value);
                        });
                    }
                    else {
                        utilities.showError(data.status + " Error Occurred");
                    }
                });
        };

    }]);