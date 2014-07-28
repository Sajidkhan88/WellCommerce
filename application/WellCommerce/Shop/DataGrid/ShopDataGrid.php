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
namespace WellCommerce\Shop\DataGrid;

use Illuminate\Database\Capsule\Manager;
use WellCommerce\Core\DataGrid\AbstractDataGrid;
use WellCommerce\Core\DataGrid\Column\Column;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\DataGrid\Column\DataGridColumn;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class ShopDataGrid
 *
 * @package WellCommerce\Shop\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(array $options)
    {
        $event_handlers = [
            'update_row' => $this->getXajaxManager()->registerFunction([
                    'update_' . $this->getId(),
                    $this,
                    'updateRow'
                ]),
        ];

        $options['event_handlers'] = $event_handlers;

        $options['filters'] = [
            'layout_theme_id' => $this->get('layout_theme.repository')->getAllLayoutThemeToFilter(),
            'offline'         => $this->getOfflineFilterOptions()
        ];


        return parent::configureOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addColumns()
    {
        $this->columns->add(new Column([
            'id'         => 'id',
            'source'     => 'shop.id',
            'caption'    => $this->trans('Id'),
            'sorting'    => [
                'default_order' => ColumnInterface::SORT_DIR_DESC
            ],
            'appearance' => [
                'width'   => 90,
                'visible' => false
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));

        $this->columns->add(new Column([
            'id'         => 'name',
            'source'     => 'shop_translation.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 570,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $this->columns->add(new Column([
            'id'         => 'url',
            'source'     => 'shop.url',
            'caption'    => $this->trans('Url address'),
            'appearance' => [
                'width' => 570,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $this->columns->add(new Column([
            'id'         => 'layout_theme_id',
            'source'     => 'shop.layout_theme_id',
            'caption'    => $this->trans('Theme'),
            'selectable' => true,
            'appearance' => [
                'width' => 70,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_SELECT
            ]
        ]));

        $this->columns->add(new Column([
            'id'         => 'offline',
            'source'     => 'shop.offline',
            'caption'    => $this->trans('Offline mode'),
            'selectable' => true,
            'appearance' => [
                'width' => 70,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_SELECT
            ]
        ]));
    }

    /**
     * Returns options for offline filter
     *
     * @return array
     */
    private function getOfflineFilterOptions()
    {
        $options   = [];
        $options[] = [
            'id'      => 0,
            'caption' => $this->trans('Offline'),
        ];
        $options[] = [
            'id'      => 1,
            'caption' => $this->trans('Online'),
        ];

        return $options;
    }
}