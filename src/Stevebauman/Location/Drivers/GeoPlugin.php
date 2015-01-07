<?php

namespace Stevebauman\Location\Drivers;

use Stevebauman\Location\Objects\Location;
use Stevebauman\Location\Drivers\DriverInterface;

class GeoPlugin implements DriverInterface {

    /*
     * Holds the config object
     */
    private $config;

    /*
     * Holds the drivers URL
     */
    private $url;

    public function __construct($config)
    {
        $this->config = $config;
        
        $this->url = $this->config->get('location::drivers.GeoPlugin.url');
    }

    /**
    * Retrive the current user location from GeoPlugin
    *
    * @param string $ip
    */
    public function get($ip)
    {
        
        $location = new Location;
        
        try {
            $contents = unserialize(file_get_contents($this->url.$ip));
            
            $location->ip = $ip;
            
            $location->countryCode = $contents['geoplugin_countryCode'];
            
            $location->countryName = $contents['geoplugin_countryName'];
            
            $location->regionName = $contents['geoplugin_regionName'];
            
            $location->cityName = $contents['geoplugin_city'];
            
            $location->driver = get_class($this);
            
        } catch(\Exception $e){
            $location->error = true;
        }

        return $location;
    }
}