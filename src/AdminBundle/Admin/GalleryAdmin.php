<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class GalleryAdmin extends AbstractAdmin {

    public $last_position = 0;
    
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    );
    
    public function setPositionService(\Pix\SortableBehaviorBundle\Services\PositionHandler $positionHandler)
    {
        $this->positionService = $positionHandler;
    }

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection)
    {
        $collection->add('move', $this->getRouterIdParameter().'/move/{position}');
    }

    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('name')
                ->add('created')
                ->add('updated')
                ->add('position')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $this->last_position = $this->positionService->getLastPosition($this->getRoot()->getClass());
        
        $listMapper
                ->add('id')
                ->add('name')
                ->add('created')
                ->add('updated')
                ->add('_action', null, array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                        'move' => array(
                            'template' => 'AdminBundle:Default:_sort.html.twig'
                        ),
                    )
                ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('name')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('name')
                ->add('position')
                ->add('created')
                ->add('updated')
        ;
    }

}
