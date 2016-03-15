cccomus.controller('EditMapController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Reviews',
    function ($scope, $window, $resource, utilities, Reviews) {


        utilities.showInfo('Loading... Please Wait');

        /**
         * Get the map ID
         */
        var map_id = utilities.getIdFromUrl();

        $scope.map = {};

        /**
         * Get the map
         */
        Reviews.editMap({id:map_id}, function(data) {
           $scope.map = data; 
        });

        /**
         * Calls the server and creates the map.
         */
        $scope.updateMap = function() {
            Reviews.updateMap({id:map_id}, $scope.map,
                function(data) {

                    if(data.message) {
                        utilities.showSuccess("Mapping has been updated!");

                        $window.location.href= '/admin/reviews/maps';
                    }
                    else {
                        utilities.showError("Error occurred during map update");
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