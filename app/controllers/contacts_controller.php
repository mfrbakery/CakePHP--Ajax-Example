<?php
/**
 * 
 *
 * @author Zubin Khavarian <zubin.khavarian@gmail.com>
 */

App::import('Sanitize');

class ContactsController extends AppController {
    var $name = "Contacts";
    var $uses = array('Contact');
    
    var $components = array('RequestHandler');
    var $helpers = array('Javascript');

    function beforeFilter() {
        $this->pageTitle = 'Contacts Controller';
        
        //$this->layout = null;
    }

    function __ajaxify() {
        //Setup for proper handling of ajax requests and properly formatted JSON response
        $this->RequestHandler->setContent('json');
        $this->RequestHandler->respondAs('json');
        Configure::write('debug', 0);
        $this->layout = null;
    }

    function index() {
        
    }

    function ajax_signup_service() {
        $this->__ajaxify();

        $responseData = array();

        switch($this->params['named']['service']) {
            case 'login_unique':
                $contactEmail = Sanitize::clean($this->data['Contact']['email']);

                $count = $this->Contact->find('count', array(
                    'conditions' => array(
                        'Contact.email' => $contactEmail
                    )
                ));

                if($count === 0) {
                    $responseData['success'] = true;
                    $responseData['message'] = 'Available';
                }
                else {
                    $responseData['success'] = false;
                    $responseData['message'] = 'Already taken';
                }
            break;

            default:
                $responseData = $this->data;
            break;
            
        }

        $this->set('responseData', $responseData);
    }
}

?>