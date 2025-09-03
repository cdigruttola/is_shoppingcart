<?php

declare(strict_types=1);

namespace Oksydan\IsShoppingcart\Controller;

use PrestaShop\PrestaShop\Core\Form\Handler;
use PrestaShopBundle\Controller\Admin\PrestaShopAdminController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IsShoppingCartController extends PrestaShopAdminController
{
    public function index(
        #[Autowire(service: 'oksydan.is_shoppingcart.configuration.form_handler')]
        Handler $form,
    ): Response {
        $configurationForm = $form->getForm();

        return $this->render('@Modules/is_shoppingcart/views/templates/admin/index.html.twig', [
            'translationDomain' => 'Modules.Isshoppingcart.Admin',
            'configurationForm' => $configurationForm->createView(),
            'help_link' => false,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function saveConfiguration(
        Request $request,
        #[Autowire(service: 'oksydan.is_shoppingcart.configuration.form_handler')]
        Handler $formHandler,
    ): Response {
        $redirectResponse = $this->redirectToRoute('is_shoppingcart_controller');

        $form = $formHandler->getForm();
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return $redirectResponse;
        }

        if ($form->isValid()) {
            $data = $form->getData();
            $saveErrors = $formHandler->save($data);

            if (0 === count($saveErrors)) {
                $this->addFlash('success', $this->trans('Successful update.', [], 'Admin.Notifications.Success'));

                return $redirectResponse;
            }
        }

        $formErrors = [];

        foreach ($form->getErrors(true) as $error) {
            $formErrors[] = $error->getMessage();
        }

        $this->addFlashErrors($formErrors);

        return $redirectResponse;
    }
}
