<?php

/**
 * @package Book Registration
 */


class BookRegActivate
{
    static function activatePlugin()
    {
        // echo 'Triggered';
        BookReg::create_table_to_db(); //we want this method to be called whenever the plugin is activated
        flush_rewrite_rules();
    }
}