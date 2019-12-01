<?php

namespace Binovo\ElkarBackupBundle\Form\Type;

use Binovo\ElkarBackupBundle\Form\Model\ChangePasswordModel;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;



class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $t = $options['translator'];
        $builder->add('oldPassword',
                        PasswordType::class,
                        array(
                            'required' => true,
                            'attr' => array('class' => 'form-control'),
                            'label' => $t->trans('Old password', array(), 'BinovoElkarBackup')
                        )
                    )
                ->add('password',
                        RepeatedType::class,
                        array(
                            'type' => PasswordType::class,
                            'required' => true,
                            'attr' => array('class' => 'password-field form-control'),
                            'first_options' => array('label' => $t->trans('New password', array(), 'BinovoElkarBackup'), 'attr' => array('class' => 'form-control')),
                            'second_options' => array('label' => $t->trans('Confirm new password', array(), 'BinovoElkarBackup'), 'attr' => array('class' => 'form-control')),
                            'invalid_message' => $t->trans('The new password fields must match.')
                        )
                    );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => ChangePasswordModel::class,
          'translator' => null,
          'csrf_token_id' => 'change_password',
        ));
    }
}
