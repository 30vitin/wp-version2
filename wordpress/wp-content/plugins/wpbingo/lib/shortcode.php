<?php
 //LO NUEVO
	function wpbingo_social_link_shortcode( $args, $content ) {
	global $fashow_settings;	
	$content = '<ul class="social-link">';
		if($fashow_settings['link-fb'])
			//https://hot-living.test/wp-content/uploads/2022/11/facebook-icon.png
			//$content .= '<li><a href="'.esc_url($fashow_settings['link-fb']).'"><i class="fa fa-facebook"></i></a></li>';
			$content .= '<li><a href="'.esc_url($fashow_settings['link-fb']).'"><img src="http://showtest.digitalclouddev.com/wp-content/uploads/2022/11/facebook-icon.png" alt="" class="icon-social-tam"></a></li>';

		if($fashow_settings['link-tw'])
			$content .= '<li><a href="'.esc_url($fashow_settings['link-tw']).'"><i class="fa fa-twitter"></i></a></li>';
		if($fashow_settings['link-googleplus'])
			$content .= '<li><a href="'.esc_url($fashow_settings['link-googleplus']).'"><i class="fa fa-google"></i></a></li>';
		if($fashow_settings['link-instagram'])
			//$content .= '<li><a href="'.esc_url($fashow_settings['link-instagram']).'"><i class="fa fa-instagram"></i></a></li>';
			 $content .= '<li><a href="'.esc_url($fashow_settings['link-instagram']).'"><img src="http://showtest.digitalclouddev.com/wp-content/uploads/2022/11/insta-logo.png" alt="" class="icon-social-tam"></a></li>';

			//
		if($fashow_settings['link-linkedin'])
			$content .= '<li><a href="'.esc_url($fashow_settings['link-linkedin']).'"><i class="fa fa-linkedin"></i></a></li>';
		if($fashow_settings['link-pinterest'])
			$content .= '<li><a href="'.esc_url($fashow_settings['link-pinterest']).'"><i class="fa fa-pinterest"></i></a></li>';
	$content .= '</ul>';
	return $content; 
	}


	  
	add_shortcode('social_link', 'wpbingo_social_link_shortcode');	

	function wpbingo_social_share_shortcode() {
		global $post,$fashow_settings;
		
		if (!$fashow_settings['social-share']) return false;
		
		$permalinked = urlencode(get_permalink($post->ID));
		$permalink = get_permalink($post->ID);
		$title = urlencode($post->post_title);
		$stitle = $post->post_title;
		$image = esc_url(wp_get_attachment_url( get_post_thumbnail_id() ));
		
		$data = '<div class="social-share">';
			
		if ($fashow_settings['share-fb']) {
			$data .='<a href="http://www.facebook.com/sharer.php?u='.esc_url($permalink).'&i='.esc_url($image).'&t='.esc_html($stitle).'" title="'. esc_attr__('Facebook', 'wpbingo').'" class="share-facebook" target="_blank"><i class="fa fa-facebook"></i></a>';
		}			
		if ($fashow_settings['share-tw']) {
			$data .='<a href="https://twitter.com/intent/tweet?text='.esc_html($stitle).'&amp;url='.esc_url($permalink).'"  title="'. esc_attr__('Twitter', 'wpbingo').'" class="share-twitter">'. esc_html__('', 'wpbingo').'<i class="fa fa-twitter"></i></a>';
		}
		if ($fashow_settings['share-linkedin']) {
			$data .='<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url='.esc_url($permalink).'&amp;title='.esc_html($stitle).'"  title="'. esc_attr__('LinkedIn', 'wpbingo').'" class="share-linkedin">'. esc_html__('', 'wpbingo').'<i class="fa fa-linkedin"></i></a>';
		}
		if ($fashow_settings['share-googleplus']) {
			$data .= '<a href="https://plus.google.com/share?url='.esc_url($permalink).'"  title="'. esc_attr__('Google +', 'wpbingo').'" class="share-googleplus">'. esc_html__('', 'wpbingo').'<i class="fa fa-google-plus"></i></a>';
		}
		if ($fashow_settings['share-pinterest']) {
			$data .= '<a href="https://pinterest.com/pin/create/button/?url='.esc_url($permalink).'&amp;media='.esc_url($image).'"  title="'. esc_attr__('Pinterest', 'wpbingo').'" class="share-pinterest">'. esc_html__('', 'wpbingo').'<i class="fa fa-pinterest"></i></a>';
		}
		$data .= '</div>';
		return $data;

	}	
	
	add_shortcode('social_share', 'wpbingo_social_share_shortcode');	