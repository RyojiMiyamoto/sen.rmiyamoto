<?php
/**
 *  Userpage.php
 *
 *  @author     {$author}
 *  @package    Sample
 */

/**
 *  userpage view implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_View_Userpage extends Sample_ViewClass
{
    /**
     *  preprocess before forwarding.
     *
     *  @access public
     */
    public function preforward()
    {
	$this->af->setApp('username', $this->session->get('username'));
    }
}

