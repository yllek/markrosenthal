<?php
$output = $el_class = $width = '';
extract(shortcode_atts(array(
  'el_class' => '',
  'width' => '1/1',
  'offset' => '',
  'css' => '',
  "boxed" => 'false', 
  "centered_text" => 'false', 
  'enable_animation' => '',
  'animation' => '', 
  'column_padding' => 'no-extra-padding',
  'column_padding_position'=> 'all',
  'top_margin' => '',
  'bottom_margin' => '',
  'delay' => '0',
  'background_color' => '',
  'background_color_hover' => '',
  'background_hover_color_opacity' => '1',
  'background_color_opacity' => '1',
  'background_image' => '',
  'bg_image_animation' => 'none',
  'enable_bg_scale' => '',
  'column_link' => '',
  'column_link_target' => '_self',
  'font_color' => '',
  
  'enable_gradient' => 'false',
  'color_overlay' => '',
  'color_overlay_2' => '',
  'gradient_direction' => 'left_to_right',
  'overlay_strength' => '0.3',
  
  'column_border_width' => 'none',
  'column_border_color' => '',
  'column_border_style' => '',
  'enable_border_animation' => '',
  'border_animation_delay' => '',
  'column_shadow' => 'none',
  'column_border_radius' => 'none',
  'tablet_width_inherit' => 'default',
  'video_bg'=> '', 
  'video_webm'=> '', 
  'video_mp4'=> '', 
  'video_ogv'=> '', 
  'video_image'=> ''
), $atts));


$el_class   = $this->getExtraClass($el_class);
$width      = wpb_translateColumnWidthToSpan($width);
$width      = vc_column_offset_class_merge($offset, $width);
$box_border = null;

$parsed_animation = null;	
$style = 'style="';

$el_class .= ' wpb_column column_container vc_column_container col child_column';

if( $boxed === 'true' && empty($background_image) && empty($background_color) ) { 
  $el_class .= ' boxed'; 
  $box_border = '<span class="bottom-line"></span>'; 
}
if( $centered_text === 'true' ) {
  $el_class .= ' centered-text';
}


$background_color_string = null;
$has_bg_color            = 'false';

if( !empty($background_color) ) {
	$background_color_string .= $background_color;	
  $has_bg_color = 'true';
}

// Img bg.
$image_bg_markup = null;
$image_style     = null;

if(!empty($background_image)) {
	
    if(!preg_match('/^\d+$/',$background_image)){
                    
        $image_style .= 'background-image: url('.esc_url($background_image) . '); ';
    
    } else {

    	$bg_image_src = wp_get_attachment_image_src($background_image, 'full');
    	$image_style .= ' background-image: url(\''.esc_url($bg_image_src[0]) .'\'); ';
    }
    
    $image_bg_markup = '<div class="column-image-bg-wrap" data-bg-animation="'.esc_attr($bg_image_animation).'"><div class="inner-wrap">';
    $image_bg_markup .= '<div class="column-image-bg" style="'.$image_style.'"></div>';
    $image_bg_markup .= '</div></div>';

}

$using_custom_font_color = null;
if( !empty($font_color) ) { 
    $style .= ' color: '.esc_attr($font_color).';';
    $using_custom_font_color = 'data-cfc="true"';
}

// Margins.
if( !empty($top_margin) ) {
    // class for neg margin to adjust z-index
    if( strpos($top_margin,'-' ) !== false) {
        $el_class .= ' neg-marg';
    }
    // actual margin proc
    if( strpos($top_margin,'%' ) !== false) {
        $style .= 'margin-top: '. esc_attr($top_margin) .'; ';
    } else {
        $style .= 'margin-top: '. esc_attr($top_margin) .'px; ';
    }
}

if( !empty($bottom_margin) ) {
    if( strpos($bottom_margin,'%' ) !== false){
        $style .= 'margin-bottom: '. esc_attr($bottom_margin) .'!important; ';
    } else {    
        $style .= 'margin-bottom: '. esc_attr($bottom_margin) .'px!important; ';
    }
}

(empty($background_color) && empty($background_image) && empty($font_color) && empty($top_margin) && empty($bottom_margin) ) ? $style = null : $style .= '"';

$using_bg = (!empty($background_image) || !empty($background_color)) ? 'data-using-bg="true"': null;


if( !empty($animation) && $animation !== 'none' && $enable_animation === 'true' ) {
  $el_class .= ' has-animation';
  
  $parsed_animation = str_replace(" ","-",$animation);
  $delay = intval($delay);
  
}

$el_class .= ' '. $column_padding;

$border_html = null;
$border_style = null;

if(!empty($column_border_width) && $column_border_width !== 'none') {
    
  // regular border when using border radius
  if( strpos($column_border_radius, 'px') !== false ) {

    $border_style = 'style="border: '. esc_attr($column_border_width).' solid '.esc_attr($column_border_color).';"';

  } else {
    
      $column_border_markup = 'border: '. esc_attr($column_border_width).' solid rgba(255,255,255,0); ';
      $border_style = 'style="'.$column_border_markup.'"';

      $border_html = '<span class="border-wrap" style="border-color: '.esc_attr($column_border_color).';"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>';
   }
   
} else {
    $column_border_markup = null;
}


$column_overlay_style = '';

if( !empty($background_color_string) ) {
  
  $column_overlay_style = ' style="';
  
  if( !empty($background_color_opacity) ) {
    $column_overlay_style .= 'opacity: '.esc_attr($background_color_opacity).'; ';
  }
  $column_overlay_style .= 'background-color: '.esc_attr($background_color_string).';';

  $column_overlay_style .= '"';
  
}


// Column color overlay layer.
$column_overlay_layer_style = null;
$column_overlay_layer_markup = null;

if( !empty($color_overlay) || !empty($color_overlay_2) ) {
  
  $column_overlay_layer_style = 'style="';
  $gradient_direction_deg = '90deg';
  
  if(empty($color_overlay)) { 
    $color_overlay = 'transparent'; 
  }
  if(empty($color_overlay_2)) { 
    $color_overlay_2 = 'transparent'; 
  }
  
  // Legacy option conversion.
  if( $overlay_strength === 'image_trans' ) { 
    $overlay_strength = '1';
  }
      
  switch($gradient_direction) {
    case 'left_to_right' : 
      $gradient_direction_deg = '90deg';
      break;
    case 'left_t_to_right_b' : 
      $gradient_direction_deg = '135deg';
      break;
    case 'left_b_to_right_t' : 
      $gradient_direction_deg = '45deg';
      break;
    case 'top_to_bottom' : 
      $gradient_direction_deg = 'to bottom';
      break;
  } 
  
  if( $enable_gradient === 'true' ) {
    
      if($color_overlay !== 'transparent' && $color_overlay_2 === 'transparent') { 
        $color_overlay_2 = 'rgba(255,255,255,0.001)'; 
      }
      if($color_overlay === 'transparent' && $color_overlay_2 !== 'transparent') { 
        $color_overlay = 'rgba(255,255,255,0.001)';
      }
      
      if( $gradient_direction === 'top_to_bottom' ) {
      
        if($color_overlay_2 === 'transparent' || $color_overlay_2 === 'rgba(255,255,255,0.001)') {
          $column_overlay_layer_style .= 'background: linear-gradient('. $gradient_direction_deg .',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 75%);  opacity: '. esc_attr($overlay_strength). '; ';
        }

        if($color_overlay === 'transparent' || $color_overlay === 'rgba(255,255,255,0.001)') { 
          $column_overlay_layer_style .= 'background: linear-gradient('. $gradient_direction_deg .',' . $color_overlay . ' 25%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
        }
        
        if( $color_overlay !== 'transparent' && $color_overlay_2 !== 'transparent') { 
          $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('. $gradient_direction_deg . ',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
        }
      
      } 
      else if( $gradient_direction === 'left_to_right' ) {

        if( $color_overlay === 'transparent' || $color_overlay === 'rgba(255,255,255,0.001)' ) { 
          $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg .',' . $color_overlay . ' 25%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
        }
        
        if( $color_overlay_2 === 'transparent' || $color_overlay_2 === 'rgba(255,255,255,0.001)' ) { 
          if( $overlay_strength === '1' ) {
            $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg .',' . $color_overlay . ' 25%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
          } else {
            $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg .',' . $color_overlay . ' 10%,' . $color_overlay_2 . ' 75%);  opacity: '. esc_attr($overlay_strength) .'; ';
          }
          
        }

        if( $color_overlay !== 'transparent' && $color_overlay_2 !== 'transparent') { 
          $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg.',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '.esc_attr($overlay_strength).'; ';
        }
      }

      else {
        $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg.',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '.esc_attr($overlay_strength).'; ';
      }


  } 
  
  // No gradient.
  else {

      if( !empty($color_overlay) ) {
        $column_overlay_layer_style .= 'background-color:' . $color_overlay . ';  opacity: '.esc_attr($overlay_strength).'; ';
      }

  }
  
  $column_overlay_layer_style .= '"';
  
  $column_overlay_layer_markup = '<div class="column-overlay-layer" '.$column_overlay_layer_style.'></div>';
} 


// Video bg.
$video_markup = null;
if( $video_bg ) {
  
  // parse video image
  if( strpos($video_image, "http://") !== false ) {
    $video_image_src = $video_image;
  } else {
    $video_image_src = wp_get_attachment_image_src($video_image, 'full');
    $video_image_src = $video_image_src[0];
  }
  

  $video_markup .= '
  
  <div class="mobile-video-image column-video" style="background-image: url('. esc_url( $video_image_src ) .')"></div>
  <div class="nectar-video-wrap column-video">';
      
      $video_markup .= '
      <video class="nectar-video-bg" width="1800" height="700" preload="auto" loop autoplay muted playsinline>';
  
        if(!empty($video_webm)) { $video_markup .= '<source src="'. esc_url( $video_webm ) .'" type="video/webm">'; }
        if(!empty($video_mp4)) { $video_markup .= '<source src="'. esc_url( $video_mp4 ) .'"  type="video/mp4">'; }
        if(!empty($video_ogv)) { $video_markup .= '<source src="'. esc_url( $video_ogv ) .'" type="video/ogg">'; }
        
      $video_markup .='</video>';

   $video_markup .= '</div>';

}

$column_link_html     = (!empty($column_link)) ? '<a class="column-link" target="'.$column_link_target.'" href="'.esc_url($column_link).'"></a>' : null;
$column_bg_color_html = (!empty($column_link)) ? '<a class="column-link" target="'.$column_link_target.'" href="'.esc_url($column_link).'"></a>' : null;

$css_class            = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$column_inner_data_attrs  = ' data-t-w-inherits="'. esc_attr($tablet_width_inherit) .'" ';
$column_inner_data_attrs .= 'data-shadow="'.esc_attr($column_shadow).'" ';
$column_inner_data_attrs .= 'data-border-radius="'.esc_attr($column_border_radius).'" ';
$column_inner_data_attrs .= 'data-border-animation="'.esc_attr($enable_border_animation).'" ';
$column_inner_data_attrs .= 'data-border-animation-delay="'.esc_attr($border_animation_delay).'" ';
$column_inner_data_attrs .= 'data-border-width="'.esc_attr($column_border_width).'" ';
$column_inner_data_attrs .= 'data-border-style="'.esc_attr($column_border_style).'" ';
$column_inner_data_attrs .= 'data-border-color="'.esc_attr($column_border_color).'" ';
$column_inner_data_attrs .= 'data-bg-cover="'.esc_attr($enable_bg_scale).'" ';
if( !empty($color_overlay) || !empty($color_overlay_2) ) {
  $column_inner_data_attrs .= 'data-overlay-color="true" ';
}
$column_inner_data_attrs .= 'data-padding-pos="'. esc_attr($column_padding_position) .'" ';
$column_inner_data_attrs .= 'data-has-bg-color="'.esc_attr($has_bg_color).'" ';
$column_inner_data_attrs .= 'data-bg-color="'.esc_attr($background_color_string).'" ';
$column_inner_data_attrs .= 'data-bg-opacity="'.esc_attr($background_color_opacity).'" ';
$column_inner_data_attrs .= 'data-hover-bg="'.esc_attr($background_color_hover).'" ';
$column_inner_data_attrs .= 'data-hover-bg-opacity="'.esc_attr($background_hover_color_opacity).'" ';
$column_inner_data_attrs .= 'data-animation="'.esc_attr(strtolower($parsed_animation)).'" ';
$column_inner_data_attrs .= 'data-delay="'.esc_attr($delay).'"';


$nectar_use_modern_grid = ( function_exists('nectar_use_flexbox_grid') && true === nectar_use_flexbox_grid() ) ? true : false;

// BG Layers.
$col_bg_combined_output = $column_link_html . $border_html . $image_bg_markup . $video_markup;
$col_bg_combined_output .= '<div class="column-bg-overlay-wrap" data-bg-animation="'.esc_attr($bg_image_animation).'"><div class="column-bg-overlay"'.$column_overlay_style.'></div>'.$column_overlay_layer_markup.'</div>';


// Output.
$output .= "\n\t".'<div '.$style.' class="'.esc_attr($css_class).'" '.$using_custom_font_color.' '.$using_bg . $column_inner_data_attrs .'>';

if( false === $nectar_use_modern_grid ) {
  $output .= $col_bg_combined_output;
}

$output .= "\n\t\t".'<div class="vc_column-inner" '.$border_style.'>'; 

if( true === $nectar_use_modern_grid ) {
  $output .= $col_bg_combined_output;
}


// Content.
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper'); 


$output .= "\n\t".'</div>'; 


$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo $output;