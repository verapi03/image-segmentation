<?php
  try {
    $url = $_REQUEST["input"];
    $image = new image();
    echo $image->download($url);
  }
  catch(Exception $err) {
    echo $err->getMessage();
  }

  /**
   *  Class image
   */
  class image {
    // protected $url;

    // public function __construct($url_image) {
    //   $this->url = $url_image;
    // }
    
    /**
     *  This method downloads the image from the passed URL.
     *  @param string URL from which an image will be downloaded
     *  @return string Route to result image in fileserver 
     */
    public function download($url) {
      $ch = curl_init($url);
      $file = '/fileserver/image.jpg';
      $global_location = $_SERVER['DOCUMENT_ROOT'].$file;
      $fp = fopen($global_location, 'wb');
      curl_setopt($ch, CURLOPT_FILE, $fp);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_exec($ch);
      curl_close($ch);
      fclose($fp);
      return $file;
    }
  }

?>
