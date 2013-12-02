<?php

namespace AdfabMeteoTest\Mapper;

use AdfabMeteo\Entity\WeatherDailyOccurrence;
use AdfabMeteo\Entity\WeatherHourlyOccurrence;
use AdfabMeteoTest\Bootstrap;
use AdfabMeteo\Entity\WeatherCode;

class WeatherCodeTest extends \PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    public function setUp()
    {
        $this->sm = Bootstrap::getServiceManager();
        $this->em = $this->sm->get('doctrine.entitymanager.orm_default');
        $this->tm = $this->sm->get('adfabmeteo_weathercode_mapper');
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
        $classes = $this->em->getMetadataFactory()->getAllMetadata();
        $tool->dropSchema($classes);
        $tool->createSchema($classes);
    }

    public function testFindLastAssociatedCode()
    {
        $code1 = new WeatherCode();
        $code1->setCode(1);
        $code1->setDefault(0);

        $code2 = new WeatherCode();
        $code2->setCode(2);
        $code2->setDefault(0);
        $code2->setAssociatedCode($code1);

        $code3 = new WeatherCode();
        $code3->setCode(3);
        $code3->setDefault(0);
        $code3->setAssociatedCode($code2);

        $this->assertEquals($code1, $this->tm->findLastAssociatedCode($code3));
    }

    public function tearDown()
    {
        $dbh = $this->em->getConnection();
        unset($this->tm);
        unset($this->sm);
        unset($this->em);
        parent::tearDown();
    }
}