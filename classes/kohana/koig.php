<?php defined('SYSPATH') or die('No direct script access.');

abstract class Kohana_Koig extends Controller {

	public $width = 1;
	public $height = 0;
	public $bg = '000';
	public $fg = 'fff';
	public $format = 'gif';
	public $text_angle = 0; 
	public $text = '';
	public $font;

	public function before()
	{
		$this->width = $this->request->param('width');
		// if height is not given make it square
		if ( ! $this->height = $this->request->param('height'))
			$this->height = $this->width;
		$this->bg = $this->request->param('bg');
		$this->fg = $this->request->param('fg');
		$this->format = $this->request->param('format');
		$this->text_angle = $this->request->param('text_angle');
		$this->font = Kohana::find_file('fonts',"mplus-1c-medium",'ttf'); // TODO:make it more flexible 
		if ( ! $this->text = $this->request->param('text'))
			$this->text = $this->width." × ".$this->height; //Default text is size of image

	}

	public function action_dummy()
	{
		$area = $this->width * $this->height;
		//if ($area >= 16000000)  //Limit the size of the image to no more than an area of 16,000,000.
			 // throw Kohana error here
		$img = imagecreate($this->width,$this->height); //Create an image.
		$bg = Color::hex2rgb($this->bg);
		$fg = Color::hex2rgb($this->fg);

		$bg = imageColorAllocate($img, $bg['r'], $bg['g'], $bg['b']); 
		$fg = imageColorAllocate($img, $fg['r'], $fg['g'], $fg['b']); 

		$fontsize = max(min($this->width/strlen($this->text)*1.15, $this->height*0.5) ,5); // Make text to fit image area
		$textBox = $this->_imagettfbbox_t($fontsize, $this->text_angle, $this->font, $this->text); 
		$textWidth = ceil( ($textBox[4] - $textBox[1]) * 1.07 ); 
		$textHeight = ceil( (abs($textBox[7])+abs($textBox[1])) * 1 ); 
		$textX = ceil( ($this->width - $textWidth)/2 ); 
		$textY = ceil( ($this->height - $textHeight)/2 + $textHeight ); 
		imageFilledRectangle($img, 0, 0, $this->width, $this->height, $bg); 
		imagettftext($img, $fontsize, $this->text_angle, $textX, $textY, $fg, $this->font, $this->text);

		$this->response->headers('content-type',  File::mime_by_ext($this->format));
		//echo Debug::dump(array($this, $bg, $fg));
// /*

		//Create the final image based on the provided file format.
		ob_start();
		try
		{
			switch ($this->format)
			{
			case 'gif':
				imagegif($img);
			break;
			case 'png':
				imagepng($img);
			break;
			case 'jpg':
				imagejpeg($img);
			break;
			}
		}
		catch (Exception $e)
		{
			// Delete the output buffer
			ob_end_clean();

			// Re-throw the exception
			throw $e;
		}
		imageDestroy($img);//Destroy the image to free memory.
		// Get the captured output and close the buffer
		$this->response->body(ob_get_clean());
// */
	}

		//Ruquay K Calloway http://ruquay.com/sandbox/imagettf/ made a better function to find the coordinates of the text bounding box so I used it.
	protected function _imagettfbbox_t($size, $text_angle, $fontfile, $text)
	{
		// compute size with a zero angle
		$coords = imagettfbbox($size, 0, $fontfile, $text);
    
		// convert angle to radians
		$a = deg2rad($text_angle);
    
		// compute some usefull values
		$ca = cos($a);
		$sa = sin($a);
		$ret = array();
    
		// perform transformations
		for($i = 0; $i < 7; $i += 2){
			$ret[$i] = round($coords[$i] * $ca + $coords[$i+1] * $sa);
			$ret[$i+1] = round($coords[$i+1] * $ca - $coords[$i] * $sa);
		}
		return $ret;
	}

}
