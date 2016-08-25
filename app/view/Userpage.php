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
        include('adodb/adodb.inc.php');

        // sessionからユーザー名を取得
	$this->af->setApp('username', $this->session->get('username'));
        
        // DB接続
        $db = $this->backend->getDB();

        // すべてのイベントを取得
        $allevent = $db->GetRow("SELECT eventname FROM eventauth");

        // データを取得できたか確認
        if ($allevent === false){
            $this->af->setApp('dbNotConection','true');
            $this->af->setApp('allevent', null);
        }
        else{
            $this->af->setApp('allevent', $allevent);
        }
        
    }
}

