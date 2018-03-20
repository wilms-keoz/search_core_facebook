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

use Codappix\SearchCore\Configuration\InvalidArgumentException;
use Codappix\SearchCore\Domain\Index\AbstractIndexer;

/**
 * Indexer for search_core to integrate Facebook indexing.
 */
class PostIndexer extends AbstractIndexer
{
    /**
     * @var \Codappix\SearchCoreFacebook\Domain\Index\IndexServiceInterface
     * @inject
     */
    protected $indexService;

    /**
     * @return array|null
     */
    protected function getRecords(int $offset, int $limit)
    {
        // We currently do not work with offsets.
        if ($offset > 0) {
            return null;
        }

        $parameters = [
            'limit' => $this->getLimit(),
        ];

        try {
            $parameters = array_merge(
                $this->configuration->get('indexing.' . $this->identifier . '.parameters'),
                $parameters
            );
        } catch (InvalidArgumentException $e) {
            // Nothing todo
        }

        return $this->indexService->getResult(
            $this->configuration->get('indexing.' . $this->identifier . '.account'),
            $this->configuration->get('indexing.' . $this->identifier . '.endpoint'),
            $parameters
        );
    }

    /**
     * @throws BadMethodCallException
     */
    protected function getRecord(int $identifier) : array
    {
        throw new \BadMethodCallException('Not supported yet.', 1520933404);
    }

    protected function getDocumentName() : string
    {
        return $this->identifier;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function prepareRecord(array &$record)
    {
        if (!isset($record['id'])) {
            throw new \InvalidArgumentException('No "id" available for post.', 1520933234);
        }

        if (isset($record['created_time']) && $record['created_time'] instanceof \DateTime) {
            $record['created_time'] = $record['created_time']->format(\DateTime::ISO8601);
        }

        parent::prepareRecord($record);

        $record['search_identifier'] = $record['id'];
        unset($record['id']);
    }
}
