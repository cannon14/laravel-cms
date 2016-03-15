
cccomus.factory('StaticPages', ['$resource', function ($resource) {
    return $resource(
        '/admin/static/pages',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/static/pages/:id/page'},
            all:    { method:  'GET', url: '/admin/static/pages/all'},
            delete: { method: 'DELETE', url: '/admin/static/pages/:id' },
            create: { method: "GET", url: "/admin/static/pages/create"},
            store: { method: "POST", url: "/admin/static/pages"},
            update: { method: "PUT", url: "/admin/static/pages/:id"},
            updateStatus: { method: "PUT", url: '/admin/static/pages/:id/page/status'}
        }
    );
}]);