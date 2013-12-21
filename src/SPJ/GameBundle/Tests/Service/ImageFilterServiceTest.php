<?php

namespace SPJ\GameBundle\Tests\Service;

use SPJ\GameBundle\Service\ImageFilterService;

class ChallengeControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $service;
    protected $imageProcessingMock;

    protected function setUp()
    {
        $this->imageProcessingMock = $this->getMock(
            'SPJ\GameBundle\Adapter\ImageProcessingAdapter',
            array('resize', 'getSize')
        );
        $this->service = new ImageFilterService($this->imageProcessingMock);
    }

    public function test_resize_calls_adapter_with_correct_landscape_size()
    {
        $this->imageProcessingMock->expects($this->once())
                                  ->method('getSize')
                                  ->will($this->returnValue(array(1200, 1000)));

        $this->imageProcessingMock->expects($this->once())
                                  ->method('resize')
                                  ->with(
                                    $this->equalTo('source'),
                                    $this->equalTo('destination'),
                                    $this->equalTo(360),
                                    $this->equalTo(300)
                                  );

        $this->service->resize('source', 'destination', 400, 300);
    }

}
