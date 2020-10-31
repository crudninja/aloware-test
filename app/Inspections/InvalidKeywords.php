<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    /**
     * All spam keywords
     *
     * @var array
     */
    protected $keywords = [
        'customer support',
        'lorem',
        'ipsum',
    ];

    /**
     * Detect spam
     *
     * @param  string $body
     * @throws \Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception("Your comment contains spam.");
            }
        }
    }

}