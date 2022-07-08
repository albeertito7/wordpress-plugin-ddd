<?php

/**
 * Interface ProductDao
 *
 * Simple interface that provides CRUD operations for the Product domain
 */
interface ProductDao {

    public function create($product);
    public function read($id);
    public function update($product);
    public function delete($id);

}
