
cccomus.factory('Cards', ['$resource', function ($resource) {
    return $resource(
        '/admin/cards',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/cards/:id/card' },
            all:    { method:  'GET', url: '/admin/cards/ajax'},
            delete: { method: 'DELETE', url: '/admin/cards/:id' },
            store: { method: "POST", url: '/admin/cards'},
            edit: { method: 'GET', url: '/admin/cards/:id/edit'},
            update: { method: "PUT", url: '/admin/cards/:id'},
            cardList: { method: "GET", url: '/admin/cards/list'},
            updateStatus: { method: "PUT", url: '/admin/cards/:id/card/status'}
        }
    );
}]);