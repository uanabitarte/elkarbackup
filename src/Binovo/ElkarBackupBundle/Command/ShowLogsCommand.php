<?php
/**
 * @copyright 2012,2013 Binovo it Human Project, S.L.
 * @license http://www.opensource.org/licenses/bsd-license.php New-BSD
 */

namespace Binovo\ElkarBackupBundle\Command;

use Binovo\ElkarBackupBundle\Lib\LoggingCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


class ShowLogsCommand extends LoggingCommand
{

    protected function getNameForLogs()
    {
        return 'ShowLogs';
    }

    protected function configure()
    {
        parent::configure();
        $this->setName('elkarbackup:logs')
             ->setDescription('Stream logs in JSON format');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	$encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
	$container = $this->getContainer();
	$manager = $container->get('doctrine')->getManager();
	$repository = $manager->getRepository('BinovoElkarBackupBundle:LogRecord');
	$logrecord = $repository->createQueryBuilder('l')
		->orderby('l.id', 'DESC')
		->getQuery()
		->setMaxResults(1)
		->getResult();
	$lastlogid = $logrecord[0]->getId();
	while(true){
	    $logrecord = $repository->createQueryBuilder('l')
		->where('l.id = :lastlogid')
		->setParameter('lastlogid', $lastlogid+1)
		->orderby('l.id', 'DESC')
		->getQuery()
		->setMaxResults(1)
		->getResult();
	    
	    if (count($logrecord) != 0) {
	    	$logrecord = $logrecord[0];
		$json = $serializer->serialize($logrecord, 'json');
		echo "$json\n";
		$lastlogid = $logrecord->getId();
	    }
	    $manager = flush();
	    usleep(500000);
	}	
    }
}
