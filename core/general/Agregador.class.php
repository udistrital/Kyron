<?php

/**
 * Aggregatable
 *
 * @author Nck Giles http://www.4pmp.com/
 * Modificado del original para ser compatible con SARA
 */
class Agregador
{
    /**
     * Store of aggregated objects
     *
     */
    private $aggregated = array();
    /**
     * Aggregates objects
     *
     * @param string Classname
     */
    protected function aggregate($class)
    {
        // Check an instance of this class has not already been aggregated
        if (array_key_exists($class, $this->aggregated))
        {
            throw new Exception(sprintf("Class already aggregated: %s", $class));
        }
        
        // Add a new instance of the class to the store
        $this->aggregated[$class] = new $class($this);
    }
    
    /**
     * Remove an aggregated object
     *
     * @param string Classname
     */
    protected function deaggregate($class)
    {
        // Check if this class has been aggregated
        if (!array_key_exists($class, $this->aggregated))
        {
            throw new Exception(sprintf("Class not aggregated: %s", $class));
        }
        
        // Remove the instance of the class from the store
        unset($this->aggregated[$class]);
    }
    
    /**
     * Magic method - catch calls to undefined methods
     *
     * @param String method name
     * @param array Arguments
     */
    public function __call($method, $arguments)
    {
        // Loop through the aggregated objects
        foreach ($this->aggregated as $subject)
        {
            // Check each object to see if it defines the method
            if (method_exists($subject, (string) $method))
            {
                // Object defines the requested method, so call it and return the result
                return call_user_func_array(array($subject, (string) $method), $arguments);
            }
        }
        
        throw new Exception(sprintf("Method not found: %s", $method));
    }
    
    /**
     * Magic method - catch "set" calls to undefined properties
     *
     * @param string Property
     * @param mixed Value
     */
    public function __set($property, $value)
    {
        foreach ($this->aggregated as $subject)
        {
            if (property_exists($subject, $property))
            {
                $subject->$property = $value;
                
                return;
            }
        }
    }
    
    /**
     * Magic method - catch "get" calls to undefined properties
     *
     * @param string Property
     */
    public function __get($property)
    {
        foreach ($this->aggregated as $subject)
        {
            if (property_exists($subject, $property))
            {
                return $subject->$property;
            }
        }
    }
    
    /**
     * Magic method - catch "unset" to undefined properties
     *
     * @param string Property
     */
    public function __unset($property)
    {
        foreach ($this->aggregated as $subject)
        {
            if (property_exists($subject, $property))
            {
                unset($subject->$property);
            }
        }
    }
}