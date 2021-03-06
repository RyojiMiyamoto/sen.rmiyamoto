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
        include('adodb/adodb.inc.php');

        // s3の設定情報を取得
        include('/home/m17/m17-miya/sen.rmiyamoto/conf/setting.php');        

        $userID = $_POST["userid"];
        $userName = $_POST["username"];
        $eventID = $_POST["eventid"];
        $eventName = $_POST["eventname"];

        $this->af->setApp('userid', $userID);
        $this->af->setApp('username', $userName);
        $this->af->setApp('eventid', $eventID);
        $this->af->setApp('eventname', $eventName);
        
        /*
        // sessionからユーザー名とイベント名を取得しtplに渡す
        $this->af->setApp('username', $this->session->get('username'));
        $this->af->setApp('eventname', $this->session->get('eventname'));
        */        

        /**
         * イベント編集画面ではイベントに認証キーを表示するため、
         * DBからイベント名で検索をかけて、認証キーを探してくる
         */

        // DBに接続
        $db = $this->backend->getDB();

        $um = new Sample_UserManager();       

        // 認証キーを取得
        $result = $db->GetRow("SELECT event_key FROM eventlist WHERE event_id = ?", [$eventID]);
        
        // 認証キーが取得できたか
        if($result === false){
            $this->af->setApp('key_dbNotConection','true');
            return 'editevent';
        }
        
        // array → string
        $eventKey = implode("",$result);
        
        // 認証キーをtplに渡す
        $this->af->setApp('eventkey', $eventKey);
                

        // アップロードされた ファイルのパスを取得する

        // イベント内のファイルのパスをすべて取得する
        $photoList = $um->getUploadFilePathsDB($s3Conf ,$eventID, $this->backend);
        
        // ファイルが見つからなかった時（新規作成時）
        if ($photoList === null){
            $this->af->setApp('editevent_noFile','true');
            return 'editevent';
        }

	// ファイル（写真）のリストをtplに渡す
        $this->af->setApp('photoList', $photoList);

    }
}

