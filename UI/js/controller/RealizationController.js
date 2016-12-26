app.controller('RealizationController', ['$rootScope', '$scope', 'apiClient', function ($rootScope, $scope, apiClient) {
        $rootScope.siteTitle = 'MadeByRogal - Realizations';
        apiClient.getGalleries()
                .then(function (response) {
                    $scope.realization.galleries = response.data.gallery.items;
                })
                .catch(function (response) {
                    console.error(response);
                });
    }]);