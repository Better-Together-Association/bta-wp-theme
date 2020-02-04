<?php
/**
 * Filters
 *
 * @package Better Together
 */

add_filter( 'login_url', 'bta_custom_login_url', 10, 3 );
/**
 * Filters the login URL.
 * 
 * @TODO make the page url dynamically set by ultimate member
 *
 * @since 2.8.0
 * @since 4.2.0 The `$force_reauth` parameter was added.
 *
 * @param string $login_url    The login URL. Not HTML-encoded.
 * @param string $redirect     The path to redirect to on login, if supplied.
 * @param bool   $force_reauth Whether to force reauthorization, even if a cookie is present.
 *
 * @return string
 */
function bta_custom_login_url( $login_url, $redirect, $force_reauth ){
    
    if( is_admin() ) return $url;

    $login_url = site_url( '/login/', 'login' );
    if ( ! empty( $redirect ) ) {
        $login_url = add_query_arg( 'redirect_to', urlencode( $redirect ), $login_url );
    }
    if ( $force_reauth ) {
        $login_url = add_query_arg( 'reauth', '1', $login_url );
    }
    return $login_url;
}
