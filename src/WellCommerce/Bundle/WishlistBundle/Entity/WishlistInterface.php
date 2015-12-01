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

namespace WellCommerce\Bundle\AppBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\ProductAwareInterface;
use WellCommerce\Bundle\AppBundle\Entity\TimestampableInterface;

/**
 * Interface ClientInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface WishlistInterface extends ClientAwareInterface, TimestampableInterface, ProductAwareInterface
{
    /**
     * @return int
     */
    public function getId();
}