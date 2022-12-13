<?php
function setup_popup_err_handler() {
    function my_handler(Throwable $throwable) {
        echo "<p class='php-err'>ERROR: " . nl2br($throwable);
        die('CRAP!');
    }
    set_exception_handler('my_handler');
}
?>
