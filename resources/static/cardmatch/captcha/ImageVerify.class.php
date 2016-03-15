<?php
  /******************************************************************

   Projectname:   CAPTCHA class
   Version:       1.1
   Author:        Pascal Rehfeldt <Pascal@Pascal-Rehfeldt.com>
   Last modified: 15. March 2004
   Copyright (C): 2003, 2004 Pascal Rehfeldt, all rights reserved

   * GNU General Public License (Version 2, June 1991)
   *
   * This program is free software; you can redistribute
   * it and/or modify it under the terms of the GNU
   * General Public License as published by the Free
   * Software Foundation; either version 2 of the License,
   * or (at your option) any later version.
   *
   * This program is distributed in the hope that it will
   * be useful, but WITHOUT ANY WARRANTY; without even the
   * implied warranty of MERCHANTABILITY or FITNESS FOR A
   * PARTICULAR PURPOSE. See the GNU General Public License
   * for more details.

   Description:
   This class can generate CAPTCHAs, see README for more details!

   Get the "Hurry up!" Font for the Captcha and
   save it in the same directory as this file.

   "Hurry up!" Font (c) by Andi
   See http://www.1001fonts.com/font_details.html?font_id=2366

  ******************************************************************/

class ImageVerify
{
    var $Length;
    var $CaptchaString;
    var $ImageType;
    var $Font;
    var $CharWidth;
    var $_returnLowerCase = true;

    function ImageVerify ($length = 6, $type = 'png', $font = '', $letter = '')
    {

      $this->Length    = $length;
      $this->ImageType = $type;
      //$this->Font      = 'templates/csaStyle1/fonts/hurryup.ttf';
      $this->Font = $font;
      $this->CharWidth = 20;

      if ($letter == '')
      {
        $this->StringGen();
      }
      else
      {
        $this->Length        = strlen($letter);
        $this->CaptchaString = $letter;
      }

     // $this->SendHeader();

      $this->MakeCaptcha();

    }

    function StringGen ()
    {

      $uppercase  = array(	'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'M', 'N', 
							'P', 'Q', 'R', 'T', 'U', 'V', 'W', 'X', 'Y');
      $numeric    = array('2', '3', '4', '6', '7', '8', '9');

      $CharPool   = array_merge($uppercase, $numeric);
      $PoolLength = count($CharPool) - 1;

      for ($i = 0; $i < $this->Length; $i++)
      {

        $this->CaptchaString .= $CharPool[mt_rand(0, $PoolLength)];

      }
      
      if($this->_returnLowerCase === true)
      {
         $this->CaptchaString = strToLower($this->CaptchaString);
      }
    }

    /*function SendHeader ()
    {

      switch ($this->ImageType)
      {

        case 'jpeg': header('Content-type: image/jpeg'); break;
        case 'png':  header('Content-type: image/png');  break;
        default:     header('Content-type: image/png');  break;

      }

    }*/

    function MakeCaptcha ()
    {
      $image       = imagecreatefrompng('./captchabg.png');
      $stringcolor = imagecolorallocate($image, 160, 160, 160);
      $linecolor   = imagecolorallocate($image, 0, 0, 0);
      
      imagettftext($image, 26, -2, 5, 34,
                   $stringcolor,
                   $this->Font,
                   $this->CaptchaString);

      switch ($this->ImageType)
      {

        case 'jpeg': imagejpeg($image); break;
        case 'png':  imagepng($image);  break;
        default:     imagepng($image);  break;

      }

    }

    function GetCaptchaString ()
    {

      return $this->CaptchaString;

    }

}

?>
