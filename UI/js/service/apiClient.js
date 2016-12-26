app.service('apiClient', ['$http', function ($http) {
        return {
            /**
             * Get galleries
             * @returns array items
             */
            getGalleries: function () {
                return $http.get('http://madebyrogal.dev/apiMockStore.json');
            }
        }
    }]);


