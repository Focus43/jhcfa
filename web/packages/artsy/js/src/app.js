/* global FastClick */
;(function( window, angular, undefined ){ 'use strict';

    angular.module('artsy', ['artsy.common', 'ngSanitize']).

    /**
    * @description App configuration
    * @param $provide
    * @param $locationProvider
    */
    config(['$provide', '$locationProvider',
        function( $provide, $locationProvider ){

            // @todo: fix interfering links

        }
    ]).

    /**
    * On run...
    */
    run(['FastClick', function( FastClick ){
        FastClick.attach(document.body);
    }]);


    /************************************************************
    Bootstrap angular manually vs. binding w/ ng-app in the DOM
    ************************************************************/
    angular.element(document).ready(function(){
        angular.bootstrap(document.body, ['artsy']);
    });

})(window, window.angular);