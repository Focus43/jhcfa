<?php namespace Concrete\Package\Artsy\Theme\Artsy {

    class PageTheme extends \Concrete\Core\Page\Theme\Theme {

        protected $pThemeGridFrameworkHandle = 'bootstrap3';

        protected static $contentBlockClasses = array(
            'block-theme-green'
//            'iconified',
//            'anglified',
//            'custom-icon-1',
//            'custom-icon-2',
//            'custom-icon-3',
//            'custom-icon-4',
//            'custom-icon-5',
//            'custom-icon-6',
//            'custom-icon-7',
//            'custom-icon-8',
//            'custom-icon-9'
        );

        protected static $sectionClasses = array(
            'wrap-custom',
            'wrap-theme-highlight',
            'wrap-theme-light',
            'wrap-theme-dark'
        );

        public function getThemeEditorClasses(){
            return array(
                array('title' => t('Theme Highlight Color'), 'menuClass' => '', 'spanClass' => 'theme-highlight-color'),
                array('title' => t('Theme Light Color'), 'menuClass' => '', 'spanClass' => 'theme-light-color'),
                array('title' => t('Theme Dark Color'), 'menuClass' => '', 'spanClass' => 'theme-dark-color'),
                array('title' => t('Theme Text Huge'), 'menuClass' => '', 'spanClass' => 'theme-text-huge')
            );
        }

        /**
         * @return array|void
         */
        public function getThemeAreaClasses(){
            return array(
                'Main 1' => self::$sectionClasses,
                'Main 2' => self::$sectionClasses,
                'Main 3' => self::$sectionClasses,
                'Main 4' => self::$sectionClasses,
                'Main 5' => self::$sectionClasses,
                'Main 6' => self::$sectionClasses,
                'Main 7' => self::$sectionClasses,
                'Main 8' => self::$sectionClasses,
                'Main 9' => self::$sectionClasses,
                'Main 10' => self::$sectionClasses
            );
        }


        public function getThemeBlockClasses(){
            return array(
                'content'   => self::$contentBlockClasses
            );
        }


        public function getThemeDefaultBlockTemplates(){
            return array(
                'html' => 'naked.php'
            );
        }

    }

}