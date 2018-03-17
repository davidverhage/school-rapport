<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('ajax_error_msg')) {
    //$msg - error message;
    function ajax_error_msg($msg)
    {
        return '<div class="ui-widget" style="margin:0 0 2px 0;font-size:12px">' .
            '<div class="ui-state-error ui-corner-all" style="padding:5px 9px">' .
            '<span class="ui-icon ui-icon-alert" style="float:left;margin-right:.3em"></span>' .
            '<strong>Fout:</strong> ' . $msg .
            '</div>' .
            '</div>';
    }
}
if (!function_exists('ajax_success_msg')) {
    //$msg - error message;
    function ajax_success_msg($msg)
    {
        return '<script type="text/javascript">$("input:password,input:text,textarea").val("");</script>' .
            '<div class="ui-widget" style="margin:0 0 2px 0;font-size:12px">' .
            '<div class="ui-state-highlight ui-corner-all" style="padding:5px 9px">' .
            '<span class="ui-icon ui-icon-info" style="float:left;margin-right:.3em"></span>' .
            '<strong>Voltooid:</strong> ' . $msg .
            '</div>' .
            '</div>';
    }
}

/* End of file error_helper.php */
/* Location: ./system/application/helpers/error_helper.php */