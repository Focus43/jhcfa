<?php namespace Concrete\Package\Schedulizer\Src {

    use Concrete\Package\Schedulizer\Src\Persistable\Contracts\Persistant;
    use Concrete\Package\Schedulizer\Src\Persistable\Mixins\Crud;

    /**
     * Class EventTag
     * @package Concrete\Package\Schedulizer\Src
     * @definition({"table":"SchedulizerEventTag"})
     */
    class EventTag extends Persistant {

        use Crud;

        /** @definition({"cast":"string","nullable":false}) */
        protected $displayText;

        /** @definition({"cast":"string","nullable":false}) */
        protected $handle;

        /**
         * @param null $string
         */
        public function __construct( $string = null ){
            if( $string !== null ){
                $this->displayText = $string;
            }
        }

        public function __toString(){
            return $this->displayText;
        }

        /****************************************************************
         * Fetch Methods
         ***************************************************************/

        public static function fetchAll(){
            return (array) self::fetchMultipleBy(function( \PDO $connection, $tableName ){
                $statement = $connection->prepare("SELECT * FROM {$tableName}");
                return $statement;
            });
        }
    }

}