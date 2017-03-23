<?php
/**
 *  Upload.php
 *
 *  @author     {$author}
 *  @package    Sample
 */

/**
 *  upload view implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_View_Upload extends Sample_ViewClass
{
    /**
     *  preprocess before forwarding.
     *
     *  @access public
     */
    public function preforward()
    {
        // sessionからユーザー名とイベント名を取得しtplに渡す
        //$this->af->setApp('username', $this->session->get('username'));
        //$this->af->setApp('eventname', $this->session->get('eventname'));

        $this->af->setApp('userid', $_POST["user_id"]);
        $this->af->setApp('username', $_POST["user_name"]);
        
        $this->af->setApp('eventid', $_POST["event_id"]);
        $this->af->setApp('eventname', $_POST["event_name"]);
    }
}

