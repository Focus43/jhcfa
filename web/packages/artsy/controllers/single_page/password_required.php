<?php namespace Concrete\Package\Artsy\Controller\SinglePage {

    use Cookie;
    use \Concrete\Package\Artsy\Controller\ArtsyPageController;

    class PasswordRequired extends ArtsyPageController {

        protected $_includeThemeAssets = true;

        public function on_start(){
            parent::on_start();
            $this->set('resource', $_GET['return']);
        }

        public function proceed(){
            /** @var $resource \Concrete\Core\Page\Page */
            $resource = \Concrete\Core\Page\Page::getByPath($_POST['resource']);
            if( is_object($resource) ){
                $password = $resource->getAttribute('password_protected');
                if( $_POST['_password'] === $password ){
                    $token   = md5($password . '$p3pp3R');
                    $tracker = json_decode(base64_decode(Cookie::get('_protection')));
                    if( $tracker ){
                        $tracker->{$_POST['resource']} = $token;
                    }else{
                        $tracker = (object) array($_POST['resource'] => $token);
                    }
                    Cookie::set('_protection', base64_encode(json_encode($tracker)));
                    $this->redirect($_POST['resource']);
                    return;
                }

                // Otherwise, go back to the page and show error
                $this->redirect('/password_required?' . \http_build_query(array(
                    'return' => $_POST['resource']
                )));
            }
        }
    }
}