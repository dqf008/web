<?php
class CImage{
    public $width;
    public $heigth;
    public $sessionName = 'randcode';
    public $type = 'png';
    public $charlen = 4;
    public $fontSize = 15;
    public $ttf;
    
    private $img;
    private $chars = '0123456789';
    
    function __construct($width=48, $heigth=18, $fontSize=15){
        $this->width = $width;
        $this->heigth = $heigth;
        $this->fontSize = $fontSize;
        $this->img = imagecreate($this->width, $this->heigth);
        $this->ttf = dirname(__FILE__).'/ttf/F2FOCRBczykLTStd-Regular.otf';
        imagefill($this->img, 0, 0, imagecolorallocate($this->img, 230, 235, 255)); 
    }
    
    function writeChar($code){
        $code = str_split($code);
        $codeLen = count($code);
        $fontWidth = 0;
        $randLeft = floor($this->width-(($this->fontSize+1)*$codeLen))/($codeLen-1);
        $randTop = floor(($this->heigth-($this->fontSize+1))/2);
        foreach($code as $key=>$val){
            $code[$key] = [
                'red' => rand(0, 150),
                'green' => rand(0, 150),
                'blue' => rand(0, 150),
                'fontSize' => $this->fontSize+rand(-1, 1),
                'fontLeft' => rand(0, $randLeft),
                'fontTop' => rand(0, $randTop),
                'code' => $val,
            ];
            $fontWidth+= $code[$key]['fontSize'];
            $fontWidth+= $codeLen>$key+1?$code[$key]['fontLeft']:0;
        }
        $fontLeft = floor($this->width/2)-floor($fontWidth/2);
        $fontTop = floor($this->heigth/2);
        foreach($code as $conf){
            $conf['fontTop']+= $fontTop+floor($conf['fontSize']/2);
            $col = imagecolorallocate($this->img, $conf['red'], $conf['green'], $conf['blue']);
            imagettftext($this->img, $conf['fontSize'], rand(-20, 20), $fontLeft, $conf['fontTop'], $col, $this->ttf, $conf['code']);
            $fontLeft+= $conf['fontSize'];
            $fontLeft+= $conf['fontLeft'];
        }
    }
    
    function writeArc($i){
        while($i--){
            $col = imagecolorallocate($this->img, rand(0, 120), rand(0, 120), rand(0, 120));
            imagearc($this->img, rand(1, $this->width), rand(10, $this->heigth), rand(20, $this->width), rand(1, $this->heigth), rand(1, 360), 300, $col);
        }
    }
    
    function writePix($i){
        while($i--){
            $width = rand(0, $this->width);
            $heigth = rand(0, $this->heigth);
            $col = imagecolorallocate($this->img, rand(0, 200), rand(0, 200), rand(0, 200));
            imagesetpixel($this->img, $width, $heigth, $col);
        }
    }
    
    function printimg(){
        header('Content-Type: image/'.$this->type);
        $chars = str_split($this->chars);
        $len = count($chars);
        $code = '';
        for($i=0;$i<$this->charlen;$i++){
            $code.= $chars[rand(0, $len-1)];
        }
        $_SESSION[$this->sessionName] = strtolower($code);
        $this->writeChar($code);
        // $this->writeArc(3);
        $this->writePix(20);
        $fun = 'image'.$this->type;
        $fun($this->img);
    }
    
}

session_start();
$img = new CImage(50, 20, 11);
$img->printimg();
