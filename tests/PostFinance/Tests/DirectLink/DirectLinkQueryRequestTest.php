<?php
/*
 * @author Nicolas Clavaud <nicolas@lrqdo.fr>
 */

namespace PostFinance\Tests\DirectLink;

use PostFinance\Tests\ShaComposer\FakeShaComposer;
use PostFinance\DirectLink\DirectLinkQueryRequest;

class DirectLinkQueryRequestTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function IsValidWhenRequiredFieldsAreFilledIn()
    {
        $directLinkQueryRequest = $this->provideMinimalDirectLinkQueryRequest();
        $directLinkQueryRequest->validate();
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function IsInvalidWhenFieldsAreMissing()
    {
        $directLinkQueryRequest = new DirectLinkQueryRequest(new FakeShaComposer);
        $directLinkQueryRequest->validate();
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function isInvalidWithNonPostFinanceUrl()
    {
        $directLinkQueryRequest = $this->provideMinimalDirectLinkQueryRequest();
        $directLinkQueryRequest->setPostFinanceUri('http://example.com');
        $directLinkQueryRequest->validate();
    }

    /**
     * @test
     */
    public function isValidWithPostFinanceUrl()
    {
        $directLinkQueryRequest = $this->provideMinimalDirectLinkQueryRequest();
        $directLinkQueryRequest->setPostFinanceUri(DirectLinkQueryRequest::PRODUCTION);
        $directLinkQueryRequest->validate();
    }

    /**
     * @test
     * @dataProvider provideBadParameters
     * @expectedException \InvalidArgumentException
     */
    public function BadParametersCauseExceptions($method, $value)
    {
        $directLinkQueryRequest = new DirectLinkQueryRequest(new FakeShaComposer);
        $directLinkQueryRequest->$method($value);
    }

    public function provideBadParameters()
    {
        return array(
            array('setPassword', '12'),
            array('setUserid', '12'),
        );
    }

    /** @return DirectLinkQueryRequest */
    private function provideMinimalDirectLinkQueryRequest()
    {
        $directLinkRequest = new DirectLinkQueryRequest(new FakeShaComposer());
        $directLinkRequest->setPspid('123456');
        $directLinkRequest->setUserId('user_1234');
        $directLinkRequest->setPassword('abracadabra');
        $directLinkRequest->setPayId('12345678');

        return $directLinkRequest;
    }
}
