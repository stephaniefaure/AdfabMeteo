<?php

namespace AdfabMeteo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

/**
 * @ORM\Entity @HasLifecycleCallbacks
 * @ORM\Table(name="weather_code")
 */
class WeatherCode implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $code;

    /**
     * @ORM\Column(type="string")
     */
    protected $description = '';

    /**
     * @ORM\Column(name="icon_url", type="string")
     */
    protected $iconURL = '';

    /**
     * @ORM\Column(type="boolean")
     */
    protected $default = 0;

    /**
     * @ORM\ManyToOne(targetEntity="WeatherCode", inversedBy="WeatherCode", cascade={"persist"})
     * @ORM\JoinColumn(name="associated_code", referencedColumnName="id")
     */
    protected $associatedCode = null;


    /**
     * @param unknown $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return $iconURL
     */
    public function getIconURL()
    {
        return $this->iconURL;
    }

    /**
     * @param string $iconURL
     */
    public function setIconURL($iconURL)
    {
        $this->iconURL= $iconURL;
        return $this;
    }

    /**
     * @return $associatedCode
     */
    public function getAssociatedCode()
    {
        return $this->associatedCode;
    }


    /**
     * @param \AdfabMeteo\WeatherCode $associatedCode
     */
    public function setAssociatedCode($associatedCode)
    {
        $this->associatedCode = $associatedCode;
        return $this;
    }

    /**
     * @return $default
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array())
    {
        if (isset($data['code']) && $data['code'] != null) {
            $this->code = $data['code'];
        }
        if (isset($data['description']) && $data['description'] != null) {
            $this->description = $data['description'];
        }
        if (isset($data['default']) && $data['default'] != null) {
            $this->default = $data['default'];
        }
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * @param InputFilterInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new Factory();

            $inputFilter->add($factory->createInput(array('name' => 'id', 'required' => true, 'filters' => array(array('name' => 'Int'),),)));

            $inputFilter->add($factory->createInput(array(
                'name' => 'code',
                'required' => true,
                'validators' => array(
                    array('name' => 'NotEmpty',),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'description',
                'required' => true,
                'validators' => array(
                    array('name' => 'NotEmpty',),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'associatedCode',
                'required' => false,
                'allowEmpty' => true,
            )));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}