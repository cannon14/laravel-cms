cccomus.service('utilities', ['$window', '$location', function ($window, $location) {

    PNotify.prototype.options.styling = "bootstrap3";
    var animation = 'fade',
        speed = 'slow',
        stack = {"dir1": "down", "dir2": "left", "push": "top", "spacing1": 10, "spacing2": 10};

    this.showNotice = function (msg) {
        new PNotify({
            title: 'Notice',
            text: msg,
            animation: animation,
            animate_speed: speed,
            stack: stack,
            nonblock: {
                nonblock: true,
                nonblock_opacity: .2
            }
        })
    };

    this.showInfo = function (msg) {
        new PNotify({
            title: 'Info',
            text: msg,
            type: 'info',
            animation: animation,
            animate_speed: 'fast',
            stack: stack,
            nonblock: {
                nonblock: true,
                nonblock_opacity: .2
            }
        });
    };

    this.showSuccess = function (msg) {
        new PNotify({
            title: 'Success',
            text: msg,
            type: 'success',
            animation: animation,
            animate_speed: speed,
            stack: stack,
            nonblock: {
                nonblock: true,
                nonblock_opacity: .2
            }
        });
    };

    this.showError = function (msg) {
        new PNotify({
            title: 'Error',
            text: msg,
            type: 'error',
            animation: animation,
            animate_speed: speed,
            stack: stack,
            nonblock: {
                nonblock: true,
                nonblock_opacity: .2
            }
        });
    };

    this.getParams = function() {
      return $location.search();
    };

    this.getIdFromUrl = function () {

        var id = 0,
            url = $location.absUrl(),
            regex = /(?:\/)(\d+)/g;

        id = parseInt(regex.exec(url)[1]);

        return id;
    };

    /**
     * Generate a slug based on a value.
     * @param value
     * @returns {string|*}
     */
    this.generateSlug = function (value) {
        var str = value.toString();
        slug = str.replace(/\s+/g, '-').toLowerCase();

        return slug;
    }
}]);