<?php

namespace NS\AceBundle\Form;

use \Symfony\Component\Form\AbstractType;
use \Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\OptionsResolver\OptionsResolverInterface;
use \Symfony\Component\Form\FormView;
use \Symfony\Component\Form\FormInterface;
use \NS\AceBundle\Form\Transformer\EntityOrCreate;

/**
 * Description of EntityOrCreateType
 *
 * @author gnat
 */
class EntityOrCreateType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityOptions = isset($options['entity_options']) ?
            array_merge($options['entity_options'], array('class' => $options['class'])) : array('class' => $options['class']);

        $builder->add('finder', 'autocompleter', $entityOptions);

        if ($options['include_form']) {
            $builder->add('createForm', $options['type'], isset($options['create_options']) ? $options['create_options'] : array());
        }

        $builder->addModelTransformer(new EntityOrCreate());
    }

    /**
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['include_button'] = $options['include_button'];
        $view->vars['include_form']   = $options['include_form'];

        if (isset($options['modal_size'])) {
            $view->vars['modal_size'] = sprintf("modal-%d", $options['modal_size']);
        }
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('class', 'type'));
        $resolver->setOptional(array('entity_options', 'create_options', 'modal_size'));
        $resolver->setDefaults(array(
            'include_button' => true,
            'include_form'   => true
        ));
        $resolver->setAllowedValues(array('modal_size' => array(1, 2, 3, 4, 5, 6,
                7, 8, 9, 10, 11, 12)));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'entity_create';
    }
}