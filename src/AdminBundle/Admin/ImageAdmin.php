<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ImageAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('orginName')
            ->add('name')
            ->add('gallery')
            ->add('created')
            ->add('updated')
            ->add('position')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('filename', null, ['label' => 'Image', 'template' => 'AdminBundle:Default:_image_list_thumb.html.twig'])
            ->add('orginName')
            ->add('name')
            ->add('gallery')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', 'file', ['required' => false])
            ->add('orginName', null, ['help' => 'If you leave this field empty, admin save name orginal file name'])
            ->add('name')
            ->add('gallery', 'sonata_type_model', ['placeholder' => 'No gallery selected', 'required' => false])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('filename', null, ['label' => 'Image', 'template' => 'AdminBundle:Default:_image_show_thumb.html.twig'])
            ->add('orginName')
            ->add('name')
            ->add('gallery')
            ->add('created')
            ->add('updated')
            ->add('position')
        ;
    }
}
