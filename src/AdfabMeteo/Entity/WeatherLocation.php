<?php

namespace AdfabMeteo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity @HasLifecycleCallbacks
 * @ORM\Table(name="weather_location",
 *   uniqueConstraints={@UniqueConstraint(name="unique_location", columns={"latitude", "longitude"}),
 *                      @UniqueConstraint(name="unique_city", columns={"city", "country"})})
 */
class WeatherLocation implements InputFilterAwareInterface
{
    protected $inputFilter;

    public static $countries = array(
    	'France',
    );

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $country;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $latitude;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $longitude;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function populate($data = array())
    {
        if (isset($data['city']) && $data['city'] != null) {
            $this->city = $data['city'];
        }
        if (isset($data['country']) && $data['country'] != null) {
            $this->country = $data['country'];
        }
        if (isset($data['latitude']) && $data['latitude'] != null) {
            $this->latitude = $data['latitude'];
        }
        if (isset($data['longitude']) && $data['longitude'] != null) {
            $this->longitude = $data['longitude'];
        }
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('not used');
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array('name' => 'id', 'required' => true, 'filters' => array(array('name' => 'Int'),),)));

            $inputFilter->add($factory->createInput(array(
                'name' => 'city',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty',),
                    array('name' => 'StringLength', 'options' => array('min'=>1, 'max' => 255)),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'city',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty',),
                    array('name' => 'StringLength', 'options' => array('min'=>1, 'max' => 255)),
                    array(
                        'name' => 'InArray',
                        'options' => array(
                            'haystack' => self::$countries,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}