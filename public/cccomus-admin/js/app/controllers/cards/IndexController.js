cccomus.controller('IndexController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Cards',
    'NgTableParams',
    function ($scope, $window, $resource, utilities, Cards, NgTableParams) {

        var self = this;

        utilities.showInfo('Loading... Please Wait');

        $scope.filters = {
            cards: {
                card_id: '',
                name: '',
                issuer_name: '',
                active:'1'
            }
        };

        /**
         * Upload cards to table
         */
        self.allCardsTableParams = new NgTableParams({
            page: 1,
            count: 25,
            sorting: {'name': "asc"},
            filter: $scope.filters
        }, {
            counts: [25, 50, 100],
            paginationMaxBlocks: 13,
            paginationMinBlocks: 2,
            getData: function (params) {
                // ajax request to api
                return Cards.all(params.url(), params).$promise.then(function (data) {
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
         * Set a card either active or inactive
         * @param status
         */
        $scope.changeStatus = function(card_id, status) {

            if(status == 1) {
                status = 0;
            }
            else {
                status = 1;
            }

            Cards.updateStatus({id: card_id}, {active:status}, function(data) {
               if (data.message) {
                   utilities.showSuccess('Card status has been updated');
                   self.allCardsTableParams.reload();
               }
                else {
                   utilities.showError('Error occurred updating card status')
               }
            });
        };

        /**
         * Delete a Card.
         * @param id
         */
        $scope.delete = function (id) {

            if (confirm("Are you sure you wish to delete this card?")) {
                Cards.delete(null, {id: id}, function (data) {
                    if (data.message) {
                        utilities.showSuccess('Card has been deleted');
                        self.allCardsTableParams.reload();
                    }
                    else {
                        utilities.showError('Error occurred during card deletion.');
                    }
                })
            }
        };

        /**
         * Edit a Card.
         * @param id
         */
        $scope.edit = function (id) {
            $window.location.href = '/admin/cards/'+id+'/edit';
        };

    }]);