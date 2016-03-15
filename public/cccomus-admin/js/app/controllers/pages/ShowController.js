cccomus.controller('ShowController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Pages',
    function ($scope, $window, $resource, $location, utilities, Pages) {

        utilities.showInfo("Loading... Please Wait!");


        /**
         * Page Variables.
         */
        $scope.page = {};

        var node_id = utilities.getIdFromUrl();

        Pages.get({'id': node_id}, function(data) {
            $scope.page = data.pg;
        });

    }]);