<?php

/**
 * @package Cohort13Pugin
 */

namespace Inc;
class Deactivate{
    static function deactivate(){
        flush_rewrite_rules();
    }
}
