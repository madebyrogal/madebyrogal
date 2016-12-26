app.directive('galleries', function () {
    return {
        restrict: 'E',
        scope: {
            galleries: '='
        },
        templateUrl: 'directives/gallery.html',
    };
});