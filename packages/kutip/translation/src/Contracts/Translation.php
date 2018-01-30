<?php

namespace Kutip\Translation\Contracts;

interface Translation
{
    /**
     * Set source language.
     *
     * @param string $source
     */
    public function source(string $source);

    /**
     * Set destination language.
     *
     * @param string $destination
     */
    public function destination(string $destination);

    /**
     * Translate text from source lang to destination lang.
     *
     * @param string $text
     */
    public function translate(string $text);
}
