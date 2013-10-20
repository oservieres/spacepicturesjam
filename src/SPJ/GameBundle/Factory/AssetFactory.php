<?php
namespace SPJ\GameBundle\Factory;

use Symfony\Bundle\AsseticBundle\Factory\AssetFactory as BaseAssetFactory;
use Assetic\Factory\LazyAssetManager;
use Assetic\Factory\Worker\CacheBustingWorker;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class AssetFactory extends BaseAssetFactory
{
    public function __construct(KernelInterface $kernel, ContainerInterface $container, ParameterBagInterface $parameterBag, $baseDir, $debug = false)
    {
        parent::__construct($kernel, $container, $parameterBag, $baseDir, $debug);
        $this->addWorker(new CacheBustingWorker(new LazyAssetManager(new BaseAssetFactory($kernel, $container, $parameterBag, $baseDir, $debug))));
    }
}
