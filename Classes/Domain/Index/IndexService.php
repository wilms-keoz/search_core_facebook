<?php
namespace Codappix\SearchCoreFacebook\Domain\Index;

/*
 * Copyright (C) 2018  Daniel Siepmann <coding@daniel-siepmann.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301, USA.
 */

use Codappix\SearchCore\Configuration\ConfigurationContainerInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use Facebook\Facebook;

/**
 * Concrete implementation to index Facebook information.
 */
class IndexService implements IndexServiceInterface
{
    /**
     * @var ConfigurationContainerInterface
     */
    protected $configuration;

    /**
     * @var FrontendInterface
     */
    protected $cache;

    public function __construct(ConfigurationContainerInterface $configuration, CacheManager $cacheManager)
    {
        $this->cache = $cacheManager->getCache('searchcorefacebookApiRequests');
        $this->configuration = $configuration;
    }

    public function getResult(string $accountIdentifier, string $endpoint, array $parameters) : array
    {
        $cacheIdentifier = sha1($endpoint . $accountIdentifier . implode($parameters));
        if (($records = $this->cache->get($cacheIdentifier)) === false) {
            $records = $this->getFacebookInstance($accountIdentifier)
                ->get($endpoint . '?' . http_build_query($parameters))
                ->getGraphEdge()
                ->asArray();

            $this->cache->set($cacheIdentifier, $records);
        }

        return $records;
    }

    protected function getFacebookInstance(string $accountIdentifier) : Facebook
    {
        return new Facebook($this->configuration->get('connections.facebook.' . $accountIdentifier));
    }
}
