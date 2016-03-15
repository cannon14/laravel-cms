
cccomus.factory('Reviews', ['$resource', function ($resource) {
    return $resource(
        '/admin/reviews',
        { id: '@id' },
        {
            issuers: { method: 'GET', url: '/admin/reviews/issuers/all'},
            products: { method: 'GET', url: '/admin/reviews/products/all'},
            maps: { method: 'GET', url: '/admin/reviews/maps/all'},
            storeMap: { method: 'POST', url: '/admin/reviews/maps'},
            editMap: { method: 'GET', url: '/admin/reviews/maps/:id'},
            updateMap: { method: 'PUT', url: '/admin/reviews/maps/:id'},
            deleteMap: { method: 'DELETE', url: '/admin/reviews/maps/:id'},
            parsers: { method: 'GET', url: '/admin/reviews/parsers/all'},
            storeParser: { method: 'POST', url: '/admin/reviews/parsers'},
            updateParser: { method: 'PUT', url: '/admin/reviews/parsers/:id'},
            deleteParser: { method: 'DELETE', url: '/admin/reviews/parsers/:id'}
        }
    );
}]);