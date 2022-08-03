<?php

/**
 * Class CommmentRepository
 */
class CommentRepository extends MasterRepository {

    // singleton
    private $instance;

    /**
     * PackageRepository constructor.
     */
    protected function __construct()
    {
        try {
            parent::__construct();
        } catch (Exception $e) {
        }

        $this->table_name= $this->db->prefix . 'entities_comments';
    }

    /**
     * @return CommentRepository
     * Singleton pattern for the Package repository.
     */
    public static function getInstance(): CommentRepository
    {

        if ( isset( $instance ) ) {
            return $instance;
        }

        return new self();
    }

    /**
     * @param $comment
     * @return bool
     */
    public function add($comment): bool
    {
        $result_db = false;

        try {

            $result_db = $this->db->insert($this->table_name, array(
                'blog_id' => $this->current_blog_id,
                'author' => $comment->getAuthor(),
                'email' => $comment->getEmail(),
                'phone' => $comment->getPhone(),
                'message' => $comment->getMessage()
            ));
        }
        catch (Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0; // returning boolean or object created
    }

    public function remove($comment)
    {
        $result_db = false;

        try
        {
            $result_db = $this->db->delete($this->table_name, array(
                'id' => $comment->getId(),
                'blog_id' => $this->current_blog_id
            ));
        }
        catch(Exception $ex) {

        }

        return is_int($result_db) && $result_db > 0;
    }

    public function update($comment)
    {
        // TODO: Implement update() method.
    }

    public function findAll(): array
    {
        $comments = array();

        try
        {
            $sSQL = "SELECT * FROM $this->table_name WHERE blog_id=$this->current_blog_id";
            $result = $this->db->get_results($sSQL);

            foreach($result as $row) {
                $comments[] = Comment::withRow($row);
            }
        }
        catch(Exception $ex) {

        }

        return $comments;
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }
}
