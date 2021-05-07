<?php
namespace App\Api\Test;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;

class BaseApiTestCase extends ApiTestCase
{
    const UNEXISTING_ID = 726358291635;

    protected function assertHydraError(string $description = null): void
    {
        if(isset($description)){
            $this->assertJsonContains([
                '@context' => '/api/contexts/Error',
                '@type' => 'hydra:Error',
                'hydra:title' => 'An error occurred',
                'hydra:description' => $description,
            ]);
        } else {
            $this->assertJsonContains([
                '@context' => '/api/contexts/Error',
                '@type' => 'hydra:Error',
                'hydra:title' => 'An error occurred'
            ]);
        }
    }

    protected function authenticate(): Client
    {
        return static::createClient([], [
            'auth_basic' => ['root', 'root'],
            'base_uri' => 'http://127.0.0.1'
        ]);
    }

    protected function createClientName(): string
    {
        $time = new \DateTime();
        $clientName = 'client_'.$time->getTimestamp().rand(1000, 9999);
        return $clientName;
    }
}

