<?php

/**
 * Class Product
 *
 * Don't echo or die in classes, as it takes options away from the calling classes
 * (they can't change the output, they can't recover from errors, etc).
 */
class Product
{
    // properties
    var $id;
    var $blog_id;
    var $author_id;
    var $date_created;
    var $date_modified;
    var $status;
    var $name;
    var $short_description;
    var $description;
    var $price;
    var $featured_image;
    var $custom_order;
    var $observations;

    /**
     * Product constructor.
     */
    private function __construct()
    {
        // pass
    }

    /**
     * @param $row
     * @return Product
     */
    public static function withRow($row)
    {
        $instance = new self();
        $instance->id = $row->id;
        $instance->blog_id = $row->blog_id;
        $instance->date_created = $row->date_created;
        $instance->date_modified = $row->date_modified;
        $instance->status = $row->status;

        $instance->name = $row->name;
        $instance->short_description = $row->short_description;
        $instance->description = $row->description;
        $instance->price = $row->price;
        $instance->featured_image = $row->featured_image;
        $instance->custom_order = $row->custom_order;
        $instance->observations = $row->observations;
        return $instance;
    }

    /**
     * @return mixed
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @param mixed $observations
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;
    }

    /**
     * @return mixed
     */
    public function getCustomOrder()
    {
        return $this->custom_order;
    }

    /**
     * @param mixed $order
     */
    public function setCustomOrder($custom_order)
    {
        $this->custom_order = $custom_order;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getBlogId()
    {
        return $this->blog_id;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @return mixed
     */
    public function getDateModified()
    {
        return $this->date_modified;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getShortDescription()
    {
        return $this->short_description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getFeaturedImage()
    {
        return $this->featured_image;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $blog_id
     */
    public function setBlogId($blog_id)
    {
        $this->blog_id = $blog_id;
    }

    /**
     * @param mixed $author_id
     */
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
    }

    /**
     * @param mixed $date_created
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    /**
     * @param mixed $date_modified
     */
    public function setDateModified($date_modified)
    {
        $this->date_modified = $date_modified;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $short_description
     */
    public function setShortDescription($short_description)
    {
        $this->short_description = $short_description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param mixed $featured_image_url
     */
    public function setFeaturedImage($featured_image)
    {
        $this->featured_image = $featured_image;
    }

    /*
    public function toArray() {
        return array(
            'id' => $this->id,
            'blog_id' => $this->blog_id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'img_url' => $this->img_url
        );
    }*/
}