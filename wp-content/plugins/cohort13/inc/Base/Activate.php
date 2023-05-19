<?php

/**
 * @package Cohort13Pugin
 */

namespace Inc;
 class Activate{
    static function activate(){
        RegisterBooks::registerBook();
        flush_rewrite_rules();
    }
 }