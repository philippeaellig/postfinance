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

namespace PostFinance\Tests\FormGenerator;

use PostFinance\FormGenerator\SimpleFormGenerator;
use PostFinance\PaymentRequest;
use PostFinance\Tests\TestCase;

class SimpleFormGeneratorTest extends TestCase
{
	/** @test */
	public function GeneratesAForm()
	{
        $expected =
            '<form method="post" action="https://e-payment.postfinance.ch/ncol/test/orderstandard.asp" id="postfinance" name="postfinance">
                <input type="hidden" name="PSPID" value="123456789" />
                <input type="hidden" name="ORDERID" value="987654321" />
                <input type="hidden" name="CURRENCY" value="EUR" />
                <input type="hidden" name="AMOUNT" value="100" />
                <input type="hidden" name="CN" value="Louis XIV" />
                <input type="hidden" name="OWNERADDRESS" value="1, Rue du Palais" />
                <input type="hidden" name="OWNERTOWN" value="Versailles" />
                <input type="hidden" name="OWNERZIP" value="2300" />
                <input type="hidden" name="OWNERCTY" value="FR" />
                <input type="hidden" name="EMAIL" value="louis.xiv@versailles.fr" />
                <input type="hidden" name="'.PaymentRequest::SHASIGN_FIELD.'" value="foo" />
		        <input type="submit" value="Submit" id="Postfinancesubmit" name="Postfinancesubmit" />
            </form>';

        $paymentRequest = $this->provideMinimalPaymentRequest();

        $formGenerator = new SimpleFormGenerator();

        $this->assertXmlStringEqualsXmlString($expected, $formGenerator->render($paymentRequest));
        $this->assertXmlStringEqualsXmlString($expected, $formGenerator->render($paymentRequest, 'postfinance', true));
	}

    /** @test */
    public function BCCheck()
    {
        $expected =
            '<form method="post" action="https://e-payment.postfinance.ch/ncol/test/orderstandard.asp" id="postfinanceform" name="postfinanceform">
                <input type="hidden" name="PSPID" value="123456789" />
                <input type="hidden" name="ORDERID" value="987654321" />
                <input type="hidden" name="CURRENCY" value="EUR" />
                <input type="hidden" name="AMOUNT" value="100" />
                <input type="hidden" name="CN" value="Louis XIV" />
                <input type="hidden" name="OWNERADDRESS" value="1, Rue du Palais" />
                <input type="hidden" name="OWNERTOWN" value="Versailles" />
                <input type="hidden" name="OWNERZIP" value="2300" />
                <input type="hidden" name="OWNERCTY" value="FR" />
                <input type="hidden" name="EMAIL" value="louis.xiv@versailles.fr" />
                <input type="hidden" name="'.PaymentRequest::SHASIGN_FIELD.'" value="foo" />
            </form>';

        $paymentRequest = $this->provideMinimalPaymentRequest();

        $formGenerator = new SimpleFormGenerator();
        $formGenerator->setFormName('postfinanceform');
        $formGenerator->showSubmitButton(false);
        $this->assertXmlStringEqualsXmlString($expected, $formGenerator->render($paymentRequest));
        $this->assertXmlStringEqualsXmlString($expected, $formGenerator->render($paymentRequest, 'postfinanceform', false));
    }

	/** @test */
	public function GeneratesAFormWithCustomOperationParameter()
	{
        $expected =
            '<form method="post" action="https://e-payment.postfinance.ch/ncol/test/orderstandard.asp" id="postfinance" name="postfinance">
                <input type="hidden" name="PSPID" value="123456789" />
                <input type="hidden" name="ORDERID" value="987654321" />
                <input type="hidden" name="CURRENCY" value="EUR" />
                <input type="hidden" name="AMOUNT" value="100" />
                <input type="hidden" name="CN" value="Louis XIV" />
                <input type="hidden" name="OWNERADDRESS" value="1, Rue du Palais" />
                <input type="hidden" name="OWNERTOWN" value="Versailles" />
                <input type="hidden" name="OWNERZIP" value="2300" />
                <input type="hidden" name="OWNERCTY" value="FR" />
                <input type="hidden" name="EMAIL" value="louis.xiv@versailles.fr" />
                <input type="hidden" name="OPERATION" value="SAL" />
                <input type="hidden" name="'.PaymentRequest::SHASIGN_FIELD.'" value="foo" />
                <input type="submit" value="Submit" id="Postfinancesubmit" name="Postfinancesubmit" />
            </form>';

        $paymentRequest = $this->provideMinimalPaymentRequest();
        $paymentRequest->setOperation('SAL');

        $formGenerator = new SimpleFormGenerator();

        $this->assertXmlStringEqualsXmlString($expected, $formGenerator->render($paymentRequest));
        $this->assertXmlStringEqualsXmlString($expected, $formGenerator->render($paymentRequest, 'postfinance', true));
	}
}
