cccomus.controller('EditController', [
    '$scope',
    '$window',
    '$resource',
    'utilities',
    'Cards',
    function ($scope, $window, $resource, utilities, Cards) {

        utilities.showInfo('Loading... Please Wait')

        /**
         * Get the card ID
         */
        var card_id = utilities.getIdFromUrl();

        /**
         * Transform TextArea into CKEditor.
         */
        var bullets = CKEDITOR.replace( 'bullets'),
            review = CKEDITOR.replace( 'review');

        /**
         * Card variables
         * @type {{}}
         */
        $scope.card = {};

        /**
         * Get card data for edit.
         */
        Cards.get(null, {'id': card_id}, function(data) {
            $scope.card = data;
            bullets.setData(data.bullets);
            review.setData(data.review);
        });

        $scope.update = function() {
            $scope.card.bullets = bullets.getData();
            $scope.card.review = review.getData();

            Cards.update({id: card_id}, $scope.card, function(data) {

                if(data.message) {
                    utilities.showSuccess('Card has been updated');
                    $window.location.href= '/admin/cards';
                }
                else {
                    utilities.showError('Error occured during card update');
                }
            });
        }

    }]);