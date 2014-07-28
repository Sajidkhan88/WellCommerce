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

namespace WellCommerce\Category\Provider;

use WellCommerce\Core\AbstractComponent;
use WellCommerce\Category\Model\Category;

/**
 * Class CategoryProvider
 *
 * @package WellCommerce\Category\Provider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryProvider implements CategoryProviderInterface
{
    /**
     * @var Category
     */
    private $data;

    /**
     * {@inheritdoc}
     */
    public function setCurrent(Category $category)
    {
        $this->data = $category;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrent()
    {
        return $this->data;
    }
} 