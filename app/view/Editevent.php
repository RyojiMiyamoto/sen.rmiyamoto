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
        
        // sessionからユーザー名とイベント名を取得しtplに渡す
        $this->af->setApp('username', $this->session->get('username'));
        $this->af->setApp('eventname', $this->session->get('eventname'));
        
        /**
         * イベント編集画面ではイベントに認証キーを表示するため、
         * DBからイベント名で検索をかけて、認証キーを探してくる
         */

        // イベント名の取得
        $eventName = $this->session->get('eventname');
        
        // DBに接続
        $db = $this->backend->getDB();


        $um = new Sample_UserManager();        
        
        // イベントIDを取得
        $eventID = $um->getEventID($eventName, $this->backend);

        // 認証キーを取得
        $result = $db->GetRow("SELECT event_key FROM eventlist WHERE event_id = ?", [$eventID["event_id"]]);
        
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

        // s3の設定データを取得
        $s3Conf = $um->getS3Conf();

        // イベント内のファイルのパスをすべて取得する
        $photoList = $um->getUploadFilePathsDB($s3Conf ,$eventID["event_id"], $this->backend);
        
        // ファイルが見つからなかった時（新規作成時）
        if ($photoList === null){
            $this->af->setApp('editevent_noFile','true');
            return 'editevent';
        }

	// ファイル（写真）のリストをtplに渡す
        $this->af->setApp('photoList', $photoList);

    }
}

