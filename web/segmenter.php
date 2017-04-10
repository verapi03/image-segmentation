<?php
  try 
  {
    $url = $_REQUEST["input"];
    $image = new image();
    $image->download($url);
    echo $image->segment();
  }
  catch(Exception $err) 
  {
    echo $err->getMessage();
  }

  /**
   *  Class image
   */
  class image 
  {
    private $img_route = '/fileserver/image.jpg';

    /**
     *  This method downloads the image from the passed URL.
     *  @param string URL from which an image will be downloaded
     *  @return none
     */
    public function download($url) 
    {
      $img_location = $_SERVER['DOCUMENT_ROOT'].$this->img_route;

      $ch = curl_init($url);
      $fp = fopen($img_location, 'wb');
      curl_setopt($ch, CURLOPT_FILE, $fp);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_exec($ch);
      curl_close($ch);
      fclose($fp);
    }

    /**
     *  This method segments the image to obtain the expected result.
     *  @param none
     *  @return string Route to result image in fileserver 
     */
    public function segment() 
    {
      $img_location = $_SERVER['DOCUMENT_ROOT'].$this->img_route;
      $original_img = ImageCreateFromJpeg($img_location); 
      $original_img_w = imagesx($original_img);
      $original_img_h = imagesy($original_img);

      for ($i=0; $i<$original_img_w; $i++)
      {
        for ($j=0; $j<$original_img_h; $j++)
        {
          // get the rgb value for current pixel
          $rgb = ImageColorAt($original_img, $i, $j); 
          
          // extract each value for r, g, b
          $red = ($rgb >> 16) & 0xFF;
          $green = ($rgb >> 8) & 0xFF;
          $blue = $rgb & 0xFF;

          if ($red > 230)
          {
            // For the pixel near to pure red (255,0,0), keep the original color.
            $val = imagecolorallocate($original_img, $red, $green, $blue);
          }
          else 
          {
            // set the gray intensity of the pixel
            $gray = round(($red + $green + $blue) / 3);

            // grayscale values have r=g=b=gray
            $val = imagecolorallocate($original_img, $gray, $gray, $gray);
          }

          
          // set the gray value
          imagesetpixel($original_img, $i, $j, $val);
        }
      }

      header('Content-type: image/jpeg');
      imagejpeg($original_img, $img_location);

      return $this->img_route;
    }
  }
?>
