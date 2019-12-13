<?php
/**
 * @copyright 2012,2013 Binovo it Human Project, S.L.
 * @license http://www.opensource.org/licenses/bsd-license.php New-BSD
 */

namespace Binovo\ElkarBackupBundle\Form\Type;

use Binovo\ElkarBackupBundle\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SettingsType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
          'data_class' => Settings::class,
          'translator' => null,
        ]);
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $t = $options['translator'];
        
        $builder
            ->add('maxLogAge', DateIntervalType::class, [
                'label' => 'Remove logs older than',
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'input' => 'dateinterval'])
            /*
            ->add('maxLogAge', TextType::class, [
                'label' => 'Remove logs older than',
                'attr'  => ['class' => 'form-control'],
                'required' => false])
            */
            ->add('warningLoadLevel', PercentType::class, [
                'label' => 'Quota warning level',
                'attr' => array('class' => 'form-control')])
            ->add('paginationLinesPerPage', IntegerType::class, [
                'label' => 'Records per page',
                'attr' => array('class' => 'form-control')])
            ->add('urlPrefix', TextType::class, [
                'label' => 'URL prefix',
                'attr' => array('class' => 'form-control'),
                'required' => false])
            ->add('disableBackground', CheckboxType::class, [
                'label' => 'Disable login background',
                'required' => false])
            ->add('uploadDir', TextType::class, [
                'label' => 'Scripts directory',
                'attr' => array('class' => 'form-control'),
                'required' => false])
            ->add('publicKey', TextType::class, [
                'label' => 'Public key path',
                'attr' => array('class' => 'form-control')])
            ->add('maxParallelJobs', IntegerType::class, [
                'label' => 'Max parallel jobs',
                'attr' => array('class' => 'form-control')])
            ->add('postOnPreFail', CheckboxType::class, [
                'label' => 'Do post script on pre script failure',
                'required' => false]);
            //->add('save', SubmitType::class, ['label' => 'Save']);

        $builder->get('maxLogAge')
            ->addModelTransformer(new CallbackTransformer(
                // Transform string to DateInterval
                function ($value) {
                    return new \DateInterval($value);
                },
                // Transform from DateInterval to string
                function ($value) {
                    if (null === $value) {
                        return '';
                    }
                    
                    if (!$value instanceof \DateInterval) {
                        throw new UnexpectedTypeException($value, '\DateInterval');
                    }
                    
                    return $value->format('P%yY%mM%dD');
                }
        ));
    }

    public function getName()
    {
        return 'Settings';
    }
}
