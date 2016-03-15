cccomus.controller('CreateMapController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Reviews',
    function ($scope, $window, $resource, utilities, Reviews) {


        utilities.showInfo('Loading... Please Wait');

        $scope.map = {};

        /**
         * Calls the server and creates the map.
         */
        $scope.createMap = function() {
            Reviews.storeMap($scope.map,
                function(data) {

                    if(data.message) {
                        utilities.showSuccess("Mapping has been created!");

                        $window.location.href= '/admin/reviews/maps';
                    }
                    else {
                        utilities.showError("Error occurred during map creation");
                    }
                },
                function(data) {
                    if (data.status) {
                        utilities.showSuccess(data.message);
                    }
                    else {
                        utilities.showError(data.message);
                    }
                });
        };

    }]);