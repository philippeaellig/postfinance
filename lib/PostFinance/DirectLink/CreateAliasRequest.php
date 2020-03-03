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

use PostFinance\AbstractRequest;
use PostFinance\ShaComposer\ShaComposer;

class CreateAliasRequest extends AbstractRequest
{

    const TEST = "https://e-payment.postfinance.ch/ncol/test/alias_gateway.asp";
    const PRODUCTION = "https://e-payment.postfinance.ch/ncol/prod/alias_gateway.asp";

    public function __construct(ShaComposer $shaComposer)
    {
        $this->shaComposer = $shaComposer;
        $this->PostFinanceUri = self::TEST;
    }

    public function getRequiredFields()
    {
        return array(
            'pspid', 'accepturl', 'exceptionurl'
        );
    }

    public function getValidPostFinanceUris()
    {
        return array(self::TEST, self::PRODUCTION);
    }

    public function setAlias(Alias $alias)
    {
        $this->parameters['alias'] = (string) $alias;
    }
}
