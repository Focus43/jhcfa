/* global FastClick */
;(function( window, angular, undefined ){ 'use strict';

    angular.module('artsy', [
            'artsy.common',
            'artsy.elements'
        ]).

        /**
         * @description App configuration
         * @param $provide
         * @param $locationProvider
         */
        config(['$provide', '$locationProvider',
            function( $provide ){



            }
        ]).

        run(['FastClick', function( FastClick ){
            FastClick.attach(document.body);
        }]);

    // Initialize manually instead of binding via HTML
    angular.element(document).ready(function(){
        angular.bootstrap(document, ['artsy']);
    });

})(window, window.angular);