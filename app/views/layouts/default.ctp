<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $title_for_layout; ?></title>

        <?php echo $this->Html->charset(); ?>

        <?php
        echo $this->Html->css('mycake.default');
        ?>
        
        <?php 
        //echo $this->Html->script('jquery-1.4.2');
        echo $this->Html->script('jquery-1.4.2.min');

        echo $this->Html->script('app.js');
        ?>
        <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> -->

    </head>

    <body>
        <?php echo $content_for_layout; ?>
    </body>
</html>