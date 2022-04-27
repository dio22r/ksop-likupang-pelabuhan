<?php

namespace App\Traits;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

trait CaptchaTrait
{
  public function setCaptcha()
  {
    $phraseBuilder = new PhraseBuilder(4, '0123456789');
    $captchaBuilder = new CaptchaBuilder(null, $phraseBuilder);
    $captchaBuilder->build();

    $content = $captchaBuilder->getPhrase();
    session()->setFlashdata('captcha', $content);

    return $captchaBuilder;
  }

  public function validateCaptcha(string $request)
  {
    $captcha = session()->getFlashdata('captcha');
    return $captcha == $request;
  }
}
