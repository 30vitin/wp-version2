<?php

namespace Inc;

final class Init
{
    /**
     * Store all the classes inside an array
     * @return array full listo of class
     */
    public static function get_services() {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\Links::class,
            Base\BgFirma::class
        ];
    }

    /**
     * Loop through the classes, initialize them,
     * and call the register() method if it exists
     * 
     * @return void
     */
	public static function register_services()
    {
        foreach (self::get_services() as $class) {
            if (method_exists($class, 'register')) {
                $service = self::instantiate($class);
                if (method_exists($service, 'register')) {
                    $service->register();
                }
            }
        }
    }
    /**
     * Initialize class
     * Loop through the classes, initialize them,
     * and call the register() method if it exists
     * 
     * @param class $class class from the services array
     * @return class
     */
    private static function instantiate($class) {
        return new $class;
    }
}
