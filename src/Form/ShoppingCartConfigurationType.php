<?php

declare(strict_types=1);

namespace Oksydan\IsShoppingcart\Form;

use Oksydan\IsShoppingcart\Configuration\ShoppingCartConfiguration;
use PrestaShopBundle\Form\Admin\Type\MultistoreConfigurationType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\FormBuilderInterface;

class ShoppingCartConfigurationType extends TranslatorAwareType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ajaxCartEnabled', SwitchType::class, [
                'label' => $this->trans('Ajax cart', 'Modules.Isshoppingcart.Admin'),
                'help' => $this->trans('Activate Ajax mode for the cart.', 'Modules.Isshoppingcart.Admin'),
                'multistore_configuration_key' => ShoppingCartConfiguration::IS_BLOCK_CART_AJAX,
            ]);
    }

    /**
     * {@inheritdoc}
     *
     * @see MultistoreConfigurationTypeExtension
     */
    public function getParent(): string
    {
        return MultistoreConfigurationType::class;
    }
}
