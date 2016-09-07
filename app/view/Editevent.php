<?php
/**
 *  Editevent.php
 *
 *  @author     {$author}
 *  @package    Sample
 */

/**
 *  editevent view implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_View_Editevent extends Sample_ViewClass
{
    /**
     *  preprocess before forwarding.
     *
     *  @access public
     */
    public function preforward()
    {
        // sessionからユーザー名を取得
        $this->af->setApp('username', $this->session->get('username'));
    }
}

