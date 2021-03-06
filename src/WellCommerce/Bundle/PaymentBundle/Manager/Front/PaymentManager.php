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

namespace WellCommerce\Bundle\PaymentBundle\Manager\Front;

use WellCommerce\Bundle\AppBundle\Exception\OrderNotFoundException;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Repository\OrderRepositoryInterface;

/**
 * Class PaymentManager
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentManager extends AbstractFrontManager implements PaymentManagerInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function setOrderRepository(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findOrder()
    {
        $id    = $this->getRequestHelper()->getSessionAttribute('orderId');
        $order = $this->orderRepository->find($id);

        if (null === $order) {
            throw new OrderNotFoundException($id);
        }

        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function registerPayment(OrderInterface $order)
    {
        $payment = $this->repository->findOneBy(['order' => $order]);
        if (null === $payment) {
            $this->createPayment($order);
        }
    }

    /**
     * Creates a payment for order
     *
     * @param OrderInterface $order
     */
    protected function createPayment(OrderInterface $order)
    {
        $payment = $this->getFactory()->create();
        $payment->setOrder($order);
        $this->createResource($payment);
    }
}
