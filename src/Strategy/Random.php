<?php
namespace Metis\Strategy;

final class Random extends AbstractStrategy
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \Metis\Strategy\StrategyInterface::getUri()
     */
    public function getUri($serviceName)
    {
        if (! array_key_exists($serviceName, $this->services)) {
            throw new \InvalidArgumentException("Namespace '$serviceName' not found");
        }

        $list = $this->services[$serviceName];

        return $list[array_rand($list)]['uri'];
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Metis\Strategy\StrategyInterface::setOptions()
     */
    public function setOptions($options)
    {
        // Nothing to do here
    }

}
