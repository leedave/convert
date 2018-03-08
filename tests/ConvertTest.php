<?php

namespace Leedch\Convert;

use Leedch\Convert\Convert;
use PHPUnit\Framework\TestCase;

class ConvertTest extends TestCase {

    public function testAlphanumeric() 
    {
        $textXss = "this is ä <script>javascript:alert('test');</script> string with xss";
        $response = Convert::alphanumeric($textXss);
        $expected = "this is ä scriptjavascriptalerttestscript string with xss";
        $responseNoSpace = Convert::alphanumeric($textXss, false);
        $expectedNoSpace = "thisisäscriptjavascriptalerttestscriptstringwithxss";
        
        $textHtml = "Name and Image <img src=\"https://media.leed.ch/data/cache/img/64_1416166070.jpg\" />";
        $responseHtml = Convert::alphanumeric($textHtml);
        $expectedHtml = "Name and Image img srchttpsmedialeedchdatacacheimg641416166070jpg ";
        
        $this->assertEquals($expected, $response);
        $this->assertEquals($expectedNoSpace, $responseNoSpace); 
        $this->assertEquals($expectedHtml, $responseHtml);
    }
    
    public function testSlugify() 
    {
        $textAscii = "This is a nice page, I lik'd it";
        $response = Convert::slugify($textAscii);
        $expected = "this-is-a-nice-page-i-lik-d-it";
        $this->assertEquals($expected, $response);
        
        $textDe = "Dieser ominöse apfelschäler hat mir gekündigt";
        $response = Convert::slugify($textDe);
        $expected = "dieser-ominoese-apfelschaeler-hat-mir-gekuendigt";
        $this->assertEquals($expected, $response);
        
        $textFr = "l'être du céntre pomidu est ça merdè du môt";
        $response = Convert::slugify($textFr);
        $expected = "l-etre-du-centre-pomidu-est-ca-merde-du-mot";
        $this->assertEquals($expected, $response);
    }

    public function testJson_decode() 
    {
        $json = '{"entities":[{"spark": true, "name": "Hans"}]}';
        $response = Convert::json_decode($json);
        $expected = "Hans";
        $this->assertEquals($expected, $response['entities'][0]['name']);
    }

    public function testJson_encode() 
    {
        $arrData = [
            "entities" => [
                [
                    "name" => "Hans",
                    "spark" => true,
                ]
            ]
        ];
        $response = Convert::json_encode($arrData);
        $expected = '{"entities":[{"name":"Hans","spark":true}]}';
        $this->assertEquals($expected, $response);
    }





/*
Examples

    // Use this to access protected methods
    protected static function getMethod($name) {
        $class = new ReflectionClass('Stucard\\Admin\\Core\\MailweaverConnector');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    // Example accessing a protected method
    public function testPing()
    {
        $m = new MailweaverConnector();
        $f = self::getMethod('ping');
        $response = $f->invokeArgs($m, []);
        $this->assertEquals($response->HelloWorldResult, 'Hello World!', 'Cannot Ping Mailweaver API');
    }


//Following examples are based on old PHPUNIT

    //Fetch Class function
    protected function getClass()
    {
        //Plain Mock
        $scopeConfigMock = $this->getMockBuilder(\Magento\Framework\App\Config\ScopeConfigInterface::class)
               ->disableOriginalConstructor()
               ->getMock();
       
        //Added Methods, with returned Mock Element
        $context = $this->getMockBuilder('Magento\Framework\App\Helper\Context')
                        ->disableOriginalConstructor()
                        ->getMock();
        $context->method('getScopeConfig')->willReturn($scopeConfigMock);
        
        //Added Method with different Input Values, use callback Function to simulate return
        $scopeConfigMock
                ->expects(static::any())
                ->method('getValue')
                ->will($this->returnCallback([$this, 'scopeConfigCallBack']));

        $m = new Data($context);
        return $m;
    }

    //Callback needs to be public
    public function scopeConfigCallBack($foo)
    {
        if ($foo === 'arcmedia_importproducts/general/password_protected') {
            return true;
        }
        if ($foo === 'arcmedia_importproducts/general/password') {
            return 'VD4FzppNNgWqURNqKHmnOc1V0p3DywY6NJ7i3cx30';
        }
        return "No Response set for: ".$foo."\n";
    }

*/

}
