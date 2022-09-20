<?php

namespace Entities\Services;

/**
 * Interface ProductDao
 *
 * Simple interface that provides Collection CRUD operations for the Product domain,
 * simply abstracting the domain logic used, from any particular persistence mechanism or APIs.
 */
interface ProductRepository
{
    public function add($product);
    public function remove($product);
    public function update($product);
    public function findAll();
    public function findById($id);
    public function size();
    public function isEmpty();
    public function generateId();
}
