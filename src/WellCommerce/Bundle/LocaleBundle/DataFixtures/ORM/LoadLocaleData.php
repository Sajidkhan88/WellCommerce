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

namespace WellCommerce\Bundle\LocaleBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\LocaleBundle\Entity\Locale;

/**
 * Class LoadLocaleData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadLocaleData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $en = new Locale();
        $en->setCode('en');
        $en->setCurrency($this->getReference('currency_USD'));
        $manager->persist($en);
        $manager->flush();

        $this->setReference('locale_en', $en);
    }
}
