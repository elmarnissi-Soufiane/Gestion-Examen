<?php

namespace App\Factory;

use App\Entity\Module;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Module>
 */
final class ModuleFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    public static function class(): string
    {
        return Module::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            // 'enseignant' => null, // TODO add App\Entity\enseignant type manually
            // 'filiere' => null, // TODO add App\Entity\filiere type manually
            'nom' => self::faker()->realText(255),
            'filiere' => FiliereFactory::randomOrCreate(),
            'enseignant' => EnseignantFactory::randomOrCreate(),
            'semestre' => SemestreFactory::randomOrCreate(),
            // 'semestre' => null, // TODO add App\Entity\semestre type manually
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Module $module): void {})
        ;
    }
}
