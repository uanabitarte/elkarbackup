<?php 

namespace Binovo\ElkarBackupBundle\Service;
use Doctrine\ORM\EntityManager;
use Binovo\ElkarBackupBundle\Entity\Settings;

class SettingsService extends Settings {
    public function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
        $this->settings = new Settings();
        $this->settings = $this->em
            ->getRepository(Settings::class)
            ->find(1);
        if ($this->settings == null){
            $this->settings = new Settings();
        }
        
        # Import Settings to this object
        $this->import($this->settings);
    }
    
    private function import(Settings $settings)
    {
        foreach (get_object_vars($settings) as $key => $value) {
            $this->$key = $value;
        }
    }
}