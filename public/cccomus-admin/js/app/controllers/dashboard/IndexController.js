/**
 * Created by cannon14 on 11/14/15.
 */
cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Feeds',
    'Dashboard',
    function ($scope, $window, $resource, utilities, Feeds, Dashboard) {

        utilities.showInfo('Loading... Please Wait');

        var cardFeedId = 1,
            categoryFeedId = 2;

        $scope.errors = [];

        $scope.pullCardData = function() {
            if(confirm('Confirm')) {
                $("<div class='overlay'><span class='loading'>Loading Cards...</span></div>").appendTo( document.body );
                Feeds.pullCards(null, {id: cardFeedId}, function (data) {

                    if (data.errors.length > 0) {
                        $scope.errors = data.errors;
                        utilities.showError('Cards updated with ' + data.errors.length + ' errors');
                    }
                    else {
                        utilities.showSuccess('Card Update Complete');
                    }
                    $(".overlay").remove();
                });
            }
        };

        $scope.pullIssuerData = function() {
            if(confirm('Confirm')) {
                $("<div class='overlay'><span class='loading'>Loading Cards...</span></div>").appendTo( document.body );
                Feeds.pullIssuers(null, {id: cardFeedId}, function (data) {
                    if (data.errors.length > 0) {
                        $scope.errors = data.errors;
                        utilities.showError('Issuers updated with ' + data.errors.length + ' errors');
                    }
                    else {
                        utilities.showSuccess('Issuers Update Complete');
                    }
                    $(".overlay").remove();
                });
            }
        };

        $scope.pullCategoryData = function() {
            if(confirm('Confirm')) {
                $("<div class='overlay'><span class='loading'>Loading Cards...</span></div>").appendTo( document.body );
                Feeds.pullCategories(null, {id:categoryFeedId}, function (data) {
                    if (data.errors.length > 0) {
                        $scope.errors = data.errors;
                        utilities.showError('Categories updated with ' + data.errors.length + ' errors');
                    }
                    else {
                        utilities.showSuccess('Category Update Complete');
                    }
                    $(".overlay").remove();
                });
            }
        };

        $scope.publishToStaging = function() {
            if(confirm('Confirm')) {
                $("<div class='overlay'><span class='loading'>Publishing to Staging...</span></div>").appendTo( document.body );
                Dashboard.publishToStaging(null, null, function (data) {
                    if (data.errors.length > 0) {
                        $scope.errors = data.errors;
                        utilities.showError('Published with ' + data.errors.length + ' errors');
                    }
                    else {
                        utilities.showSuccess('Publish Complete');
                    }
                    $(".overlay").remove();
                });
            }
        };

        $scope.publishToProduction = function() {
            if(confirm('Confirm')) {
                $("<div class='overlay'><span class='loading'>Publishing to Production...</span></div>").appendTo( document.body );
                Dashboard.publishToProduction(null, null, function (data) {
                    if (data.errors.length > 0) {
                        $scope.errors = data.errors;
                        utilities.showError('Published with ' + data.errors.length + ' errors');
                    }
                    else {
                        utilities.showSuccess('Publish Complete');
                    }
                    $(".overlay").remove();
                });
            }
        };

    }]);