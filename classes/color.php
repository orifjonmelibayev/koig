<?php
/**
* Class for converting colortypes
*
* The class includes the following colors formats and types:
* 
*  - CMYK
*  - RGB
*  - @TODO:Pantone (seperate include file: pantone.color.class.php)
*  - HEX Codes for HTML
* 
*/
class Color {
	
	public static function rgb2hex($rgb = array())
	{
		function toHex($n=0) 
		{
			$n=max(0,$n); $n=min($n,255);
			return substr("0123456789abcdef",($n - ($n % 16))/16)+ substr("0123456789abcdef",$n%16);
		}
		return toHex($rgb['r']).toHex($rgb['g']).toHex($rgb['b']);
	}

	/**
	* Converts the RGB colors to CMYK colors
	*/		
	public static function rgb2cmyk($rgb = array())
	{
		$c = (255-$rgb['r'] )/255.0*100;
		$m = (255-$rgb['g'] )/255.0*100;
		$y = (255-$rgb['b'] )/255.0*100;
		
		$b = min(array($c,$m,$y));
		$c=$c-$b;
		$m=$m-$b;
		$y=$y-$b;
		
		return array( 'c' => $c, 'm' => $m, 'y' => $y, 'b' => $b);
	}
	
	/**
	* Converts the CMYK colors to RGB colors
	*/		
	public static function cmyk2rgb(array $cmyk = array())
	{
		$red = $cmyk['c'] + $cmyk['b'];
		$green = $cmyk['m'] + $cmyk['b'];
		$blue = $cmyk['y'] + $cmyk['b'];
		
		$red = ($red-100)*(-1);
		$green = ($green-100)*(-1);
		$blue = ($blue-100)*(-1);
		
		$red = round($red/100*255,0);
		$green = round($green/100*255,0);
		$blue = round($blue/100*255,0);
		
		$rgb['r'] = $red;
		$rgb['g'] = $green;
		$rgb['b'] = $blue;

		return $rgb;
	}
	
	/**
	* Converts the HTML HEX colors to RGB colors
	*/		
	public static function hex2rgb($hex_in)
	{
		// Convert 1 to 3 symbol code to 6 symbol first
		$hex_in = strtolower($hex_in);
		$hex_in = preg_replace('/#/', '', $hex_in); //Strips out the # character
		$hexlength = strlen($hex_in);
		$hex = '';
		switch($hexlength) {
			case 1:
				$hex = $hex_in.$hex_in.$hex_in.$hex_in.$hex_in.$hex_in;
			break;
			case 2:
				$hex = $hex_in[0].$hex_in[1].$hex_in[0].$hex_in[1].$hex_in[0].$hex_in[1];
			break;
			case 3:
				$hex = $hex_in[0].$hex_in[0].$hex_in[1].$hex_in[1].$hex_in[2].$hex_in[2];
			break;
		}

		$red = substr($hex,0,2);
		$green = substr($hex,2,2);
		$blue = substr($hex,4,2);

		$rgb['r'] = hexdec( $red );
		$rgb['g']  = hexdec( $green );
		$rgb['b'] = hexdec( $blue );

		return $rgb;
	}
	
	/**
	* Converts HTML color name to 6 digit HEX value.
	* @desc Converts HTML color name to 6 digit HEX value.
	* @url http://en.wikipedia.org/wiki/HTML_color_names
	*/		
	public static function name2hex($name)
	{
		$color_names = array( //move this to "up"
			'aqua'    => '00ffff',
			'cyan'    => '00ffff',
			'gray'    => '808080',
			'grey'    => '808080',
			'navy'    => '000080',
			'silver'  => 'c0c0c0',
			'black'   => '000000',
			'green'   => '008000',
			'olive'   => '808000',
			'teal'    => '008080',
			'blue'    => '0000ff',
			'lime'    => '00ff00',
			'purple'  => '800080',
			'white'   => 'ffffff',
			'fuchsia' => 'ff00ff',
			'magenta' => 'ff00ff',
			'maroon'  => '800000',
			'red'     => 'ff0000',
			'yellow'  => 'ffff00'
		);
		if (array_key_exists($name, $color_names)) {
			return $color_names[$name];
		}
		else {
			//error TODO: throw error
		}
	}
}
?>