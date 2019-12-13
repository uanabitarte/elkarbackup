<?php 

namespace Binovo\ElkarBackupBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $warningLoadLevel = 0.8;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $paginationLinesPerPage = 20;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $urlPrefix = '';
    
    /**
     * @ORM\Column(type="string")
     * Should be DateInterval, but requires Doctrine > 2.6
     */
    protected $maxLogAge = 'P1Y';
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $disableBackground = false;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $uploadDir = '/var/spool/elkarbackup/uploads';
    
    /**
     * @ORM\Column(type="string")
     */
    protected $publicKey = '/var/lib/elkarbackup/.ssh/id_rsa.pub';
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $tahoeActive = false;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $home = '/var/lib/elkarbackup';
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $maxParallelJobs = 1;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $postOnPreFail = true;
    
    public function setUrlPrefix($urlPrefix)
    {
        $this->urlPrefix = !isset($urlPrefix) ? '': $urlPrefix;
        
        return $this;
    }
    
    public function getUrlPrefix()
    {
        return $this->urlPrefix;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set maxLogAge
     *
     * @param string $maxLogAge
     *
     * @return Settings
     */
    public function setMaxLogAge(string $maxLogAge)
    {
        $this->maxLogAge = $maxLogAge;

        return $this;
    }

    /**
     * Get maxLogAge
     *
     * @return string
     */
    public function getMaxLogAge()
    {
        return $this->maxLogAge;
    }

    /**
     * Set disableBackground
     *
     * @param boolean $disableBackground
     *
     * @return Settings
     */
    public function setDisableBackground($disableBackground)
    {
        $this->disableBackground = $disableBackground;

        return $this;
    }

    /**
     * Get disableBackground
     *
     * @return boolean
     */
    public function getDisableBackground()
    {
        return $this->disableBackground;
    }

    /**
     * Set warningLoadLevel
     *
     * @param float $warningLoadLevel
     *
     * @return Settings
     */
    public function setWarningLoadLevel($warningLoadLevel)
    {
        $this->warningLoadLevel = $warningLoadLevel;

        return $this;
    }

    /**
     * Get warningLoadLevel
     *
     * @return float
     */
    public function getWarningLoadLevel()
    {
        return $this->warningLoadLevel;
    }

    /**
     * Set paginationLinesPerPage
     *
     * @param integer $paginationLinesPerPage
     *
     * @return Settings
     */
    public function setPaginationLinesPerPage($paginationLinesPerPage)
    {
        $this->paginationLinesPerPage = $paginationLinesPerPage;

        return $this;
    }

    /**
     * Get paginationLinesPerPage
     *
     * @return integer
     */
    public function getPaginationLinesPerPage()
    {
        return $this->paginationLinesPerPage;
    }

    /**
     * Set uploadDir
     *
     * @param string $uploadDir
     *
     * @return Settings
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = !isset($uploadDir) ? '/var/spool/elkarbackup/uploads': $uploadDir;

        return $this;
    }

    /**
     * Get uploadDir
     *
     * @return string
     */
    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    /**
     * Set publicKey
     *
     * @param string $publicKey
     *
     * @return Settings
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = !isset($publicKey) ? '/var/lib/elkarbackup/.ssh/id_rsa.pub' : $publicKey;

        return $this;
    }

    /**
     * Get publicKey
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Set tahoeActive
     *
     * @param boolean $tahoeActive
     *
     * @return Settings
     */
    public function setTahoeActive($tahoeActive)
    {
        $this->tahoeActive = $tahoeActive;

        return $this;
    }

    /**
     * Get tahoeActive
     *
     * @return boolean
     */
    public function getTahoeActive()
    {
        return $this->tahoeActive;
    }

    /**
     * Set home
     *
     * @param string $home
     *
     * @return Settings
     */
    public function setHome($home)
    {
        $this->home = $home;

        return $this;
    }

    /**
     * Get home
     *
     * @return string
     */
    public function getHome()
    {
        return $this->home;
    }

    /**
     * Set maxParallelJobs
     *
     * @param integer $maxParallelJobs
     *
     * @return Settings
     */
    public function setMaxParallelJobs($maxParallelJobs)
    {
        $this->maxParallelJobs = $maxParallelJobs;

        return $this;
    }

    /**
     * Get maxParallelJobs
     *
     * @return integer
     */
    public function getMaxParallelJobs()
    {
        return $this->maxParallelJobs;
    }

    /**
     * Set postOnPreFail
     *
     * @param boolean $postOnPreFail
     *
     * @return Settings
     */
    public function setPostOnPreFail($postOnPreFail)
    {
        $this->postOnPreFail = $postOnPreFail;

        return $this;
    }

    /**
     * Get postOnPreFail
     *
     * @return boolean
     */
    public function getPostOnPreFail()
    {
        return $this->postOnPreFail;
    }
}
