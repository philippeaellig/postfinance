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

namespace PostFinance\FormGenerator;

use PostFinance\Ecommerce\EcommercePaymentRequest;

class SimpleFormGenerator implements FormGenerator
{
	private $ecommercePaymentRequest;

	private $showSubmitButton = true;

	private $formName = 'postFinance';

	/** @return string */
	public function render(EcommercePaymentRequest $ecommercePaymentRequest)
	{
		$this->ecommercePaymentRequest = $ecommercePaymentRequest;
		ob_start();
		include __DIR__.'/template/simpleForm.php';
		return ob_get_clean();
	}

	protected function getParameters()
	{
		return $this->ecommercePaymentRequest->toArray();
	}

	protected function getPostFinanceUri()
	{
		return $this->ecommercePaymentRequest->getPostFinanceUri();
	}

	protected function getShaSign()
	{
		return $this->ecommercePaymentRequest->getShaSign();
	}

	public function showSubmitButton($bool = true)
	{
		$this->showSubmitButton = $bool;
	}

	public function setFormName($formName)
	{
		$this->formName = $formName;
	}
}
