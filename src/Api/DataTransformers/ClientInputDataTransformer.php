<?php
namespace App\Api\DataTransformers;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Exception\InvalidArgumentException;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Entity\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use \Exception;

class ClientInputDataTransformer implements DataTransformerInterface
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager        = $em;
    }
    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        if (isset($context[AbstractItemNormalizer::OBJECT_TO_POPULATE])) {
            $client = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
        } else {
            $client = new Client();
        }
        $client->setName($data->getName());
        $client->setUrl($data->getUrl());
        $client->setQuota($data->getQuota());
        $client->setDescription($data->getDescription());
        $client->setIsActive($data->getIsActive());
        $this->setPreScripts($client, $data->getPreScript());
        $this->setPostScripts($client, $data->getPostScript());
        $client->setMaxParallelJobs($data->getMaxParallelJobs());
        $client->setOwner($this->getOwner($data->getOwner()));
        $client->setSshArgs($data->getSshArgs());
        $client->setRsyncShortArgs($data->getRsyncShortArgs());
        $client->setRsyncLongArgs($data->getRsyncLongArgs());
        return $client;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Client) {
            return false;
        }

        return Client::class === $to && null !== ($context['input']['class'] ?? null);
    }

    private function getOwner($id): ?User
    {
        if (null == $id) {
            return null;
        } else {
            $repository = $this->entityManager->getRepository('App:User');
            $query = $repository->createQueryBuilder('c');
            $query->where($query->expr()->eq('c.id', $id));
            if (null == $query->getQuery()->getOneOrNullResult()) {
                throw new InvalidArgumentException ("Incorrect owner id");
            } else {
                return $query->getQuery()->getOneOrNullResult();
            }
        }
    }

    private function setPreScripts($client, $preScripts): void
    {
        $repository = $this->entityManager->getRepository('App:Script');
        $query = $repository->createQueryBuilder('s');
        foreach ($preScripts as $script) {
            $query = $repository->createQueryBuilder('s');
            $query->where($query->expr()->eq('s.id', $script));
            $result = $query->getQuery()->getOneOrNullResult();
            if (null != $result) {
                if ($result->getIsClientPre()) {
                    $client->addPreScript($result);
                }else {
                    throw new InvalidArgumentException(sprintf('Script "%s" is not a client pre script', $result->getId()));
                }
            } else {
                throw new InvalidArgumentException(sprintf('Script "%s" does not exist', $script));
            }
        }
    }

    private function setPostScripts($client, $postScripts): void
    {
        $repository = $this->entityManager->getRepository('App:Script');
        $query = $repository->createQueryBuilder('s');
        foreach ($postScripts as $script) {
            $query = $repository->createQueryBuilder('s');
            $query->where($query->expr()->eq('s.id', $script));
            $result = $query->getQuery()->getOneOrNullResult();
            if (null != $result) {
                if ($result->getIsClientPost()) {
                    $client->addPostScript($result);
                }else {
                    throw new InvalidArgumentException(sprintf('Script "%s" is not a client post script', $result->getId()));
                }
            } else {
                throw new InvalidArgumentException(sprintf('Script "%s" does not exist', $script));
            }
        }
    }
}

