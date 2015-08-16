<?php

    namespace Test\ObjectivePHP\Message\Request\Parameter\Container;

    use ObjectivePHP\Message\Request\HttpRequest;
    use ObjectivePHP\Message\Request\Parameter\Container\HttpParameterContainer;
    use ObjectivePHP\PHPUnit\TestCase;
    
    class HttpParameterContainerTest extends TestCase
    {
        public function testParametersAreExtractedFromEnvironment()
        {
            $_GET['param1'] = 'value';
            $_GET['param0 value'] = '';


            $request = $this->getMock(HttpRequest::class);

            $container = new HttpParameterContainer($request);

            $this->assertEquals('value', $container->get('param1'));
            $this->assertEquals('param0 value', $container->get(0));


        }

    }