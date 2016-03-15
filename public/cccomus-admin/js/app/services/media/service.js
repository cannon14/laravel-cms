
cccomus.factory('Media', ['$resource', function ($resource) {
    return $resource(
        '/admin/media',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/media/:id'},
            all:    { method:  'GET', url: '/admin/media/all' },
            delete: { method: 'DELETE', url: '/admin/media/:id' },
            create: { method: "GET", url: "/admin/media/create"},
            store: { method: "POST", url: "/admin/media"},
            update: { method: "PUT", url: "/admin/media/:id"}
        }
    );
}]);