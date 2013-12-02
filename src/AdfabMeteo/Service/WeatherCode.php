<?php

namespace AdfabMeteo\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcBase\EventManager\EventProvider;
use AdfabMeteo\Entity\WeatherCode as WeatherCodeEntity;
use PlaygroundCore\Filter\Slugify;

class WeatherCode extends EventProvider implements ServiceManagerAwareInterface
{
    /**
     * @var WeatherCodeMapper
     */
    protected $weatherCodeMapper;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function create(array $data)
    {
        $weatherCode = new WeatherCodeEntity();
        $this->getWeatherCodeMapper()->insert($weatherCode);
        $this->update($weatherCode->getId(), $data);
    }

    public function update($codeId, array $data)
    {
        $code = $this->getWeatherCodeMapper()->findById($codeId);
        $code->populate($data);
        $associatedCode = null;
        // handle association with an other code
        if (isset($data['associatedCode'])) {
            $associatedCode = $this->getWeatherCodeMapper()->findById($data['associatedCode']);
        }

        // Handle Icon loading
        $path = $this->getOptions()->getMediaPath() . DIRECTORY_SEPARATOR;
        $media_url = $this->getOptions()->getMediaUrl() . '/';

        if (!empty($data['icon']['tmp_name'])) {
            if ($code->getIconURL()) {
                unlink($code->getIconURL());
            }
            ErrorHandler::start();
            $data['icon']['name'] = $path . $codeId . "-" . Slugify::filter($data['icon']['name']);
            move_uploaded_file($data['icon']['tmp_name'], $path . $data['icon']['name']);
            $code->setIconURl($media_url . $data['icon']['name']);
            ErrorHandler::stop(true);
        }
        $code->setAssociatedCode($associatedCode);
        $this->getWeatherCodeMapper()->update($code);

        return $code;
    }

    public function getWeatherCodeMapper()
    {
        if (null === $this->weatherCodeMapper) {
            $this->weatherCodeMapper = $this->getServiceManager()->get('adfabmeteo_weathercode_mapper');
        }
        return $this->weatherCodeMapper;
    }

    public function setWeatherCodeMapper(WeatherCodeMapper $weatherCodeMapper)
    {
        $this->weatherCodeMapper = $weatherCodeMapper;
        return $this;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceManager()->get('adfabmeteo_module_options'));
        }
        return $this->options;
    }
}