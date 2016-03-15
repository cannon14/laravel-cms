cccomus.filter('status', function () {
    return function(input, trueValue, falseValue) {
        return input ? trueValue : falseValue;
    };
});

cccomus.filter('image', function () {
    return function(image) {
        return "<img src='http://www.imgsynergy.com/191x120/"+image+"' width='100%'>"
    };
});

cccomus.filter('toLowerCase', function() {
   return function(input) {
       if(input != undefined && input != '') {
           return input.replace(/\s+/g, '_').toLowerCase();
       }
   }
});

cccomus.filter('slug', function() {
   return function(input) {
       if(input != undefined && input != '') {
           return input.replace(/\s+/g, '-').toLowerCase();
       }
   }
});