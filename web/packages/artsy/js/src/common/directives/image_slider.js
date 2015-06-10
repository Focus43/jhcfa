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