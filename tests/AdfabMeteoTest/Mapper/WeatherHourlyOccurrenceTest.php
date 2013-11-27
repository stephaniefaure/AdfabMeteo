<?php

namespace AdfabMeteoTest\Mapper;

use AdfabMeteo\Entity\WeatherDailyOccurrence;
use AdfabMeteo\Entity\WeatherHourlyOccurrence;
use AdfabMeteoTest\Bootstrap;

class WeatherHourlyOccurrenceTest extends \PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    public function setUp()
    {
        $this->sm = Bootstrap::getServiceManager();
        $this->em = $this->sm->get('doctrine.entitymanager.orm_default');
        $this->tm = $this->sm->get('adfabmeteo_weatherhourlyoccurrence_mapper');
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
        $classes = $this->em->getMetadataFactory()->getAllMetadata();
        $tool->dropSchema($classes);
        $tool->createSchema($classes);
    }

    public function testFindByDailyOccurrence()
    {
        $dailyOccurrence = new WeatherDailyOccurrence();
        $dailyOccurrence->setId(1);

        $hourlyOccurrence = new WeatherHourlyOccurrence();
        $hourlyOccurrence->setId(1);
        $this->tm->insert($hourlyOccurrence);

        $this->assertEquals($hourlyOccurrence, current($this->tm->findByDailyOccurrence($dailyOccurrence)));
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