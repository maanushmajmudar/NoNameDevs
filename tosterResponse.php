<?php
class tostMsg
{
    public function errorMessagesGroup()
    {
        echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>';
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">';

        echo '<script>';
        echo 'toastr.options = { closeButton: true, progressBar: true, preventDuplicates: true, positionClass: "toast-top-right" };';
        echo 'var errorsArray = ' . json_encode($_SESSION['flash_messages']) . ';';
        echo 'for (var i in errorsArray) { toastr.error(errorsArray[i]); }';
        echo '</script>';

        unset($_SESSION['flash_messages']);
    }
    public function errorMessages($message)
    {
        echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>';
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">';

        echo '<script>';
        echo 'toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right" };';
        echo 'toastr.error("' . $message . '");';
        echo '</script>';
    }
    public function successMessage($message)
    {
        echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>';
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">';

        echo '<script>';
        echo 'toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right" };';
        echo 'toastr.success("' . $message . '");';
        echo '</script>';
    }
}
