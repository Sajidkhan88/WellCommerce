<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Shop\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Controller\Admin\AbstractAdminController;
use WellCommerce\Shop\Repository\ShopRepositoryInterface;

/**
 * Class ShopController
 *
 * @package WellCommerce\Shop\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopController extends AbstractAdminController
{
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('shop.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('shop.form'), null, [
            'name' => 'shop'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat());
                $this->addSuccessMessage('Changes saved successfully.');

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'form' => $form
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function editAction($id)
    {
        $model = $this->repository->find($id);

        $form = $this->createForm($this->get('shop.form'), $model, [
            'name' => 'shop'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage(sprintf('Shop %s saved successfully.', $model->translation->first()->name));

                if ($form->isAction('continue')) {
                    return $this->redirect($this->generateUrl('admin.shop.edit', ['id' => $model->id]));
                }

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'shop' => $model,
            'form'    => $form
        ];
    }

    /**
     * Sets shop repository object
     *
     * @param ShopRepositoryInterface $repository
     */
    public function setRepository(ShopRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}