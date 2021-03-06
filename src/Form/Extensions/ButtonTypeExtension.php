<?php

namespace NS\AceBundle\Form\Extensions;

use \Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use \Symfony\Component\Form\FormInterface;
use \Symfony\Component\Form\FormView;
use \Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ButtonTypeExtension
 *
 * @author gnat
 */
class ButtonTypeExtension extends AbstractTypeExtension
{
    /**
     * @return string
     */
    public function getExtendedType()
    {
        return ButtonType::class;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(['icon', 'type']);
        $resolver->setAllowedTypes('icon','string');
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['icon'])) {
            $view->vars['icon'] = $options['icon'];
        }
    }
}
