/**
 * Created by cannon14 on 11/30/15.
 */

cccomus.factory('Code', ['$resource', function ($resource) {
    return $resource(
        '/admin/code',
        { id: '@id' },
        {
            get: { method: "GET", url: "/admin/code/:id/ajax"},
            store: { method: "POST", url: "/admin/code"},
            edit: { method: "GET", url: "/admin/code/:id/edit"},
            update: { method: "PUT", url: "/admin/code/:id"}

        }
    );
}]);