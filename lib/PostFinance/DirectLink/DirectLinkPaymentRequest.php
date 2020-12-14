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

use PostFinance\AbstractPaymentRequest;
use PostFinance\ShaComposer\ShaComposer;
use InvalidArgumentException;

class DirectLinkPaymentRequest extends AbstractPaymentRequest
{

    const TEST = "https://e-payment.postfinance.ch/ncol/test/orderdirect.asp";
    const PRODUCTION = "https://e-payment.postfinance.ch/ncol/prod/orderdirect.asp";

    public function __construct(ShaComposer $shaComposer)
    {
        $this->shaComposer = $shaComposer;
        $this->PostFinanceUri = self::TEST;
    }

    public function getRequiredFields()
    {
        return array(
            'pspid', 'currency', 'amount', 'orderid', 'userid', 'pswd'
        );
    }

    public function getValidPostFinanceUris()
    {
        return array(self::TEST, self::PRODUCTION);
    }

    public function setUserId($userid)
    {
        if (strlen($userid) < 8) {
            throw new InvalidArgumentException("User ID is too short");
        }
        $this->parameters['userid'] = $userid;
    }

    /** Alias for setPswd() */
    public function setPassword($password)
    {
        $this->setPswd($password);
    }

    public function setPswd($password)
    {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException("Password is too short");
        }
        $this->parameters['pswd'] = $password;
    }

    public function setAlias(Alias $alias)
    {
        $this->parameters['alias'] = $alias->__toString();
    }

    public function setEci(Eci $eci)
    {
        $this->parameters['eci'] = (string) $eci;
    }

    public function setCvc($cvc)
    {
        $this->parameters['cvc'] = $cvc;
    }

    public function setBrowserAcceptHeader($browserAcceptHeader)
    {
        $this->parameters['browserAcceptHeader'] = $browserAcceptHeader;
    }

    public function setBrowserColorDepth($browserColorDepth)
    {
        $this->parameters['browserColorDepth'] = $browserColorDepth;
    }

    public function setBrowserJavaEnabled($browserJavaEnabled)
    {
        $this->parameters['browserJavaEnabled'] = $browserJavaEnabled;
    }

    public function setBrowserLanguage($browserLanguage)
    {
        $this->parameters['browserLanguage'] = $browserLanguage;
    }

    public function setBrowserScreenHeight($browserScreenHeight)
    {
        $this->parameters['browserScreenHeight'] = $browserScreenHeight;
    }

    public function setBrowserScreenWidth($browserScreenWidth)
    {
        $this->parameters['browserScreenWidth'] = $browserScreenWidth;
    }

    public function setBrowserTimeZone($browserTimeZone)
    {
        $this->parameters['browserTimeZone'] = $browserTimeZone;
    }

    public function setBrowserUserAgent($browserUserAgent)
    {
        $this->parameters['browserUserAgent'] = $browserUserAgent;
    }

    public function setFlag3d($flag3d)
    {
        $this->parameters['FLAG3D'] = $flag3d;
    }

    public function setHttpAccept($httpAccept)
    {
        $this->parameters['HTTP_ACCEPT'] = $httpAccept;
    }

    public function setHttpUserAgent($httpUserAgent)
    {
        $this->parameters['HTTP_USER_AGENT'] = $httpUserAgent;
    }

    public function setWin3ds($win3ds)
    {
        $this->parameters['WIN3DS'] = $win3ds;
    }

    public function setTxtoken($txtoken)
    {
        $this->parameters['txtoken'] = $txtoken;
    }

    public function setPayId($payId)
    {
        $this->parameters['payid'] = $payId;

    }

    protected function getValidOperations()
    {
        return array(
            self::OPERATION_REQUEST_AUTHORIZATION,
            self::OPERATION_REQUEST_DIRECT_SALE,
            self::OPERATION_REFUND,
            self::OPERATION_REQUEST_PRE_AUTHORIZATION,
        );
    }
}
