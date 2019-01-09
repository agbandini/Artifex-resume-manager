<?php

if (__FILE__ == $_SERVER['SCRIPT_FILENAME'])
    exit('No direct access allowed.');

/**
 * Upload class
 */
class Upload {

    /**
     * Config
     *
     * @access private 
     */
    private static $config;

    /**
     * Error
     *
     * @access private 
     */
    private $errore;

    /**
     * Constructor
     * 
     * @access public 
     */
    public function __construct() {

        self::$config = config_load();
        $this->errore = new Errore();
    }

    /**
     * Upload image
     * 
     * @access public 
     */
    public function upload_image($file, $width, $height, $nosize) {

        if (is_array($file)) {

            $ext = substr(strrchr($file['name'], '.'), 1);

            if ($file['size'] > self::$config['max_filesize']){
                $this->errore->set_error('Uno o più files che si sta tentando di caricare è troppo grande. Si prega di ridurre le sue dimensioni e riprovare.');
            }
                
        } else {

            $ext = substr(strrchr($_FILES[$file]['name'], '.'), 1);

            if ($_FILES[$file]['size'] > self::$config['max_filesize']){
                $this->errore->set_error('Uno o più files che si sta tentando di caricare è troppo grande. Si prega di ridurre le sue dimensioni e riprovare.');
            }
                
        }

        //var_dump($this->errore->display_errors());
        
        if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))){
            $this->errore->set_error('The file you attempted to upload is not allowed.' . $ext);
        }
            

        if (!is_writable(self::$config['upload_path'] . 'images/')){
            $this->errore->set_error('The folder ' . self::$config['upload_path'] . ' images/ is not writeable.');
        }
            
        //var_dump($_FILES[$file]['name']);
        //var_dump($ext);
        //var_dump($this->errore->display_errors());
        
        if (!$this->errore->has_errors()) {

            $file_name = time() . md5(uniqid(mt_rand())) . '.' . $ext;

            if (is_array($file)){
                copy($file['tmp_name'], self::$config['upload_path'] . 'images/' . $file_name);
            } else {
                copy($_FILES[$file]['tmp_name'], self::$config['upload_path'] . 'images/' . $file_name);
            }
                

            if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {

                if ($ext == 'jpg' || $ext == 'jpeg'){
                    $image = imagecreatefromjpeg(self::$config['upload_path'] . 'images/' . $file_name);
                } elseif ($ext == 'png') {
                    $image = imagecreatefrompng(self::$config['upload_path'] . 'images/' . $file_name);
                } elseif ($ext == 'gif') {
                    $image = imagecreatefromgif(self::$config['upload_path'] . 'images/' . $file_name);
                }
                
                $imagesx = imagesx($image); //larghezza attuale
                $imagesy = imagesy($image); //altezza attuale

                if ($nosize == 0) {

                    $image_ratio = $imagesx / $imagesy;
                    if ($imagesx > $imagesy) {
                        //se l'immagine è più larga che alta
                        $height = round($width / $image_ratio);
                    } else {
                        //se l'immagine è più alta che larga
                        $width = round($height * $image_ratio);
                    }

                    $new_image = imagecreatetruecolor($width, $height);
                    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, $imagesx, $imagesy);
                    if ($ext == 'jpg' || $ext == 'jpeg')
                        imagejpeg($new_image, self::$config['upload_path'] . 'images/' . $file_name, 75);
                    elseif ($ext == 'png')
                        imagepng($new_image, self::$config['upload_path'] . 'images/' . $file_name);
                    elseif ($ext == 'gif')
                        imagegif($new_image, self::$config['upload_path'] . 'images/' . $file_name);
                } else {
                    //$new_image = imagecreatetruecolor(0, 0);
                    //imagecopy($new_image, $image, 0, 0, 0, 0, $imagesx, $imagesy);
                }
            }

            return $file_name;
        }
    }

    /**
     * Upload file
     * 
     * @access public 
     */
    public function upload_file($field_name) {

        $ext = pathinfo($_FILES[$field_name]['name']);

        if (!in_array($ext['extension'], self::$config['allowed_filetypes']))
            $this->errore->set_error('The file you attempted to upload is not allowed.');

        if ($_FILES[$field_name]['size'] > self::$config['max_filesize'])
            $this->errore->set_error('Uno o più files che si sta tentando di caricare è troppo grande. Si prega di ridurre le sue dimensioni e riprovare.');

        if (!is_writable(self::$config['upload_path'] . 'files/'))
            $this->errore->set_error('The folder ' . self::$config['upload_path'] . ' files/ is not writeable.');

        if (!$this->errore->has_errors()) {

            $file_name = time() . '.' . $ext['extension'];

            copy($_FILES[$field_name]['tmp_name'], self::$config['upload_path'] . 'files/' . $file_name);

            return $file_name;
        }
    }

}

?>
