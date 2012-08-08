<?php

namespace content\code_view;

include_once 'php/global_settings.php';

function make_code_html_compatible( $raw_file )
{
    return preg_replace( array( "/&/", "/</", "/>/" ), array( "&amp", "&lt", "&gt" ), $raw_file );
}

?>
