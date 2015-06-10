/* global FastClick, FB */
;(function( window, angular, undefined ){ 'use strict';

    angular.module('artsy', ['artsy.common', 'ngSanitize']).

    /**
    * @description App configuration
    * @param $provide
    * @param $locationProvider
    */
    config(['$provide',
        function( $provide ){

            /**
             * Normally we'd bind a directive to pickup the data attribute fb-sdk
             * and load the Facebook SDK within, but Facebook's javascript removes
             * /replaces the DOM node which makes angular's parsing of the directive
             * go schizo; so (since we're always loading this at the end of a page),
             * we just look for any DOM nodes with attr [fb-sdk], and then load it
             * here.
             */
            if( document.querySelectorAll('[fb-sdk]').length ){
                window.fbAsyncInit = function() {
                    FB.init({
                        appId      : '884434574982022',
                        xfbml      : true,
                        version    : 'v2.3'
                    });
                    console.log('✓ FacebookSDK');
                };

                (function(d, s, id){
                    var fbDiv = d.createElement('div'); fbDiv.id = 'fb-root'; d.body.appendChild(fbDiv);
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {return;}
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            }

        }
    ]).

    /**
    * On run...
    */
    run(['$rootScope', '$window', '$timeout', '$q', 'FastClick', 'BrowserDetect', '$compile',
        function( $rootScope, $window, $timeout, $q, FastClick, BrowserDetect, $compile ){
            // Bind fastclick
            FastClick.attach(document.body);

            // Set the browser as an attribute on the html tag
            document.documentElement.setAttribute('data-ua', BrowserDetect.browser);

            // This sucks... but we cant do it any other way for now
            var themeWraps = document.querySelectorAll('[class*="wrap-theme-"]');
            if( themeWraps.length ){
                for(var i = 0, len = themeWraps.length; i < len; i++){
                    var $element = angular.element(themeWraps[i]);
                    while( ! $element.hasClass('container') && $element.length ){
                        console.log('locating_parent_container');
                        $element = angular.element($element.parent());
                    }
                    if( $element.length ){
                        $element.addClass('overflowable-x');
                    }
                }
            }

            // C5 edit mode ONLY
            if( angular.element(document.documentElement).hasClass('cms-edit-mode') ){
                // Wait for ConcreteEvent to be available in the window...
                $q(function(resolve, reject){
                    (function _wait(){
                        $timeout(function(){
                            if( $window['ConcreteEvent'] ){
                                resolve($window['ConcreteEvent']);
                                return;
                            }
                            _wait();
                        }, 200);
                    })();
                }).then(function( ConcreteEvent ){
                    /**
                     * @todo: Find a better way to evaluate lazy-loaded directives after a
                     * block gets updated vs recompiling the entire document... That seems
                     * dangerous...
                     */
                    ConcreteEvent.subscribe('EditModeAddBlockComplete EditModeUpdateBlockComplete EditModeExitInlineSaved EditModeExitInline', function(){
                        $timeout(function(){
                            console.log("Recompiling DOM");
                            $compile(document.body)($rootScope);
                        }, 2000);
                    });
                });
            }
        }
    ]);


    /************************************************************
    Bootstrap angular manually vs. binding w/ ng-app in the DOM
    ************************************************************/
    angular.element(document).ready(function(){
        angular.bootstrap(document.body, ['artsy']);
    });

})(window, window.angular);

angular.module('artsy.common', []);
angular.module('artsy.common').

    controller('CtrlCalendarPage', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            $scope.eventData = [];

            $scope.uiState = {
                fetchInProgress: false,
                showSearchExtras: false,
                showTagList: false,
                initialFetchComplete: false
            };

            $scope.overrideDateRange = {
                start: moment().startOf('month'),//.format('YYYY-MM-DD'),
                end: moment().add(5, 'months').endOf('month')//.format('YYYY-MM-DD')
            };

            $scope.isTextSearch = false;

            $scope.filters = {
                fields:     ['calendarID'],
                keywords:   null,
                calendars:  "",
                tags:       "",
                categories: 1, //@todo:we just know this is going to be ID 1 right? easy to break...
                filepath:   true,
                start:      moment().startOf('month').format('YYYY-MM-DD'),
                end:        moment().endOf('month').format('YYYY-MM-DD'),//moment().add(6, 'months').format('YYYY-MM-DD'),
                attributes: 'presenting_organization,date_display,ticket_link,event_not_ticketed'
            };

            $scope.fetch = function(){
                $scope.uiState.fetchInProgress = true;

                var data = ($scope.isTextSearch === false) ? $scope.filters : angular.extend({}, $scope.filters, {
                    start: $scope.overrideDateRange.start.format('YYYY-MM-DD'),
                    end: $scope.overrideDateRange.end.format('YYYY-MM-DD')
                });
                console.log($scope.filters);

                Schedulizer.fetch(data).success(function( resp ){
                    $scope.eventData = resp;
                    $scope.uiState.fetchInProgress = false;
                    $scope.uiState.initialFetchComplete = true;
                }).error(function(){
                    console.log('err');
                });
            };

            $scope.setCategory = function( int ){
                $scope.filters.categories = int;
            };

            // On page load, since $watch automatically applies itself once filters object becomes available,
            // this will initialize the first load
            $scope.$watch('filters', function( filters ){
                $scope.isTextSearch = angular.isString(filters.keywords) && filters.keywords.length;
                if( filters ){
                    $scope.fetch();
                }
            }, true);

            // Generate next 6 months list
            var currentMonth    = moment();
            currentMonth._selected = true;
            $scope.monthsToView = [currentMonth];
            for(var i = 1; i <= 5; i++){
                var next = currentMonth.clone().add(i, 'month');
                next._selected = false;
                $scope.monthsToView.push(next);
            }

            $scope.selectedMonthIndex = 0;
            $scope.selectMonth = function( $index ){
                for(var i = 0, l = $scope.monthsToView.length; i < l; i++){
                    $scope.monthsToView[i]._selected = false;
                }
                $scope.monthsToView[$index]._selected   = true;
                $scope.selectedMonthIndex               = $index;
                $scope.filters.start                    = $scope.monthsToView[$index].clone().startOf('month').format('YYYY-MM-DD');
                $scope.filters.end                      = $scope.monthsToView[$index].clone().endOf('month').format('YYYY-MM-DD');
            };

            $scope.funcKeyup = function( $event ){
                $scope.uiState.showSearchExtras = ($event.target.value.length !== 0);
                $scope.uiState.fetchInProgress = true;
            };

            $scope.clearSearch = function(){
                $scope.uiState.showSearchExtras = false;
                $scope.filters.keywords = null;
            };

            $scope.selectedTags = [];
            $scope.toggleTag = function( tagID ){
                // Exists; so splice it off
                if( $scope.selectedTags.indexOf(tagID) !== -1 ){
                    $scope.selectedTags.splice($scope.selectedTags.indexOf(tagID), 1);
                    $scope.filters.tags = $scope.selectedTags.join(',');
                    return;
                }
                // Doesn't exist, append it
                $scope.selectedTags.push(tagID);
                $scope.filters.tags = $scope.selectedTags.join(',');
            };

            $scope.nextMonth = function(){
                var nextIndex = $scope.selectedMonthIndex + 1;
                if( $scope.monthsToView[nextIndex] ){
                    $scope.selectMonth(nextIndex);
                }
            };

            $scope.prevMonth = function(){
                var prevIndex = $scope.selectedMonthIndex - 1;
                if( $scope.monthsToView[prevIndex] ){
                    $scope.selectMonth(prevIndex);
                }
            };

        }
    ]);

angular.module('artsy.common').

    controller('CtrlFeaturedEvents', ['$scope', 'Schedulizer', 'moment',
        function( $scope, Schedulizer, moment ){

            $scope.eventData = [];

            /**
             * Need to use a watch to make sure ng-init completes and
             * only send request once we have a valid value for featuredTagID
             */
            $scope.$watch('featuredTagID', function( featuredTagID ){
                if( featuredTagID ){
                    Schedulizer.fetch({
                        fields: ['tags'],
                        filepath:true,
                        limit:10,
                        end:moment().add(6, 'months').format("YYYY-MM-DD"),
                        attributes: 'date_display',
                        tags: featuredTagID // passed via ng-init
                    }).success(function( resp ){
                        $scope.eventData = resp;
                    });
                }
            });

        }
    ]);
angular.module('artsy.common').

    service('Schedulizer', ['$http', function( $http ){

        var eventRoute      = '/_schedulizer/event_list',
            defaultParams   = {
                fields:     ['computedStartLocal', 'computedStartUTC', 'title'],
                pagepath:   true,
                grouping:   true
            };

        /**
         * Joins the alwaysFields with custom fields and ensures no duplication.
         * @param _fields
         * @returns {*}
         * @private
         */
        function mergeFields( a, b ){
            var joined = a.concat(b);
            return joined.filter(function( item, pos ){
                return joined.indexOf(item) === pos;
            });
        }

        /**
         * @param fields array
         * @param filters object
         * @param cache bool
         */
        this.fetch = function( _filters, _cache ){
            // Have to extend an empty object so we don't rewrite the original
            // _filters.fields property to a string!
            var filtersCopy = angular.extend({}, _filters, {
                fields: mergeFields(_filters.fields || [], defaultParams.fields)
            });
            return $http.get(eventRoute, {
                cache:  (_cache === false) ? false : true,
                params: angular.extend({}, defaultParams, filtersCopy)
            });
        };

    }]);
angular.module('artsy.common').

    directive('accordion', [
        function(){

            function _link( scope, $elem, attrs ){
                var $groups = angular.element($elem[0].querySelectorAll('.group'));
                $groups.on('click', function(){
                    angular.element(this).toggleClass('active');
                });
            }

            return {
                restrict: 'A',
                link:     _link
            };
        }
    ]);
angular.module('artsy.common').

    /**
     * Event rendering directive. This should be used inside a parent Controller or something
     * that can control the scope and pass event list data.
     * @usage: <div event-list="listData" />, whereas the parent controller can
     * set the listData on the scope.
     */
    directive('eventList', ['moment', function( moment ){

        function _link( scope, $elem, attrs, Controller, transcludeFn ){

            var transcludedNodes    = [],
                transcludedScopes   = [];

            scope.$watch('_data', function( list ){
                if( list ){
                    // @todo: do a check in here to see if we're appending but keeping the existing
                    // results, or replacing the existing ones, and cleanup old nodes/scopes if
                    // need be (https://docs.angularjs.org/api/ng/service/$compile see section on cleanup)
                    var _node; while(_node = transcludedNodes.pop()){
                        _node.remove();
                    }

                    var _scope; while(_scope = transcludedScopes.pop()){
                        _scope.$destroy();
                    }

                    list.forEach(function( eventObj ){
                        var $newScope = scope.$new();
                        $newScope.eventObj = eventObj;
                        $newScope.moment   = moment(eventObj.computedStartLocal);
                        transcludeFn($newScope, function( $cloned, $scope ){
                            $elem.append($cloned);
                            transcludedNodes.push($cloned);
                            transcludedScopes.push($scope);
                        });
                    });
                }
            }, true);

        }

        return {
            link:       _link,
            transclude: true,
            scope:      {_data: '=eventList'},
            controller: [function(){}]
        };
    }]);

angular.module("artsy.common").

    directive('imageSlider', ['Tween', 'imagesLoaded',
        function( Tween, imagesLoaded ){

            function _link(scope, $elem, attrs){
                var element     = $elem[0],
                    containerW  = element.clientWidth,
                    elPrev      = element.querySelector('[prev]'),
                    elNext      = element.querySelector('[next]'),
                    itemList    = element.querySelectorAll('.item'),
                    itemsLength = itemList.length,
                    idxActive   = 0,
                    skipLoop    = false;

                function next( _callback ){
                    var idxNext     = itemList[idxActive + 1] ? idxActive + 1 : 0,
                        elCurrent   = itemList[idxActive],
                        elNext      = itemList[idxNext];

                    skipLoop  = true;
                    idxActive = idxNext;
                    angular.element(elCurrent).removeClass('active');
                    angular.element(elNext).addClass('active');
                    if( angular.isFunction(_callback) ){ _callback(); }
                }

                function prev( _callback ){
                    var idxPrev     = itemList[idxActive - 1] ? idxActive - 1 : itemsLength - 1,
                        elCurrent   = itemList[idxActive],
                        elPrev      = itemList[idxPrev];

                    skipLoop  = true;
                    idxActive = idxPrev;
                    angular.element(elCurrent).removeClass('active');
                    angular.element(elPrev).addClass('active');
                    if( angular.isFunction(_callback) ){ _callback(); }
                }

                angular.element(elPrev).on('click', prev);

                angular.element(elNext).on('click', next);

                (function _loop(){
                    setTimeout(function(){
                        if( skipLoop ){ skipLoop = false; _loop(); return; }
                        next(_loop);
                    }, 4000);
                })();
            }

            return {
                restrict:   'A',
                scope:      true,
                link:       _link
            };
        }
    ]);
/* global Elastic */
angular.module('artsy.common').

    directive('introAnim', ['$rootScope', 'Tween', function( $rootScope, Tween ){

        function _link( scope, $elem, attrs ){

            //$rootScope.$broadcast('watchSpokes', true);
            //
            //Tween.fromTo($elem[0].querySelector('.tagline'), 1.8,
            //    {x:-800,scaleX:0,scaleY:0},
            //    {x:0,scaleX:1,scaleY:1, ease:Elastic.easeInOut, onComplete:function(){
            //        $rootScope.$broadcast('watchSpokes', false);
            //    }, delay:0.5}
            //);

        }

        return {
            link: _link,
            scope: false
        };
    }]);
angular.module("artsy.common").

    directive('masonry', ['Masonry', 'imagesLoaded',
        function( Masonry, imagesLoaded ){

            function _link(scope, $elem, attrs){
                var element = $elem[0];

                scope.masonry = new Masonry(element, {
                    //columnWidth:  '.grid-sizer',
                    itemSelector: '[node]',
                    percentPosition: true
                });
            }

            return {
                restrict:   'A',
                scope:      true,
                link:       _link
            };
        }
    ]);
angular.module('artsy.common').

    directive('moreEventTimes', [
        function(){

            function _link( scope, $elem, attrs ){
                $elem.on('click', function(){
                    angular.element($elem[0].parentNode.querySelectorAll('.more-hidden')).removeClass('more-hidden');
                    $elem.remove();
                });
            }

            return {
                restrict: 'A',
                link:     _link
            };
        }
    ]);
/* global Power1 */
angular.module('artsy.common').

    directive('nav', ['Tween', function( Tween ){

        function _link( scope, $elem, attrs ){

            var $html     = angular.element(document.documentElement),
                $majority = angular.element($elem[0].querySelector('.majority')),
                $currentLiSub;

            scope.status = {
                open: false
            };

            scope.toggle = function(){
                scope.status.open = !scope.status.open;

            };

            scope.$watch('status.open', function( _status ){
                angular.element(document.documentElement).toggleClass('nav-open', _status);
            });

            //angular.element($elem[0].querySelectorAll('.sub-trigger')).on('click', function(){
            //    $currentLiSub = angular.element(this.parentNode.parentNode);
            //    $currentLiSub.toggleClass('sub-active');
            //    $majority.toggleClass('show-subs');
            //});
            angular.element($elem[0].querySelectorAll('.sub-trigger')).on('click', function(){
                $currentLiSub = angular.element(this.parentNode);
                $currentLiSub.toggleClass('sub-active');
                $majority.toggleClass('show-subs');
            });

            angular.element($elem[0].querySelectorAll('.unsub')).on('click', function(){
                $currentLiSub.toggleClass('sub-active');
                $majority.toggleClass('show-subs');
            });

            var lastScroll = 0,
                threshold  = 50,
                isDocked   = false;
            Tween.ticker.addEventListener('tick', function(){
                if( lastScroll !== window.pageYOffset ){
                    lastScroll = window.pageYOffset;
                    if( (lastScroll > threshold) !== isDocked ){
                        isDocked = !isDocked;
                        $html.toggleClass('dock-nav-icon', isDocked);
                    }
                }
            });
        }

        return {
            restrict: 'E',
            link:     _link
        };
    }]);
/* global Power2 */
angular.module('artsy.common').

    directive('scrollTo', ['$window', '$rootScope', 'Tween',
        function( $window, $rootScope, Tween ){

            function _link( scope, $elem, attrs ){

                //$rootScope.$broadcast('watchSpokes', true);

                var target = document.querySelector(attrs.scrollTo);
                if( target ){
                    $elem.on('click', function( _ev ){
                        _ev.preventDefault();
                        Tween.to($window, 0.65, {
                            scrollTo: {y:target.offsetTop},
                            ease: Power2.easeOut
                        });
                        // If any siblings exist, remove active
                        angular.element($elem[0].parentNode.children).removeClass('active');
                        $elem.addClass('active');
                    });
                }

            }

            return {
                link: _link,
                scope: false
            };
        }
    ]);
angular.module('artsy.common').

    directive('searchable', ['$http', '$compile', '$templateCache',
        function( $http, $compile, $templateCache ){

            function _link( $scope, $elem, attrs ){
                var $html = angular.element(document.documentElement);

                // Compile HTML within this directive
                $compile($elem.contents())($scope);

                // Compile the results template
                var $tpl  = angular.element($templateCache.get('/search-form-tpl')),
                    $cpld = $compile($tpl),
                    $lnkd = $cpld($scope);
                angular.element(document.body).append($lnkd);

                // If status is open, set on the HTML/document element
                $scope.$watch('status.open', function( isOpen, lastIsOpen ){
                    if( isOpen !== lastIsOpen ){
                        $html.toggleClass('search-results-open', isOpen);
                    }
                });
            }

            return {
                scope: {
                    searchPath: '@searchable'
                },
                restrict: 'A',
                link: _link,
                controller: ['$scope', function( $scope ){
                    $scope.pageHits = [];

                    $scope.status = {
                        open:  false,
                        value: '',
                        displayValue: '',
                        loading: true
                    };

                    $scope.$watch('status.displayValue', function( searchValue ){
                        $scope.status.open = (searchValue && searchValue.length >= 1);
                    });

                    $scope.clear = function(){
                        $scope.status.value = '';
                        $scope.status.displayValue = '';
                    };

                    $scope.funcKeyup = function($event){
                        $scope.status.displayValue = $event.target.value;
                        $scope.status.loading = true;
                    };

                    $scope.$watch('status.value', function( searchValue ){
                        if( searchValue && $scope.searchForm.$valid ){
                            $http.get($scope.searchPath, {
                                cache: false,
                                params: {_s: $scope.status.value}
                            }).success(function( resp ){
                                $scope.pageHits = resp.pages;
                                $scope.status.loading = false;
                            });
                        }
                    });
                }]
            };
        }
    ]);
/* global Power2 */
angular.module('artsy.common').

    directive('shareOn', ['$window', '$compile', '$sce', 'Tween',
        function( $window, $compile, $sce, Tween ){

            //var tpl = '<div share-on-window><div class="tabular"><div class="cellular"><iframe ng-src="{{ shareOnURL }}"></iframe></div></div></div>';

            function _link( scope, $elem, attrs ){

                //scope.shareOnURL = $sce.trustAsResourceUrl(attrs.href);
                //
                $elem.on('click', function( event ){
                    event.preventDefault();
                    $window.open(attrs.href, 'Share On Facebook', 'width='+(attrs.width || 450)+',height='+(attrs.height || 300));
                    //var $tpl  = angular.element(tpl),
                    //    $cpld = $compile($tpl),
                    //    $lnkd = $cpld(scope);
                    //angular.element(document.body).append($lnkd);
                });
            }

            return {
                link: _link,
                scope: false
            };
        }
    ]);
angular.module('artsy.common').

    directive('spokeTo', ['$window', '$rootScope', 'SVG', 'Tween', function( $window, $rootScope, SVG, Tween ){

        var body                    = document.body,
            html                    = document.documentElement,
            docWidth                = document.body.getBoundingClientRect().width,
            docHeight               = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight),
            svgCanvas               = SVG(document.body),
            redraw                  = false,
            overrideRedraw          = false,
            linkedNodes             = [],
            defaultSpokeOffset      = 5,
            defaultSpokeWidth       = 2,
            defaultSpokeDistance    = 10,
            defaultSpokeAnimTime    = 700,
            defaultSpokeAnimDelay   = 0,
            defaultSpokeAnimEase    = '>'; // http://documentup.com/wout/svg.js#animating-elements/easing

        // Create the SVG canvas ONCe
        svgCanvas.size(docWidth,docHeight).attr('class', 'spoke-canvas');

        /**
         * Whenever an update occurs, adjust the line settings...
         * @param nodePair
         */
        function render( nodeData ){
            // Calculate the midpoints and angles b/w nodes as radians
            var rectA           = nodeData.nodes[0].getBoundingClientRect(),
                rectB           = nodeData.nodes[1].getBoundingClientRect(),
                radiusA         = rectA.width / 2,
                radiusB         = rectB.width / 2,
                xMidA           = rectA.left + radiusA,
                yMidA           = rectA.top + radiusA,
                xMidB           = rectB.left + radiusB,
                yMidB           = rectB.top + radiusB,
                thetaA          = Math.atan2((yMidB - yMidA),(xMidB - xMidA)),
                thetaB          = Math.atan2((yMidA - yMidB),(xMidA - xMidB)),
                spokeOffset    = +(nodeData.attrs.spokeOffset) || defaultSpokeOffset,
                calcdRadiusA    = radiusA + spokeOffset,
                calcdRadiusB    = radiusB + spokeOffset,
                existingLine    = nodeData.spoke;

            // Calculate the points moved to the outside of the circle
            var ax = xMidA + calcdRadiusA * Math.cos(thetaA),
                ay = yMidA + calcdRadiusA * Math.sin(thetaA),
                bx = xMidB + calcdRadiusB * Math.cos(thetaB),
                by = yMidB + calcdRadiusB * Math.sin(thetaB);

            // If line has already been rendered, just needs updating
            if( existingLine ){
                existingLine.plot(ax,ay,bx,by);
                return;
            }

            // If we get here, its rendering for the first time, so all we do is
            // generate the line and store the reference to it with the nodeData
            nodeData.spoke = svgCanvas.line(ax,ay,ax,ay).stroke({
                width: +(nodeData.attrs.spokeWidth) || defaultSpokeWidth,
                linecap: 'round',
                dasharray: '0.1,' + (nodeData.attrs.spokeDistance || defaultSpokeDistance),
                color:'#ffffff'
            });

            nodeData.spoke.
                animate(
                    // animation time
                    +(nodeData.attrs.spokeAnimationTime) || defaultSpokeAnimTime,
                    // easing function (string, so don't cast)
                    nodeData.attrs.spokeAnimationEase || defaultSpokeAnimEase,
                    // delay
                    +(nodeData.attrs.spokeAnimationDelay) || defaultSpokeAnimDelay
                ).
                during(function( t, morph ){
                    this.attr({y2: morph(ay,by), x2: morph(ax,bx)});
                });
                //.after(function(){ redraw = true; });
        }

        /**
         * Animation frame binding, but only gets run whenever an onscroll
         * or window resize event happens.
         */
        Tween.ticker.addEventListener('tick', function(){
            if( redraw || overrideRedraw ){
                for(var i = 0, len = linkedNodes.length; i < len; i++){
                    render.call(this, linkedNodes[i]);
                }
                console.log('_drawing_spokes_:)');
                redraw = false;
            }
        });

        /**
         * Scroll event.
         */
        angular.element($window).bind('scroll', function(){
            redraw = true;
        });

        /**
         * Window was resized.
         */
        angular.element($window).bind('resize', function(){
            docWidth    = document.body.getBoundingClientRect().width;
            docHeight   = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
            svgCanvas.size(docWidth,docHeight);
            redraw = true;
        });

        /**
         * Listen for overrides broadcast by other elements that might use animation
         * that would require updating the spokes.
         */
        $rootScope.$on('watchSpokes', function( event, override ){
            overrideRedraw = override;
        });

        /**
         * Link function just takes care of adding to the nodePairs we're tracking.
         * @example: <svg spoke-to=".another-svg" spoke-offset="20" spoke-width="10" spoke-distance="20"><circle></circle></svg>
         * @param scope
         * @param $elem
         * @param attrs
         * @private
         */
        function _link( scope, $elem, attrs ){
            linkedNodes.push({
                nodes: [
                    $elem[0].querySelector('circle'),
                    document.querySelector(attrs.spokeTo).querySelector('circle')
                ],
                attrs: attrs
            });

            redraw = true;
        }

        return {
            link: _link,
            scope: false
        };
    }]);
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