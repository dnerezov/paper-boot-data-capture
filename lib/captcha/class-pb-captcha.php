<?php
/**
 * A class used for creating captcha image drawn from fonts provided.
 * This class is to be called via url request as http://somename/captcha.php.
 * Dependencies are GD Library.
 * Resources are TTF OTF fonts.
 *
 */

/**
 * @category  Library (Security)
 * @package   Mvc Bobo
 * @author    Denis Nerezov <dnerezov@gmail.com>
 * @copyright (c) 2010 Denis Nerezov
 * @link      http://bobo.org/license
 */
final class captcha
{
    /**
     * Image canvas width
     *
     * @var     integer
     */
    private $width = 165;

    /**
     * Image canvas height
     *
     * @var     integer
     */
    private $height = 50;

    /**
     * Image canvas rgb colors
     *
     * @var     array
     */
    protected $canvasColor = '#ffffff';

    /**
     * Random text code to use.
     *
     * @var     string
     */
    public $code;

    /**
     * Generated Image. Gd object handler
     *
     * @var     object
     */
    private $image;

    /**
     * Fonts repository relative path.
     *
     * @var     string
     */
    protected $pathFont = 'fonts/';

    /**
     * Fonts to be used to create an image
     *
     * @var     array
     */
    protected $fonts = array(
            'AntykwaBold.ttf',
            'Candice.ttf',
            'Ding-DongDaddyO.ttf',
            'Duality.ttf',
            'Heineken.ttf',
            'Jura.ttf'
        );

    /**
    * Instance of this class
    *
    * @var     object
    */
    public static $instance;

	/**
	* Create an image using provided resources.
	*
	*/
    public function __construct($code)
    {
        $this->image = $this->makeCanvas();
		$this->code  = $code;
        
        $colorBg   = $this->makeCanvasColor();
        $colorFont = $this->makeFontColor();
        $font      = $this->getFont();

        imagefilledrectangle($this->image, 0, 0, 399, 99, $colorBg);
        imagettftext($this->image, 35, 0, 2, 40, $colorFont, $font, $this->code);
    }

    /**
    * Singelton approach to instanciate class.
    *
    * @return $instance object
    */
    public static function &load()
    {
        if(!isset(self::$instance))
        {
            $c = __CLASS__;
            self::$instance = new $c();
        }

        return self::$instance;
    }

    /**
     * Create image background layer with provided dimensions.
     *
     * @return gd image object
     */
    private function makeCanvas()
    {
        return imagecreatetruecolor($this->width, $this->height);
    }

    /**
     * Make background color from provided rgb set.
     *
     * @return mixed
     */
    private function makeCanvasColor()
    {
        $canvasColor = $this->hexToRgb($this->canvasColor);
		$canvasColor = array_combine(array('r', 'g', 'b'), $canvasColor);

		extract($canvasColor);

        return imagecolorallocate($this->image, $r, $g, $b);
    }

    /**
     * Make random font color.
     *
     * @return mixed
     */
    private function makeFontColor()
    {
        $pallete = array();

        foreach (array('r', 'g', 'b') as $color) {
            $pallete[$color] = $this->makeHash(3, '0123456789');
        }

        extract($pallete);

        return imagecolorallocate($this->image, $r, $g, $b);
    }

    /**
     * Get random font from provided fonts repository.
     *
     * @return string
     */
    private function getFont()
    {
        if (count($this->fonts) > 1) {
            $font = array_rand(array_flip($this->fonts));
        } else {
            $font = current($this->fonts);
        }

        return $this->pathFont.$font;
    }

    /**
     * Make hash.
     *
     * @param integer $length number of characters to be used.
     * @param string $pool characters to be used
     * @return string
     */
    public static function makeHash($length = 5, $pool = 'abcdefghijkmnpqrstuvwxyz')
    {
        $str = null;

        for ($i = 0; $i < $length; $i++) {
            $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
        }

        return $str;
    }
	
	/**
	* Convert css hex color value to rgb value
	*
	* @return void
	*/
	private function hexToRgb($color)
	{
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}
		
		if (strlen($color) == 6) {
			list($r, $g, $b) = array($color[0].$color[1],
									 $color[2].$color[3],
									 $color[4].$color[5]);
		} elseif (strlen($color) == 3) {
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		} else {
			return false;
		}
		
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

		return array($r, $g, $b);
	}

    /**
	* Set image header
	*
	* @return void
	*/
    public function create()
    {
        header("Content-type: image/png");
        imagepng($this->image);
        ImageDestroy($this->image);
    }
}

session_start();

$code = captcha::makeHash();
$_SESSION['captcha'] = $code;

$image = new captcha($code);
$image->create();
