cccomus.controller('CreateController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Feeds',
    function ($scope, $window, $resource, utilities, Feeds) {

        utilities.showInfo("Loading... Please Wait!")

        /**
         * Feed Variables.
         */
        $scope.feed = {};

        /**
         * Calls the server and creates the feed.
         */
        $scope.create = function() {
            Feeds.create($scope.feed,
                function(data) {

                    if(data.message) {
                        utilities.showSuccess("Feed has been created!");

                        //$window.location.href= '/admin/feeds';
                    }
                    else {
                        utilities.showError("Error occurred during feed creation");
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