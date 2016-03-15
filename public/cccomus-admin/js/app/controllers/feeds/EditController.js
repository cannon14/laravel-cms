cccomus.controller('EditController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Feeds',
    function ($scope, $window, $resource, $location, utilities, Feeds) {

        utilities.showInfo("Loading... Please Wait!");

        /**
         * Get the feed ID
         */
        var feed_id = utilities.getIdFromUrl();

        /**
         * Feed Variables.
         */
        $scope.feed = {};

        Feeds.getFeed(null, {'id': feed_id}, function(data) {

            $scope.feed.name = data.name;
            $scope.feed.url = data.url;
            $scope.feed.key = data.key;
        });

        /**
         * Calls the server and update the page.
         */
        $scope.update = function() {

            Feeds.update({id:feed_id}, $scope.feed,
                function(data) {
                    if(data.message) {
                        utilities.showSuccess("Feed has been updated!");

                        $window.location.href= '/admin/feeds';
                    }
                    else {
                        utilities.showError("Error occurred during feed update")
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