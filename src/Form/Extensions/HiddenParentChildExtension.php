<?php
/**
 * Created by PhpStorm.
 * User: gnat
 * Date: 23/08/16
 * Time: 2:35 PM
 */

namespace NS\AceBundle\Form\Extensions;


use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HiddenParentChildExtension extends AbstractTypeExtension
{
    /**
     * @inheritDoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = (in_array('checkbox', $view->vars['block_prefixes'])) ? 'label_attr' : 'attr';

        if (isset($options['hidden-parent'])) {
            $view->vars[$attr]['data-context-parent'] = $options['hidden-parent'];
        }

        if (isset($options['hidden-value'])) {
            $view->vars[$attr]['data-context-value'] = (is_array($options['hidden-value'])? json_encode($options['hidden-value']):$options['hidden-value']);
        }

        if (isset($options['hidden-child'])) {
            $view->vars['attr']['data-context-child'] = $options['hidden-child'];
        }

        if (isset($options['hidden'])) {
            if (isset($options['hidden']['parent'])) {
                $view->vars[$attr]['data-context-parent'] = $options['hidden']['parent'];
            }

            if (isset($options['hidden']['child'])) {
                $view->vars[$attr]['data-context-child'] = $options['hidden']['child'];
            }

            if (isset($options['hidden']['value'])) {
                $view->vars[$attr]['data-context-value'] = (is_array($options['hidden']['value'])? json_encode($options['hidden']['value']):$options['hidden']['value']);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if (!$form->getParent()) {
            $hidden = [];
            foreach($form as $childName => $child) {
                $hiddenConfig = $child->getConfig()->getOption('hidden');

                if ($hiddenConfig !== null && isset($hiddenConfig['parent']) && isset($view[$hiddenConfig['parent']])) {
                    $parentName = $view[$hiddenConfig['parent']]->vars['full_name'];
                    $childName = $view[$childName]->vars['full_name'];
                    $hidden[$childName][$parentName] = ['values' => (array)$hiddenConfig['value']];
                }
            }

            $view->vars['attr'] = (isset($view->vars['attr'])) ? array_merge($view->vars['attr'],['data-context-config'=>json_encode($hidden)]):['data-context-config'=>json_encode($hidden)];
        }
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(['hidden-parent', 'hidden-child', 'hidden-value', 'hidden']);
        $resolver->setAllowedTypes('hidden', 'array');
    }

    /**
     * @inheritDoc
     */
    public function getExtendedType()
    {
        return FormType::class;
    }
}

