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