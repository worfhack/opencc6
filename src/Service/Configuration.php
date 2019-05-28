<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 18/04/19
 * Time: 17:46
 */

namespace App\Service;


use App\Repository\ConfigurationRepository;

class Configuration
{

    static private $_inst;
    private $conf;
    private $configurationRepository;

    protected function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
        $conf = $this->configurationRepository->findAll();
        foreach ($conf as $c) {
            $this->conf[$c->getName()] = $c->getValue();
        }
    }

    public function get(String $name, $default = '')
    {
        $val = (isset($this->conf[$name]) ? $this->conf[$name] : $default);
        return $val;
    }

    static public function getInstance(ConfigurationRepository $configurationRepository)
    {

        if (!isset(self::$_inst)) {
            self::$_inst = new Configuration($configurationRepository);
        }
        return self::$_inst;
    }
}