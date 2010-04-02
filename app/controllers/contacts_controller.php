<?php
/**
 * An example class to work out a well-structured CakePHP and custom Ajax integration
 * Note that we are using the same controller for both Ajax and non-Ajax (post-back) services. Both are controller
 * actions but behave differently in the format of data they return and we differentiate this by calling the
 * "$this->__ajaxify()" method at the top of Ajax actions
 *
 * @author Zubin Khavarian <zubin.khavarian@gmail.com>
 */

App::import('Sanitize');

class ContactsController extends AppController {
    var $name = "Contacts";
    var $uses = array('Contact');
    
    var $components = array('RequestHandler');
    var $helpers = array('Javascript'); //Adding this for use in the view to convert php object to json

    function beforeFilter() {
        $this->pageTitle = 'Contacts Controller';
        
        //$this->layout = null;
    }


    /**
     * This method should be called at the top of any action which is used as an ajax service, it ensures that the
     * proper response type is set and that no debug and layout data is sent as part of the view which would prevent
     * the JSON data from being intrepreted correctly on the browser side.
     */
    function __ajaxify() {
        $this->RequestHandler->setContent('json');
        $this->RequestHandler->respondAs('json');
        Configure::write('debug', 0);
        $this->layout = null;
    }

    /**
     * ACTION - default index action
     */
    function index() {
        
    }

    /**
     * ACTION (Ajax) - An example ajax action. Notice the "$this->__ajaxify()" call at the top of the method. This is
     * important to set proper headers and send data as raw JSON.
     */
    function ajax_signup_service() {
        $this->__ajaxify();

        //This is what would be converted into a JSON string to be sent to the browser, we attach all data and messages
        //to this object and pass it to the view where it will be converted to a JSON string.
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