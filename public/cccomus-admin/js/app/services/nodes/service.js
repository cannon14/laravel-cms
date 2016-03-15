
cccomus.factory('Nodes', ['$resource', function ($resource) {
    return $resource(
        '/admin/nodes',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/nodes/:id' },
            all:    { method:  'GET', url: '/admin/nodes/ajax'},
            delete: { method: 'DELETE', url: '/admin/nodes/delete/:id' },
            create: { method: "POST", url: "/admin/nodes/create"},
            store: { method: "POST", url: "/admin/nodes/store"},
            edit:   { method: "GET", url: "/admin/nodes/edit/:id"},
            update: { method: "PUT", url: "/admin/nodes/:id"}
        }
    );
}]);