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
        foreach ($parameters as $key => $value) {
            $shaString .= $key . '=' . $value . $this->passphrase;
        }

        return strtoupper(hash($this->hashAlgorithm, $shaString));
    }

    public function addParameterFilter(ParameterFilter $parameterFilter)
    {
        $this->parameterFilters[] = $parameterFilter;
    }
}
