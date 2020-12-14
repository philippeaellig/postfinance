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

namespace PostFinance\DirectLink;

use PostFinance\AbstractPaymentResponse;
use SimpleXMLElement;
use InvalidArgumentException;

class DirectLinkPaymentResponse extends AbstractPaymentResponse
{

    public function __construct($xml_string)
    {
        libxml_use_internal_errors(true);

        if (simplexml_load_string($xml_string)) {
            $xmlResponse = new SimpleXMLElement($xml_string);

            $attributesArray = $this->xmlAttributesToArray($xmlResponse->attributes());

            // use lowercase internally
            $attributesArray = array_change_key_case($attributesArray, CASE_UPPER);

            // filter request for PostFinance parameters
            $this->parameters = $this->filterRequestParameters($attributesArray);

            if ($xmlResponse->HTML_ANSWER) {
                $this->parameters['HTML_ANSWER'] = base64_decode($xmlResponse->HTML_ANSWER);
            }

        } else {
            throw new InvalidArgumentException("No valid XML-string given");
        }
    }

    private function xmlAttributesToArray($attributes)
    {
        $attributesArray = array();

        if (count($attributes)) {
            foreach ($attributes as $key => $value) {
                $attributesArray[(string)$key] = (string)$value;
            }
        }

        return $attributesArray;
    }
}
