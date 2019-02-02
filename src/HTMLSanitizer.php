<?php
/**
 * Input sanitizer
 * @author Diccon Towns <diccon@also-festival.com>
 *
 */

namespace DMCTowns\Sanitizer;

/**
 * Class to sanitize HTML
 */

class HTMLSanitizer{

	/**
	 * Returns sanitized HTML
	 * @param string $input
	 * @return string
	 */
	static public function getSanitized($input){
		// strip out Hex characters from within tags
		$input = preg_replace('/(?<=\<)([^>]+?)(&#[0-9]+|&#[A-Z0-9]+;)|(&#[0-9]+|&#[A-Z0-9]+;)(?=[^<>]*>)/i', '$1', $input);
		// strip out script tags
		$input = preg_replace('/<[^>]*script[^>]*>.*<\/[^>]*script[^>]*>/si', '', $input);
		// strip out javascript: links
		$input = preg_replace('/\b\w+=(\'|")?javascript:(?(1)[^\1]+|[^ >]+)(?(1)\1|( |>))/i', '\2', $input);
		// strip out javascript event links
		$input = preg_replace('/\bon\w+=(\'|")?(?(1)[^\1]+|[^ >]+)(?(1)\1|( |>))/i', '\2', $input);

		return $input;

	}

	/**
	 * Returns stripped
	 * @param string $input
	 * @return string
	 */
	static public function getStripped($input){

		$input = self::getSanitized($input);
		// remove line breaks
		$input = str_replace(array("\r","\n"), "", $input);
		// substitute line breaks for li br and p tags
		$input = preg_replace('/(<\/li>|<\/p>|<br *\/?>)/i', "\n", $input);

		return strip_tags($input);
	}
}