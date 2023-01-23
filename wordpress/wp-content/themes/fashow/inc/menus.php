<?php

    /*
    *
    *	Wpbingo Framework Menu Functions
    *	------------------------------------------------
    *	Wpbingo Framework v3.0
    * 	Copyright Wpbingo Ideas 2017 - http://wpbingosite.com/
    *
    *	fashow_setup_menus()
    *
    */


    /* CUSTOM MENU SETUP
    ================================================== */
    register_nav_menus( array(
        'main_navigation' => esc_html__( 'Main Menu', 'fashow' ),
        'top_menu'          => esc_html__( 'Top Menu', 'fashow' )   
    ) );

?>
