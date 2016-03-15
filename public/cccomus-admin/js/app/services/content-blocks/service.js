
cccomus.factory('ContentBlocks', ['$resource', function ($resource) {
    return $resource(
        '/admin/content-blocks',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/content-blocks/:id' },
            all:    { method:  'GET', url: '/admin/content-blocks/ajax'},
            delete: { method: 'DELETE', url: '/admin/content-blocks/:id' },
            create: { method: "POST", url: "/admin/content-blocks/store"},
            edit: { method: "GET", url: "/admin/content-blocks/edit/ajax/:id"},
            update: { method: "PUT", url: "/admin/content-blocks/update/:id"},
            contentBlockList: { method: "GET", url: "/admin/content-blocks/list"}
        }
    );
}]);