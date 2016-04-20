<?php

namespace DtlRealty\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlRealty\Entity\RealtyFeature as RealtyFeatureEntity;

class RealtyFeature extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {

        parent::__construct('realtyFeature');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtyFeatureEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'builtArea',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Área Construída',
                'class' => 'form-control input-sm decimals',
                'id' => 'realtyFeatureBuiltArea',
                'value' => 0.00,
                'onblur' => 'javascript: calculateArea();'
            ),
            'options' => array(
                'label' => 'Área Construída',
            ),
        ));

        $this->add(array(
            'name' => 'balconyArea',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Edícula',
                'class' => 'form-control input-sm decimals',
                'id' => 'realtyFeatureBalconyArea',
                'value' => 0.00,
                'onblur' => 'javascript: calculateArea();'
            ),
            'options' => array(
                'label' => 'Edícula',
            ),
        ));

        $this->add(array(
            'name' => 'totalArea',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Total',
                'class' => 'form-control input-sm decimals',
                'id' => 'realtyFeatureTotalArea',
                'value' => 0.00,
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Total',
            ),
        ));

        $this->add(array(
            'name' => 'usefulArea',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Área Útil',
                'class' => 'form-control input-sm decimals',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Área Útil',
            ),
        ));

        $this->add(array(
            'name' => 'groundArea',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Terreno Total',
                'class' => 'form-control input-sm decimals',
                'id' => 'realtyFeatureGroundArea',
                'value' => 0.00,
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Terreno',
            ),
        ));

        $this->add(array(
            'name' => 'groundWidth',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Larg. do Terreno',
                'class' => 'form-control input-sm decimals',
                'id' => 'realtyFeatureGroundWidth',
                'value' => 0.00,
                'onblur' => 'javascript: calculateGround();'
            ),
            'options' => array(
                'label' => 'Larg. do Terreno',
            ),
        ));

        $this->add(array(
            'name' => 'groundLength',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Comp. do Terreno',
                'class' => 'form-control input-sm decimals',
                'id' => 'realtyFeatureGroundLength',
                'onblur' => 'javascript: calculateGround();',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Comp. do Terreno',
            ),
        ));

        $this->add(array(
            'name' => 'bedroomAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Dormitórios',
                'class' => 'form-control input-sm',
                'id' => 'realtyFeatureBedroomAmount',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Dormitórios',
            ),
        ));

        $this->add(array(
            'name' => 'roomAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Quartos',
                'class' => 'form-control input-sm',
                'id' => 'realtyFeatureRoomAmount',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Quartos',
            ),
        ));

        $this->add(array(
            'name' => 'suiteAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Suites',
                'class' => 'form-control input-sm',
                'id' => 'realtyFeatureSuiteAmount',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Suites',
            ),
        ));

        $this->add(array(
            'name' => 'bathtubAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Hidromassagem',
                'class' => 'form-control input-sm',
                'id' => 'realtyFeatureBathtubAmount',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Hidromassagem',
            ),
        ));

        $this->add(array(
            'name' => 'bathroomAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Banheiros',
                'class' => 'form-control input-sm',
                'id' => 'realtyFeatureBathroomAmount',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Banheiros',
            ),
        ));

        $this->add(array(
            'name' => 'hallAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Salas',
                'class' => 'form-control input-sm',
                'id' => 'realtyFeatureHallAmount',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Salas',
            ),
        ));

        $this->add(array(
            'name' => 'bathroomStall',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Box no WC',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureBathroomStall',
            ),
        ));

        $this->add(array(
            'name' => 'bathroomCabinet',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Armário no WC',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureBathroomCabinet',
            ),
        ));

        $this->add(array(
            'name' => 'roomCabinet',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Armário nos Quartos',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureRoomCabinet',
            ),
        ));

        $this->add(array(
            'name' => 'restroom',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Lavabo',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureRestroom',
            ),
        ));

        $this->add(array(
            'name' => 'livingRoom',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Sala de Estar',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureLivingRoom',
            ),
        ));

        $this->add(array(
            'name' => 'doubleLiving',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Sala em 2 Ambientes',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureDoubleLiving',
            ),
        ));

        $this->add(array(
            'name' => 'diningRoom',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Sala de Jantar',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureDiningRoom',
            ),
        ));

        $this->add(array(
            'name' => 'tvRoom',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Sala de TV',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureTvRoom',
            ),
        ));

        $this->add(array(
            'name' => 'office',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Escritório',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureOffice',
            ),
        ));

        $this->add(array(
            'name' => 'kitchen',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Cozinha',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureKitchen',
            ),
        ));

        $this->add(array(
            'name' => 'plannedKitchen',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Cozinha Planejada',
            ),
            'attributes' => array(
                'id' => 'realtyFeaturePlannedKitchen',
            ),
        ));

        $this->add(array(
            'name' => 'storeRoom',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Despensa',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureStoreRoom',
            ),
        ));

        $this->add(array(
            'name' => 'serviceArea',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Área de Serviço',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureServiceArea',
            ),
        ));

        $this->add(array(
            'name' => 'storeHouse',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Quarto de Serviço',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureStoreHouse',
            ),
        ));

        $this->add(array(
            'name' => 'liningSlab',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Forro de Laje',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureLiningSlab',
            ),
        ));

        $this->add(array(
            'name' => 'pvcLiner',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Forro de PVC',
            ),
            'attributes' => array(
                'id' => 'realtyFeaturePvcLiner',
            ),
        ));

        $this->add(array(
            'name' => 'planking',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Forro de Madeira',
            ),
            'attributes' => array(
                'id' => 'realtyFeaturePlanking',
            ),
        ));

        $this->add(array(
            'name' => 'finishPlaster',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Acabamento em Gesso',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureFinishPlaster',
            ),
        ));

        $this->add(array(
            'name' => 'gasHeater',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Aquecedor a Gás',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureGasHeater',
            ),
        ));

        $this->add(array(
            'name' => 'solarHeater',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Aquecedor Solar',
            ),
            'attributes' => array(
                'id' => 'realtyFeatureSolarHeater',
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'builtArea' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Porcent(),
                ),
            ),
            'balconyArea' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'totalArea' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'usefulArea' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'groundArea' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'groundWidth' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR')),
                ),
            ),
            'groundLength' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
        );
    }

}
