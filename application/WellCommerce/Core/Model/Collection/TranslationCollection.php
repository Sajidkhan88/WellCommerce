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
namespace WellCommerce\Core\Model\Collection;

/**
 * Class TranslationCollection
 *
 * @package WellCommerce\Core\Model\Collection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TranslationCollection extends CustomCollection
{
    /**
     * Accessor to get any attribute from translation collection
     *
     * @param $name
     *
     * @return null
     */
    public function __get($name)
    {
        $item = $this->first();

        return isset($item->$name) ? $item->$name : null;
    }
}