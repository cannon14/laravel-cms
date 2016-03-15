
cccomus.factory('Dashboard', ['$resource', function ($resource) {
    return $resource(
        '/admin/',
        { id: '@id' },
        {
            publishToStaging: { method: 'GET', url: '/admin/dashboard/publish/staging'},
            publishToProduction: { method: 'GET', url: '/admin/dashboard/publish/production'}
        }
    );
}]);