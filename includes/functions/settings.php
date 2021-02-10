<?php
/**
 * Contains Settings option for Crucial Real Estate plugin.
 */


if ( ! function_exists( 'cre_get_settings_price_format' ) ) {
	
	function cre_get_settings_price_format( $price ) {
		if ( empty( $price ) ) {
			return esc_html( get_option( 'theme_no_price_text', '' ) );
		}
		$decimals           = esc_html( get_option( 'theme_decimals', '' ) );
		$decimals_point     = esc_html( get_option( 'theme_dec_point', '' ) );
		$thousand_separator = get_option( 'theme_thousands_sep', '' );
		$price              = number_format( $price, $decimals, $decimals_point, $thousand_separator );
		
		if ( get_option( 'theme_currency_position', '' ) == 'before' ) {
			$price = esc_html( get_option( 'theme_currency_sign', '' ) ) . esc_html( $price );
		} else {
			$price = esc_html( $price ) . esc_html( get_option( 'theme_currency_sign', '' ) );
		}
		
		return $price;
		
		
	}
	
}

?>