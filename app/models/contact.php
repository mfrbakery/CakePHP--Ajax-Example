<?php

/**
 *
 * @author Zubin Khavarian <zubin.khavarian@gmail.com>
 */

class Contact extends AppModel {
    var $name = 'Contact';

    var $validate = array(
	    'first_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter a first name'
	    ),

	    'last_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter a last name'
	    ),

        'email' => array(
            'emailRule-1' => array(
                'rule' => 'notEmpty',
                'message' => 'email address cannot be empty'
            ),

            'emailRule-2' => array(
                'rule' => array('email', false),
                'message' => 'not a valid email address'
            )
        ),



    );
}

?>