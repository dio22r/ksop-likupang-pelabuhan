<?php

namespace App\Traits;

trait CaptchaTrait
{
  public function setCaptcha(string $content)
  {
    session()->setFlashdata('captcha', $content);
    return $content;
  }

  public function validateCaptcha(string $request)
  {
    $captcha = session()->getFlashdata('captcha');
    return $captcha == $request;
  }
}
