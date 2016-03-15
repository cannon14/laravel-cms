
cccomus.factory('Templates', ['$resource', function ($resource) {
    return $resource(
        '/admin/templates',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/templates/:id' },
            all:    { method:  'GET', url: '/admin/templates/ajax'},
            delete: { method: 'DELETE', url: '/admin/templates/:id' },
        }
    );
}]);