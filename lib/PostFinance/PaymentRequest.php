<?php

namespace PostFinance;

interface PaymentRequest extends Request
{
    /** @var string */
    const SHASIGN_FIELD = 'SHASIGN';
}
