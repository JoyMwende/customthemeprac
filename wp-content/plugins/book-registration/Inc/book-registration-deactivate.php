<?php

/**
 * @package Book Registration
 */


class BookRegDeactivate
{
    static function deactivatePlugin()
    {
        // echo 'Triggered';
        flush_rewrite_rules();
    }
}
