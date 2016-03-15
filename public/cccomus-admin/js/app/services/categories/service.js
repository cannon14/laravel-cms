
cccomus.factory('Categories', ['$resource', function ($resource) {
    return $resource(
        '/admin/categories',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/categories/:id/category' },
            all:    { method:  'GET', url: '/admin/categories/ajax' },
            delete: { method: 'DELETE', url: '/admin/categories/:id' },
            store: { method: "POST", url: '/admin/categories/' },
            update: { method: "PUT", url: '/admin/categories/:id'},
            updateStatus: { method: "PUT", url: '/admin/categories/:id/category/status'}

        }
    );
}]);