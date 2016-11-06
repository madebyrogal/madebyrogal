//Main module
var app = angular.module("madebyrogal", [
    'ngRoute'
]);

// routing
app.config(['$routeProvider', '$locationProvider',
  function($routeProvider, $locationProvider) {

    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });

    $routeProvider.
        when('/', {
            templateUrl: 'pages/home/index.html',
            controller: 'HomeController',
            controllerAs: 'home'
        }).
        when('/realizations', {
            templateUrl: 'pages/realization/index.html',
            controller: 'RealizationController',
            controllerAs: 'realization'
        }).
        when('/clients', {
            templateUrl: 'pages/client/index.html',
            controller: 'ClientController',
            controllerAs: 'client'
        }).
        when('/blog', {
            templateUrl: 'pages/blog/index.html',
            controller: 'BlogController',
            controllerAs: 'blog'
        }).
        when('/project-planner', {
            templateUrl: 'pages/project-planer/index.html',
            controller: 'ProjectPlannerController',
            controllerAs: 'project'
        }).
        when('/contact', {
            templateUrl: 'pages/contact/index.html',
            controller: 'ContactController',
            controllerAs: 'contact'
        }).
        otherwise({
            redirectTo: '/'
        });
  }]);

app.run(['$rootScope',
    function($rootScope) {
        $rootScope.footerDate = new Date();
        $rootScope.siteTitle = 'MadeByRogal'
    }
]);