
cccomus.factory('Users', ['$resource', function ($resource) {
    return $resource(
        '/admin/users',
        { id: '@id' },
        {
            get:    { method:  'GET', url: '/admin/users/:id' },
            all:    { method:  'GET', url: '/admin/users/ajax'},
            delete: { method: 'DELETE', url: '/admin/users/:id' },
            store:  { method: "POST", url: '/admin/users'},
            edit: { method: 'GET', url: '/admin/users/edit/:id/user'},
            update: { method: "PUT", url: '/admin/users/:id'}
        }
    );
}]);