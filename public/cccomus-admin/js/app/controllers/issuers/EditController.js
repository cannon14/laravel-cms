cccomus.controller('EditController', [
    '$scope',
    '$window',
    '$resource',
    '$http',
    'utilities',
    'Issuers',
    function ($scope, $window, $resource, $http, utilities, Issuers) {

        utilities.showInfo('Loading... Please Wait');

        /**
         * Get the issuer id
         */
        var issuer_id = utilities.getIdFromUrl();

        $scope.issuer = {};

        Issuers.edit(null, {'id': issuer_id}, function(data) {
            $scope.issuer = data.issuer;
            $scope.images = data.images;

        });

        /**
         * Calls the server and updates the content block.
         */
        $scope.update = function() {

            Issuers.update({id : issuer_id}, $scope.issuer,
                function(data) {

                    if(data.message) {
                        utilities.showSuccess("Issuer has been updated!");

                        $window.location.href = '/admin/issuers';
                    }
                    else {
                        utilities.showError("Error occured updating issuer.")
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