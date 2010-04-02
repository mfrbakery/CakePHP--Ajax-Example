<div id="signup-form">
    <?php
    echo $form->create('Contact', array(
        'name' => 'contactForm',
        'id' => 'contactForm',
        'url' => '/contacts/ajax_test',
        'method' => 'post'
    ));
    ?>

    <?php
    echo $form->input('Contact.first_name', array(
        'label' => 'First Name',

        'before' => '<div class="form-field-wrapper">',
        'after' => '</div>'
    ));
    ?>

    <?php
    echo $form->input('Contact.last_name', array(
        'label' => 'Last Name',

        'before' => '<div class="form-field-wrapper">',
        'after' => '</div>'
    ));
    ?>

    <?php
    echo $form->input('Contact.email', array(
        'label' => 'Email',

        'before' => '<div class="form-field-wrapper">',
        'after' => '<span id="ContactEmailMsg"></span></div>'
    ));
    ?>

    <?php
    echo $form->input('Contact.confirm_email', array(
       'label'  => 'Confirm Email',

        'before' => '<div class="form-field-wrapper">',
        'after' => '</div>'
    ));
    ?>

    <?php
    echo $form->input('Contact.password', array(
        'label' => 'Password',
        'type' => 'password',

        'before' => '<div class="form-field-wrapper">',
        'after' => '</div>'
    ));
    ?>

    <?php
    echo $form->input('Contact.confirm_password', array(
        'label' => 'Confirm Password',
        'type' => 'password',

        'before' => '<div class="form-field-wrapper">',
        'after' => '</div>'
    ));
    ?>

    <?php
    echo $form->submit();
    ?>

    <?php
    echo $form->end();
    ?>
</div>

<div id="result-div"></div>