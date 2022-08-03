<?php

/**
 * Class Comment
 */
class Comment
{
    var $id;
    var $blog_id;
    var $date_created;
    var $author; // full name
    var $email;
    var $phone;
    var $message;

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        // pass
    }

    /**
     * @param $row
     * @return Comment
     */
    public static function withRow($row): Comment
    {
        $instance = new self();
        $instance->id = $row->id;
        $instance->blog_id = $row->blog_id;
        $instance->date_created = $row->date_created;
        $instance->email = $row->email;
        $instance->phone = $row->phone;
        $instance->message = $row->message;

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
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBlogId()
    {
        return $this->blog_id;
    }

    /**
     * @param mixed $blog_id
     */
    public function setBlogId($blog_id): void
    {
        $this->blog_id = $blog_id;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param mixed $date_created
     */
    public function setDateCreated($date_created): void
    {
        $this->date_created = $date_created;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * Email validation.
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     *
     * Phone validation.
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

}