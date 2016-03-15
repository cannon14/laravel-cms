
cccomus.factory('Pages', ['$resource', function ($resource) {
    return $resource(
        '/admin/pages',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/pages/:id'},
            all:    { method:  'GET', url: '/admin/pages/ajax'},
            delete: { method: 'DELETE', url: '/admin/pages/:id' },
            create: { method: "GET", url: "/admin/pages/create"},
            store: { method: "POST", url: "/admin/pages/store"},
            edit: { method: "GET", url: "/admin/pages/edit/page/:id"},
            update: { method: "PUT", url: "/admin/pages/update/:id"},
            show: { method: "GET", url: "/admin/pages/show/:id"},
            assigned: { method: "GET", url: "/admin/pages/assigned-cards/:id"},
            assign: { method: "PUT", url: "/admin/pages/assign-cards/:id"},
            unassign: { method: "PUT", url: "/admin/pages/unassign-card/:id"},
            order: { method: "PUT", url: "/admin/pages/assigned-cards/order/:id"},
            assignedContentBlocks: {method: "GET", url:"/admin/pages/assigned-content-blocks/:id"},
            assignContentBlock: {method: "PUT", url: "/admin/pages/assign-content-block/:id"},
            unassignContentBlock: { method: "PUT", url: "/admin/pages/unassign-content-block/:id"},
            updateStatus: { method: "PUT", url: '/admin/pages/:id/page/status'}
        }
    );
}]);