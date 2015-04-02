<?php
namespace Vendor;

class Helper
{
	/**
	 * Upraví formát data
	 * @param String[$value] Původní čas
	 * @param String[$format] Formát data
	 * @access public
	 * @return String Formátované datum
	 */
	public function date( $value, $format )
	{
		$value = date_create( $value );
		return date_format( $value, $format );
	}

	/**
	 * Validuje řetězec
	 * @param String[$value] Kontrolovaný řetězec
	 * @param String[$type] Typ validace EMAIL/IP/INT/BOOLEAN
	 * @access public
	 * @return Boolean
	 */
	public function validate( $value, $type )
	{
		switch( $type ) {
			case("email"):
				return filter_var( $value, FILTER_VALIDATE_EMAIL );
			case("ip"):
				return filter_var( $value, FILTER_VALIDATE_IP );
			case("int"):
				return filter_var( $value, FILTER_VALIDATE_INT );
			case("bool"):
				return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			default:
				return False;
		}
	}
}