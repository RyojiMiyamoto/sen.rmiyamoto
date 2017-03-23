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
        $username = $this->session->get('username');

	// ユーザー名をtplに渡してあげる
	$this->af->setApp('username', $username);
        
        // DB接続
        $db = $this->backend->getDB();

        // ユーザーに関連付けされているイベントを取得
        $userLinkEventList = $db->getAll("SELECT eventlist.event_id ,eventlist.event_name FROM linklist JOIN userlist ON linklist.user_id = userlist.user_id JOIN eventlist ON linklist.event_id = eventlist.event_id WHERE user_name = ? ORDER BY eventlist.event_id",[$username]);	

        // データを取得できたか確認
        if ($userLinkEventList === false){
            $this->af->setApp('print_dbNotConection','true');
            $this->af->setApp('userLinkEventList', null);
        }
        else{
            $this->af->setApp('userLinkEventList', $userLinkEventList);
        }
        
    }
}

