<?php

/**
 * Class EntitiesController (Packages)
 */
class EntitiesCommentsController extends MasterController
{
    private CommentRepository $commentRepository;

    public function __construct()
    {
        $this->commentRepository = CommentRepository::getInstance();

        add_action('wp_ajax_entities_comments_controller', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_entities_comments_controller', array($this, 'ajax'));
    }

    public function ajax()
    {
        if (isset($_POST['type'])) {

            $action = $_POST['type'];

            switch ($action) {
                case "getComments":
                    echo $this->getComments(true);
                    break;
                case "addComment":
                    echo $this->addComment();
                    break;
                case "deleteComment":
                    echo $this->deleteComment($_POST['id']);
                    break;
                default:
                    parent::ajax();
                    break;
            }
        }

        exit;
    }

    /**
     * @param bool $json_encode
     * @return array|false|string
     */
    public function getComments(bool $json_encode=false) {

        $comments = array();

        try {
            $comments = $this->commentRepository->findAll();
        }
        catch (Exception $e) {

        }

        if($json_encode) {
            header('Content-type: application/json');
            return json_encode($comments);
        }

        return $comments;
    }

    /**
     * @return false|string
     */
    public function addComment() {

        $response = array('success'=> false);

        // creation package object
        $comment = new Comment();
        $comment->setAuthor($_POST['author']);
        $comment->setEmail($_POST['email']);
        $comment->setMessage($_POST['message']);
        $comment->setPhone($_POST['phone']);

        $result = $this->commentRepository->add($comment);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);

    }

    /**
     * @return void
     */
    public function deleteComment($id) {

        $response = array(
            'success' => false
        );

        $comment = new Package();
        $comment->setId($id);

        $result = $this->commentRepository->remove($comment);
        if ( $result ) {
            $response['success'] = true;
        }

        header('Content-type: application/json');
        return json_encode($response);

    }
}

new EntitiesCommentsController();