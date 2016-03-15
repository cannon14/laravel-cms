
cccomus.factory('Feeds', ['$resource', function ($resource) {
    return $resource(
        '/admin/feeds',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/feeds/:id'},
            getFeed: { method: 'GET', url: '/admin/feeds/:id/feed'},
            all:    { method:  'GET', url: '/admin/feeds/ajax'},
            delete: { method: 'DELETE', url: '/admin/feeds/:id' },
            create: { method: "POST", url: "/admin/feeds/create"},
            edit:   { method: "GET", url: "/admin/feeds/:id/edit"},
            update: { method: "PUT", url: "/admin/feeds/:id"},
            pullCards:   { method: "GET", url: "/admin/feeds/pull/:id/cards"},
            pullIssuers: { method: "GET", url: "/admin/feeds/pull/:id/issuers"},
            pullCategories: { method: "GET", url: "/admin/feeds/pull/:id/categories"}
        }
    );
}]);