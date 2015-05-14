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