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

namespace WellCommerce\Bundle\CoreBundle\Form\Request;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestHandler
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class RequestHandler implements RequestHandlerInterface
{

    public function handleRequest(Request $request)
    {
        print_r($request);
        die();
    }
} 