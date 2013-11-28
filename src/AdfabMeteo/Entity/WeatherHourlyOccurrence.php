<?php

namespace AdfabMeteo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @ORM\Entity @HasLifecycleCallbacks
 * @ORM\Table(name="weather_hourly_occurrence",
 *          uniqueConstraints={@UniqueConstraint(name="unique_time", columns={"daily_occurrence_id", "time"})}
 * )
 */
class WeatherHourlyOccurrence implements InputFilterAwareInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="WeatherDailyOccurrence", inversedBy="hourlyOccurrences", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="daily_occurrence_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $dailyOccurrence;

    /**
     * @ORM\Column(type="time")
     */
    protected $time;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $temperature; // saved in Celsius' degrees

    /**
     * @ORM\Column(type="integer")
     */
    protected $weatherCode;

    /**
     * @param unknown $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param WeatherDailyOccurrence $dailyOccurrence
     */
    public function setDailyOccurrence($dailyOccurrence)
    {
        $this->dailyOccurrence = $dailyOccurrence;
    }

    /**
     * @return $dailyOccurrence
     */
    public function getDailyOccurrence()
    {
        return $this->dailyOccurrence;
    }

    /**
     * @param time $time
     */
    public function getTime()
    {
        return $this->date;
    }

    /**
     * @return $time
     */
     public function setTime($time)
     {
        $this->time = $time;
        return $this;
    }

    public function getWeatherCode()
    {
        return $this->weatherCode;
    }

    public function setWeatherCode($weatherCode)
    {
        $this->weatherCode = $weatherCode;
        return $this;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function getTemperatureF()
    {
        return (1.8 * $this->temperature)+32;
    }

    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
        return $this;
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array())
    {
        if (isset($data['weatherCode']) && $data['weatherCode'] != null) {
            $this->weatherCode = $data['weatherCode'];
        }
        if (isset($data['temperature']) && $data['temperature'] != null) {
            $this->minTemperature = $data['minTemperature'];
        }
    }

    /**
     * @return the $inputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            $inputFilter = parent::getInputFilter();

            $inputFilter->add($factory->createInput(array('name' => 'id', 'required' => true, 'filters' => array(array('name' => 'Int'),),)));

            $inputFilter->add($factory->createInput(array(
                'name' => 'time',
                'required' => true,
                'validators' => array(
                    array('name' => 'NotEmpty',),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'temperature',
                'required' => true,
                'validators' => array(
                    array('name' => 'Digits',),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'weatherCode',
                'required' => true,
                'validators' => array(
                    array('name' => 'Digits',),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @param field_type $inputFilter
     */
    public function setInputFilter (InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
}