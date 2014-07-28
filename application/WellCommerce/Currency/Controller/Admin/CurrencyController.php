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
namespace WellCommerce\Currency\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Controller\Admin\AbstractAdminController;
use WellCommerce\Currency\Repository\CurrencyRepositoryInterface;

/**
 * Class CurrencyController
 *
 * @package WellCommerce\Currency\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyController extends AbstractAdminController
{
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('currency.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('currency.form'), null, [
            'name' => 'currency'
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

        $form = $this->createForm($this->get('currency.form'), $model, [
            'name' => 'currency'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage('Changes saved successfully.');

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'currency' => $model,
            'form'    => $form
        ];
    }

    /**
     * Sets currency repository object
     *
     * @param CurrencyRepositoryInterface $repository
     */
    public function setRepository(CurrencyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}