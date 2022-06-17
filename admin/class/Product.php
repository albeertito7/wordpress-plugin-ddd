<?php

/**
 * Class Product
 */
class Product
{
    // properties
    var $id;
    var $blog_id;
    var $name;
    var $short_description;
    var $description;
    var $base_price;
    var $img_url;

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
        $instance->name = $row->name;
        $instance->short_description = $row->short_description;
        $instance->description = $row->description;
        $instance->base_price = $row->base_price;
        $instance->img_url = $row->img_url;
        return $instance;
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
    public function getBasePrice()
    {
        return $this->base_price;
    }

    /**
     * @return mixed
     */
    public function getImgUrl()
    {
        return $this->img_url;
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
     * @param mixed $base_price
     */
    public function setBasePrice($base_price)
    {
        $this->base_price = $base_price;
    }

    /**
     * @param mixed $img_url
     */
    public function setImgUrl($img_url)
    {
        $this->img_url = $img_url;
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