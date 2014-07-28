<?php

namespace NS\AceBundle\Form;

use IntlDateFormatter;
use NS\AceBundle\Service\DateFormatConverter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of DateRangeType
 *
 * @author gnat
 */
class DateRangeType extends AbstractType
{
    protected $converter;
    
    public function __construct(DateFormatConverter $converter)
    {
        $this->converter = $converter;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'widget'      => 'single_text',
            'compound'    => false,
            'format' => $this->converter->getFormat(true),
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        if(isset($view->vars['attr']['class']))
            $view->vars['attr']['class'] .= 'form-control date-range';
        else
            $view->vars['attr']['class'] = 'form-control date-range';

        $view->vars['type'] = 'text';
        
        $view->vars['attr']['data-date-format'] = strtolower($options['format']);
        $view->vars['attr']['placeholder'] = $options['format'];
    }
    
    public function getName()
    {
        return 'acedaterange';
    }
    
    public function getParent()
    {
        return 'date';
    }
}