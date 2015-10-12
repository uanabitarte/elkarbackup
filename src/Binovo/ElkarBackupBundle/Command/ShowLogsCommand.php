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
             ->setDescription('Show logs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	$id = null;
	$encoders = array(new XmlEncoder(), new JsonEncoder());
	$normalizers = array(new GetSetMethodNormalizer());
	$serializer = new Serializer($normalizers, $encoders);
	$repository = $this->getContainer()->get('doctrine')
                ->getRepository('BinovoElkarBackupBundle:LogRecord');
	$queryBuilder = $repository->createQueryBuilder('l')
                ->addOrderBy('l.id', 'DESC');
	$queryParamCounter = 1;
	//$query = $queryBuilder->getQuery();/
	while(1){
	  //$repository = $this->getContainer()->get('doctrine')
	  //	->getRepository('BinovoElkarBackupBundle:LogRecord');
	  //$queryBuilder = $repository->createQueryBuilder('l')
	  //	->addOrderBy('l.id', 'DESC');
	  //$queryParamCounter = 1;
	  //$queryBuilder->where("1 = 1");
	  $query = $queryBuilder->getQuery();
	  $logrecord = $query->setMaxResults(1)->getOneOrNullResult();
	  if ($logrecord->getId() != $id){
	    $json = $serializer->serialize($logrecord, 'json');
	    echo "$json\n";
	    $id = $logrecord->getId();
	    usleep(500000); 
	  }
	}
    }
}
