<?php
namespace App\Api\DataProviders;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Script;
use App\Service\LoggerService;
use App\Service\RouterService;
use Doctrine\ORM\EntityManagerInterface;

class ScriptCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $collectionExtensions;
    private $entityManager;
    private $logger;
    private $router;
    /**
     * Constructor
     */
    public function __construct(EntityManagerInterface $entityManager, LoggerService $logger, RouterService $router, iterable $collectionExtensions)
    {
        $this->collectionExtensions = $collectionExtensions;
        $this->entityManager        = $entityManager;
        $this->logger               = $logger;
        $this->router               = $router;
        
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $repository = $this->entityManager->getRepository('App:Script');
        $query = $repository->createQueryBuilder('c')->addOrderBy('c.id', 'ASC');
        $queryNameGenerator = new QueryNameGenerator();
        
        foreach ($this->collectionExtensions as $extension) {
            $extension->applyToCollection($query, $queryNameGenerator, $resourceClass, $operationName);
            if ($extension instanceof QueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass,$operationName)) {
                return $extension->getResult($query, $resourceClass, $operationName);
            }
        }
        $this->logger->debug(
            'View scripts',
            array(),
            array('link' => $this->router->generateUrl('showScripts'))
            );
        $this->entityManager->flush();
        
        return $query->getQuery()->getResult(); 
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Script::class === $resourceClass;
    }
}

