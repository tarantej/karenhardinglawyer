<?php
/*
Plugin Name: MAJpage Menu Class Extender
Description: Adds classes to first, last, parent, even and odd elements of wp_page_menu and wp_nav_menu to support recognizing it in older browsers without :first-child, :last-child and :nth-child supporting.
Author: Wiktor Maj
Version: 1.6
Author URI: http://www.majpage.com
*/

class MAJpageMCE
{
 public static function init()
 {
  if( class_exists( 'SimpleXMLElement' ) ) {
   add_filter( 'wp_nav_menu', [ __CLASS__, 'extend' ] );
   add_filter( 'wp_page_menu', [ __CLASS__, 'extend' ] );
  }
 }

 public static function extend( $output )
 {
  $xmlInternalErrors = libxml_use_internal_errors( false );
  try {
   $xml = new SimpleXMLElement( preg_replace( '#>([^<]+)<#i', '><![CDATA[\\1]]><', $output ), LIBXML_NOWARNING );
  } catch( Exception $e ) {
   return $output;
  }
  $containerOpen = '';
  $containerClose = '';
  if( ! $xml->li ) {
   $items = $xml->xpath( 'ul' );
   $item = current( $items );
   if( ! $item ) {
    $items = $xml->xpath( 'menu' );
    $item = current( $items );
   }
   if( $item ) {
    $containerOpen = '<' . $xml->getName();
    $containerClose = '</' . $xml->getName() . '>';
	foreach( $xml->attributes() as $key => $value ) {
     $containerOpen .= ' ' . $key . '="' . $value . '"';
    }
    $containerOpen .= '>';
   }
  } else {
   $item = $xml;
  }
  libxml_use_internal_errors( $xmlInternalErrors );
  if( count( $item ) > 0 ) {
   $output = preg_replace( '#<!\[CDATA\[([^<]+)\]\]>#', '\\1', self::_extendLevel( $item )->asXML() );
   $output = preg_replace( '#<\?[^>]*\?>#', '', $output );
   $containerOpen = '<!-- Menu modified by MAJpage Menu Class Extender -->' . $containerOpen;
  }
  return $containerOpen . $output . $containerClose;
 }

 private static function _extendLevel( $xml )
 {
  $count = count( $xml->li );
  if( $count > 0 ) {
   $i = 1;
   foreach( $xml->li as $item ) {
    $attributes = $item->attributes();
    $attributes['class'] = ( $i % 2 == 1 ? 'odd' : 'even' ) . '-menu-item ' . $attributes['class'];
    if( $item->ul || $item->menu ) {
	 $attributes['class'] = 'parent-menu-item ' . $attributes['class'];
	 self::_extendLevel( $item->ul ? $item->ul : $item->menu );
	}
    if( $i == $count ) {
     $attributes['class'] = 'last-menu-item ' . $attributes['class'];
    }
    if( $i == 1 ) {
     $attributes['class'] = 'first-menu-item ' . $attributes['class'];
    }
    $i++;
   }
  }
  return $xml;
 }
}

MAJpageMCE::init();
