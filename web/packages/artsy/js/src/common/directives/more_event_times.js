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