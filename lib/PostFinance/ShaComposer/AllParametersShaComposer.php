<?php

/*
 * This file is part of the Wysow PostFinance package.
 *
 * (c) Gaultier Boniface <gboniface@wysow.fr>
 * (c) Marlon BVBA <info@marlon.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PostFinance\ShaComposer;

use PostFinance\ParameterFilter\GeneralParameterFilter;
use PostFinance\Passphrase;
use PostFinance\HashAlgorithm;
use PostFinance\ParameterFilter\ParameterFilter;

/**
 * SHA string composition the "new way", using all parameters in the PostFinance response
 */
class AllParametersShaComposer implements ShaComposer
{
    /** @var array of ParameterFilter */
    private $parameterFilters;

    /**
     * @var string Passphrase
     */
    private $passphrase;

    /**
     * @var HashAlgorithm
     */
    private $hashAlgorithm;

    /**
     * @var boolean
     */
    private $forceUtf8 = false;

    public function __construct(Passphrase $passphrase, HashAlgorithm $hashAlgorithm = null)
    {
        $this->passphrase = $passphrase;

        $this->addParameterFilter(new GeneralParameterFilter);

        $this->hashAlgorithm = $hashAlgorithm ?: new HashAlgorithm(HashAlgorithm::HASH_SHA1);
    }

    public function compose(array $parameters)
    {
        foreach ($this->parameterFilters as $parameterFilter) {
            $parameters = $parameterFilter->filter($parameters);
        }

        ksort($parameters);

        // compose SHA string
        $shaString = '';
        foreach($parameters as $key => $value) {
            $shaString .= sprintf('%s=%s%s',
                $key,
                ($this->forceUtf8 && !$this->isUtf8($value)) ? utf8_encode($value) : $value,
                $this->passphrase
            );
        }

        return strtoupper(hash($this->hashAlgorithm, $shaString));
    }

    public function addParameterFilter(ParameterFilter $parameterFilter)
    {
        $this->parameterFilters[] = $parameterFilter;
    }

    /**
     * Define if we force UTF8 encoding on values before composing
     *
     * @var boolean $forceUtf8
     *
     * @return AllParametersShaComposer
     */
    public function forceUtf8($forceUtf8)
    {
        $this->forceUtf8 = (bool)$forceUtf8;

        return $this;
    }

    /**
     * Test if a string is encoded in UTF-8.
     *
     * @see
     *   http://www.php.net/manual/fr/function.mb-detect-encoding.php#50087
     *
     * @param $string (required)
     *   The string to test.
     *
     * @return
     *   true if $string is valid UTF-8 and false otherwise.
     */
    public function isUtf8($string)
    {
        // From http://w3.org/International/questions/qa-forms-utf-8.html
        return preg_match('%^(?:
              [\x09\x0A\x0D\x20-\x7E]            # ASCII
            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
            |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
            |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
            |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
        )*$%xs', $string);
    }
}
