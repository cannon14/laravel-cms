
cccomus.factory('Issuers', ['$resource', function ($resource) {
    return $resource(
        '/admin/issuers',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/issuers/:id'},
            all:    { method:  'GET', url: '/admin/issuers/ajax' },
            delete: { method: 'DELETE', url: '/admin/issuers/:id' },
            create: { method: "GET", url: "/admin/issuers/create"},
            store: { method: "POST", url: "/admin/issuers", headers: {'Content-Type': 'multipart/form-data'}},
            edit: { method: "GET", url: "/admin/issuers/edit/issuer/:id"},
            update: { method: "PUT", url: "/admin/issuers/:id"},
            updateStatus: { method: "PUT", url: '/admin/issuers/:id/issuer/status'}
        }
    );
}]);