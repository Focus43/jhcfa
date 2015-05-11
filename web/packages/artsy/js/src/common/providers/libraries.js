/* global Modernizr */
/* global FastClick */
angular.module('artsy.common').

    /**
     * @description Modernizr provider
     * @param $window
     * @param $log
     * @returns Modernizr | false
     */
    provider('Modernizr', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['Modernizr'] || ($log.warn('Modernizr unavailable!'), false);
            }
        ];
    }).

    /**
     * @description TweenLite OR TweenMax provider
     * @param $window
     * @param $log
     * @returns TweenMax | TweenLite | false
     */
    provider('Tween', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['TweenMax'] || $window['TweenLite'] || ($log.warn('Tween library unavailable!'), false);
            }
        ];
    }).

    /**
     * @description Isotope provider
     * @param $window
     * @param $log
     * @returns Isotope | false
     */
    provider('Isotope', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['Isotope'] || ($log.warn('Isotope unavailable!'), false);
            }
        ];
    }).

    /**
     * @description imagesLoaded provider
     * @param $window
     * @param $log
     * @returns imagesLoaded | false
     */
    provider('imagesLoaded', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['imagesLoaded'] || ($log.warn('imagesLoaded unavailable!'), false);
            }
        ];
    }).

    /**
     * @description FastClick provider
     * @param $window
     * @param $log
     * @returns FastClick | false
     */
    provider('FastClick', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['FastClick'] || ($log.warn('FastClick unavailable!'), false);
            }
        ];
    }).

    ///**
    // * @description D3 provider
    // * @param $window
    // * @param $log
    // * @returns D3 | false
    // */
    //provider('d3', function(){
    //    this.$get = ['$window', '$log',
    //        function( $window, $log ){
    //            return $window['d3'] || ($log.warn('D3-JS unavailable!'), false);
    //        }
    //    ];
    //}).

    /**
     * @description svg.js provider
     * @param $window
     * @param $log
     * @returns D3 | false
     */
    provider('SVG', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['SVG'] || ($log.warn('SVG.js unavailable!'), false);
            }
        ];
    });