<?php
/*
Plugin Name: Kattene_Custom
Author: radical-kei
Plugin URI: https://www.radical-dreamer.com/
Description: kattene_custom.
Version: 1.5
Author URI: https://www.radical-dreamer.com/
Text Domain: kattene_custom
Domain Path: /languages

License:
 Released under the GPL license
  http://www.gnu.org/copyleft/gpl.html

  Copyright 2021 (email : kei.radicaldreamer@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function kattene_func( $args, $content ) {

  $path = str_replace(home_url(),'',plugin_dir_url( __FILE__ ));
  wp_enqueue_style( 'kattene', $path . 'style.css');

  $content = str_replace("<br />", "", $content);
  $arr = json_decode($content,true);
  $sites = $arr["sites"];

  $main_tmp = array_filter($sites,
    function($site){
      return $site["main"];
    }
  );

  $main = array_pop($main_tmp);

  $cnt = count($sites);

  if ($cnt == 1):
      $num_class = "__one";
  elseif ($cnt == 2):
      $num_class = "__two";
  elseif ($cnt == 3):
      $num_class = "__three";
  elseif ($cnt == 4):
      $num_class = "__four";
  elseif ($cnt == 5):
      $num_class = "__five";
  endif;

  $opt = array(
    'width'  => 160,
    'height' => 160,
    'shadow' => true,
    'no_target_blank' => false,
    'custom' => false
  );
  $opt = apply_filters('kattene', $opt);

  if(is_array($args)){
    $args = kattene_convert_str_bool('shadow', $args);
    $args = kattene_convert_str_bool('no_target_blank', $args);
    $opt = array_merge($opt, $args);
  }

  $shadow_str = $opt['shadow'] ? 'class="kattene__shadow" ' : '';

  if($opt['no_target_blank']){
    $target_blank_str = "";
  }else{
    $target_blank_str = ' target="_blank" rel="noopener"';
  }

  if($opt['custom']){
    wp_enqueue_style( 'kattene-custom', get_stylesheet_directory_uri() . '/kattene-custom.css', array('kattene'));
  }

  $lazyloading_str = ' width="'. $opt['width'].'" height="'.$opt['height'].'" loading="lazy"';

  $str = '<div class="kattene">
    <div class="kattene__imgpart"><a'.$target_blank_str.' href="'.$main["url"].'"><img' .$lazyloading_str. ' src="'.$arr["image"].'" '.$shadow_str.'></a></div>
    <div class="kattene__infopart">
      <div class="kattene__title"><a'.$target_blank_str.' href="'.$main["url"].'">'.$arr["title"].'</a></div>
      <div class="kattene__description">'.$arr["description"].'</div>
      <div class="kattene__btns '.$num_class.'">';

  for( $i=0 ; $i<$cnt ; $i++ ){
     if(array_key_exists('afi_url', $sites[$i]))
     {
        $url = $sites[$i]["afi_url"] . urlencode($sites[$i]["url"]);
     }else{
        $url = $sites[$i]["url"];
     }
     $str .= '<div><a class="kattene__btn __'.$sites[$i]["color"].'"'.$target_blank_str.' href="'.$url.'">'.$sites[$i]["label"].'</a></div>';
  }

  $str .= '</div></div></div>';

  add_action( 'wp_footer', 'kattene_script' );
  return $str;
}

add_shortcode( 'kattene', 'kattene_func' );

function kattene_script() {
  echo <<< EOM
<script>
 var loadDeferredStyles = function() {
   var addStylesNodes = document.getElementsByClassName("deferred-kattene");
   var replacement = document.createElement("div");

   addStylesNodes = Array.prototype.slice.call(addStylesNodes);
   addStylesNodes.forEach(function(elm) {
     replacement.innerHTML += elm.textContent;
     elm.parentElement.removeChild(elm);
   });
   document.body.appendChild(replacement);
 };
 var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
     window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
 if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
 else window.addEventListener('load', loadDeferredStyles);
</script>
EOM;
}

function add_noscript_to_kattene( $tag, $handle ) {
  if ( !in_array( $handle , [ 'kattene', 'kattene-custom' ], true ) ) {
      return $tag;
  }
  $tag = str_replace( '<link', '<noscript class="deferred-kattene"><link', $tag );
  return str_replace( '/>', '/></noscript>', $tag );
}
add_filter( 'style_loader_tag', 'add_noscript_to_kattene', 10, 2 );

remove_filter('the_content', 'wptexturize');

function kattene_convert_str_bool($key, $args){
  if ( array_key_exists($key, $args) ) {
    $args[$key] = ($args[$key] == 'false') ? false : true ;
  }
  return $args;
}
