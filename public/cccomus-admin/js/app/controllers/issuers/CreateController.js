cccomus.controller('CreateController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Issuers',
    '$q',
    '$http',
    'formDataObject',
    function ($scope, $window, $resource, $location, utilities,  Issuers, $q, $http, formDataObject) {

        utilities.showInfo("Loading... Please Wait!");


        /**
         * Issuer Variables.
         */
        $scope.issuer = {};

        /**
         * Calls the server and creates the issuer.
        */
        $scope.create = function() {

            Issuers.store($scope.issuer,
                function(data) {
                    if(data.message) {
                        utilities.showSuccess("Issuer has been created!");

                        //$window.location.href= '/admin/issuers';
                    }
                    else {
                        utilities.showError("Error occurred during issuer creation");
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