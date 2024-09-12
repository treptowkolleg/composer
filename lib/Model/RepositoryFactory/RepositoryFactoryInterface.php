<?php

namespace Core\Model\RepositoryFactory;

interface RepositoryFactoryInterface
{

    /**
     * @param int|string $id Primärschlüssel des Entity-Objekts.
     */
    public function find($id);

    /**
     * @param array $data Felder und Werte der Suchkriterien.
     */
    public function findOneBy(array $data);

    /**
     * @param array $data Felder und Werte der Suchkriterien.
     * @param array $orderBy Felder und Richtungen nach denen sortiert wird.
     * @param int|null $limit Maximale Anzahl der Datensätze.
     * @param int|null $offset Erster Datensatz.
     */
    public function findBy(array $data, array $orderBy = [], int $limit = null, int $offset = null):array;

    /**
     * @param array $orderBy Felder und Richtungen nach denen sortiert wird.
     * @param int|null $limit Maximale Anzahl der Datensätze.
     * @param int|null $offset Erster Datensatz.
     */
    public function findAll(array $orderBy = [], int $limit = null, int $offset = null ):array;

}
