cccomus.controller('AssignCardsController', [
    '$scope',
    '$window',
    '$resource',
    '$location',
    'utilities',
    'Pages',
    'Cards',
    'NgTableParams',
    function ($scope, $window, $resource, $location, utilities, Pages, Cards, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');

        /**
         * Get the node ID
         */
        var node_id = utilities.getIdFromUrl();

        /**
         * Upload all cards.
         */
        self.assignedCardsTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'name': "asc"},
            id: node_id
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {
                // ajax request to api
                return Pages.assigned(params.url(), params).$promise.then(function (data) {

                    var lastPage = Math.ceil(data.totalRecords/params.count());

                    params.total(data.totalRecords);

                    if (params.page() === lastPage + 1) {
                        params.page(lastPage);
                    }

                    return data.cards;
                });
            }
        });

        /**
         * Get a list of all cards
         * @type {*|{method, url}}
         */
        $scope.cards = Cards.cardList(null, null, function(data) {
            return data.cards;
        });

        /**
         * Fire when card is selected from drop-down
         */
        $scope.selectCard = function() {
            Pages.assign(null, {id : node_id, card_id : $scope.card_id}, function(data) {

                if(data) {
                    utilities.showSuccess('Card Added.');
                    self.assignedCardsTableParams.reload();
                }
                else {
                    utilities.showError("Error Adding Card.")
                }
            });
        };

        /**
         * Makes the card table sortable.
         */
        $('#sortable').sortable({
            update: function(event, ui) {
                var cards = $('#sortable').sortable('toArray');

                Pages.order(null, {id: node_id, cards: cards}, function(data) {
                    if(data.message) {
                        utilities.showSuccess('Card Order Updated.')
                        self.assignedCardsTableParams.reload();
                    }
                });
            }
        });

        $scope.unAssignCard = function(card_id) {
            Pages.unassign(null, {id: node_id, card_id: card_id}, function(data) {
                if(data.message) {
                    utilities.showSuccess('Card Removed');
                    self.assignedCardsTableParams.reload();
                }
            });
        }
    }]);