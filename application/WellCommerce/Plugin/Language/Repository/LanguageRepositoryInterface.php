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

namespace WellCommerce\Plugin\Language\Repository;

/**
 * Interface LanguageRepositoryInterface
 *
 * @package WellCommerce\Plugin\Language\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LanguageRepositoryInterface
{
    const POST_DELETE_EVENT = 'language.repository.post_delete';
    const PRE_SAVE_EVENT    = 'language.repository.pre_save';
    const POST_SAVE_EVENT   = 'language.repository.post_save';

    /**
     * Returns all languages as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a language model
     *
     * @param $id
     *
     * @return \WellCommerce\Plugin\Language\Model\Language
     */
    public function find($id);

    /**
     * Adds or updates a language
     *
     * @param array $data
     * @param null  $id
     *
     * @return mixed
     */
    public function save(array $data, $id = null);

    /**
     * Deletes a language
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Returns Collection as ke-value pairs ready to use in selects
     *
     * @return mixed
     */
    public function getAllLanguageToSelect();
}