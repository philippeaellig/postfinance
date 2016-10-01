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

namespace PostFinance;

interface Request
{

    public function toArray();

    public function getPostFinanceUri();

    public function getShaSign();

    public function getRequiredFields();

    public function getValidPostFinanceUris();
}
