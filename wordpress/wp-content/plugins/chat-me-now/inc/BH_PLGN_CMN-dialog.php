<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (!function_exists('bhpcmn_write_log')) {

    function bhpcmn_write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
  
  }

class bhpcmn_dialog {

    private $admin=false;
    private $opt=null;
    private $enable=true;

    function __construct($id_admin=false){

        
        $this->admin=$id_admin;
        $this->chat_me_now_load_options('chat_me_now__option_name');
       
        if($this->enable){
            add_action( 'wp_enqueue_scripts', array($this,'add_chat_me_now_style' ));
            add_action('wp_footer', array($this,'chat_me_now_load_dialog_on_front')); 
        }
        
    }
    function chat_me_now_load_options(){
        $opt = get_option( 'chat_me_now__option_name' );
        $this->opt = [];
        $this->opt['whatsapp1'] = isset($opt['whatsapp1'])?$opt['whatsapp1']:'';
        $this->opt['whatsapp2'] = isset($opt['whatsapp2'])?$opt['whatsapp2']:'';
        $this->opt['whatsapp_active_turn'] = isset($opt['whatsapp_active_turn'])?$opt['whatsapp_active_turn']:'';
        $this->opt['schedule_turn'] = isset($opt['schedule_turn'])?$opt['schedule_turn']:'';
        $this->opt['icon_color'] = isset($opt['icon_color'])?$opt['icon_color']:'';        
        $this->opt['background_color'] = isset($opt['background_color'])?$opt['background_color']:''; 
        $this->opt['start_message'] = isset($opt['start_message'])?$opt['start_message']:'';      
        $this->opt['active']= isset($opt['active']);
        $this->enable=$this->opt['active'];

    }

    function chat_me_now_load_dialog_on_front(){
        echo $this->chat_me_now_loadDialog();
    }
    function add_chat_me_now_style($page){
         wp_enqueue_style( 'chat_me_now_style', BH_PLGN_CMN_URL.'assets/css/wmn-front.css');
    }
    function chat_me_now_loadDialog(){
        
        if($this->enable || $this->admin){
            $ct ='<div id="wmn-fx" >';
            $ct .='<div class="wmn-wrap">';
            $ct.=$this->chat_me_now_getWidget();
            $ct.='</div></div>';
            return $ct;
        }
        return "";
    }
    function chat_me_now_get_start_message(){
        $message = '';
        $message = str_replace("@site", site_url(), $this->opt['start_message']);
        return $message;
    }
    function chat_me_now_getWidget(){
        $whatsapp = '';
        $message = $this->chat_me_now_get_start_message();
        
        switch ($this->opt['whatsapp_active_turn']) {
            case 'whatsapp1':
                $whatsapp = $this->opt['whatsapp1'];
                break;
            case 'whatsapp2':
                $whatsapp = $this->opt['whatsapp2'];
                break;
            case 'scheduled':
                $schedule = explode("|", $this->opt['schedule_turn']);
                $now = date("H:i");
                if(  strtotime($now)>=strtotime($schedule[1]) && strtotime($now)<=strtotime($schedule[2])) {
                    $whatsapp=$this->opt['whatsapp1'];
                }
                else {
                    $whatsapp=$this->opt['whatsapp2'];
                }
                break;                    
        }

        // write_log("chat_me_now_getWidget: " . $whatsapp); 

        return '<div class="wmn-widget" style="background-color:'.(isset($this->opt['background_color'])?$this->opt['background_color']:'#fff').';">
                    <a href="https://wa.me/'.$whatsapp.'?text='.($message).'" target="_blank">
                        <img src="http://showtest.digitalclouddev.com/wp-content/uploads/2022/12/whatsapp.png" alt="Hot Living pty" class="whp-icon">                      <span class="notification">1</span>
                    </a>
                    <span class="text-whp">Asesoría/Pedidos Vía WhatsApp</span>
                </div>';
    }
    
}
?>
