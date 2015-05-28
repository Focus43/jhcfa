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
                return $window['TweenMax'] || $window['TweenLite'] || ($log.warn('Greensock Tween library unavailable!'), false);
            }
        ];
    }).

    /**
     * @description MomentJS
     * @param $window
     * @param $log
     * @returns moment | TweenLite | false
     */
    provider('moment', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['moment'] || ($log.warn('MomentJS library unavailable!'), false);
            }
        ];
    }).

    /**
     * @description Masonry provider
     * @param $window
     * @param $log
     * @returns Masonry | false
     */
    provider('Masonry', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['Masonry'] || ($log.warn('Masonry unavailable!'), false);
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

    /**
     * @description svg.js provider
     * @param $window
     * @param $log
     * @returns SVG | false
     */
    provider('SVG', function(){
        this.$get = ['$window', '$log',
            function( $window, $log ){
                return $window['SVG'] || ($log.warn('SVG.js unavailable!'), false);
            }
        ];
    }).

    /**
     * http://stackoverflow.com/questions/13478303/correct-way-to-use-modernizr-to-detect-ie
     */
    provider('BrowserDetect', function(){
        this.$get = [function(){

            var BrowserDetect = {
                init: function () {
                    this.browser = this.searchString(this.dataBrowser) || "Other";
                    this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
                },
                searchString: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        var dataString = data[i].string;
                        this.versionSearchString = data[i].subString;

                        if (dataString.indexOf(data[i].subString) !== -1) {
                            return data[i].identity;
                        }
                    }
                },
                searchVersion: function (dataString) {
                    var index = dataString.indexOf(this.versionSearchString);
                    if (index === -1) {
                        return;
                    }

                    var rv = dataString.indexOf("rv:");
                    if (this.versionSearchString === "Trident" && rv !== -1) {
                        return parseFloat(dataString.substring(rv + 3));
                    } else {
                        return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
                    }
                },

                dataBrowser: [
                    {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
                    {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
                    {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
                    {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
                    {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
                    {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
                ]

            };

            BrowserDetect.init();
            return BrowserDetect;
        }];
    });