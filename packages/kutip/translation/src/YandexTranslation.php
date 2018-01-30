<?php

namespace Kutip\Translation;

use Kutip\Translation\Contracts\Translation as TranslationContract;
use Unirest\Request;
use Unirest\Request\Body;
use Illuminate\Support\Facades\Log;

class YandexTranslation implements TranslationContract
{
    /**
     * Source lang.
     *
     * @var string
     */
    private $source = 'en';

    /**
     * Destination lang.
     *
     * @var string
     */
    private $destination;

    /**
     * Set source lang.
     *
     * @param string $source
     *
     * @return self
     */
    public function source(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Set destination lang.
     *
     * @param string $destination
     *
     * @return self
     */
    public function destination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Translate from source lang to destination lang.
     *
     * @param string $text
     *
     * @return string|null
     */
    public function translate(string $text): ?string
    {
        $headers = [];
        $body = Body::form([
            'text' => $text,
            'lang' => $this->source.'-'.$this->destination,
        ]);

        $key = config('translation.yandex.key');
        if (empty($key)) {
            abort(500, 'Yandex API Key is not defined.');
        }

        $response = Request::post(
            'https://translate.yandex.net/api/v1.5/tr.json/translate?key='.$key,
            $headers,
            $body
        );

        if ($response->code == 200) {
            return end($response->body->text);
        } else {
            Log::error('Failed to get translated text from Yandex.', [
                'code' => $response->code,
                'message' => $response->body->message,
            ]);
        }

        return null;
    }
}
