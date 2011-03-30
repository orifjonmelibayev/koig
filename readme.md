#Kohana image generator
Create dummy images.

## Usage

After installing module, you can link to koig controller in your HTML (or in views) as image file:
<img src="/koig/(size)[.format][?parameters]" />

### Definitions

* size: can be "width"x"height" or any of predefined sizes. If height is omitted, image will be a square.
	ex: <img src="koig/200" /> - 200x200 gif image
	    <img src="koig/200x100" /> - 200x100 gif image
	    <img src="koig/banner" /> - 100x60 gif image, "banner" is predefined in core.
* format: Can be one of .gif, .png, .jpg, .jpeg Default is .gif
* parameters:
	* bg: background color in hex format, can be 1,2,3 or 6 digit default is 000.ex: bg=aa1234 or bg=aaa
	* fg: foreground color. same as background. Default is fff.
	* text: text of image, default is size of image. ex: text=Your text
	* text_angle: Angle of turned text, default is 0. ex: text_angle=90 prints vertical text

Example with full parameters:
	<img src="/koig/130x600.jpg?bg=a&fg=0f0f0f&text=My banner&text_align=90" />

##TODO:
*  Add named shortcuts. i.e. predefined settings for standard sized images