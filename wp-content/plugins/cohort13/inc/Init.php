<?php

/**
 * @package Cohort13Plugin
 */

 namespace Inc;

 use Inc\Pages\RegisterMember;

 class Init{
        /**
        * Store all the classes inside an array
        * @return array Full list of classes
        */
        public static function get_services(){
            return [
                Pages\AdminPage::class,
                Pages\AdminPageWithCallbacks::class,
                Base\Enqueue::class,
                Base\SettingsLinks::class,
                Pages\RegisterBook::class,
                Pages\RegisterMember::class,
                Pages\ShortCode::class
            ];
        }
    
        /**
        * Loop through the classes, initialize them,
        * and call the register() method if it exists
        * @return
        */
        public static function register_services(){
            foreach(self::get_services() as $class){
                $service = self::instantiate($class);
                if(method_exists($service, 'register')){
                    $service->register();
                }
            }
        }
    
        /**
        * Initialize the class from the services array and instance new instance of the class
        */
        private static function instantiate($class){
            $service = new $class();
            return $service;
        }
 }

?>