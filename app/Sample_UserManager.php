<?php


use Aws\S3\S3Client;
use Aws\Common\Aws;
use Aws\Common\Enum\Region; 
use Aws\S3\Enum\CannedAcl; 
use Aws\S3\Exception\S3Exception; 
use Guzzle\Http\EntityBody;
use Guzzle\Http\Message\Request;


class Sample_UserManager
{
	/**
         * DBからのログイン認証
         * 認証できていない際にはエラーメッセージを返す
         *
         * @param String $mailaddress         : ログインユーザーのメールアドレス(入力フォーム)
         * @param String $password            : ログインユーザーのパスワード(入力フォーム)
         * @param $this->backend $backend     
         * @return null | Ethna::raiseNotice 
         */
	public function auth($mailaddress, $password, $backend)
	{			
		// DB接続
		$db = $backend->getDB();
		
		
		// DBからユーザーのメールアドレスを取得
		$dbMail = $db->GetRow("SELECT user_name FROM userlist WHERE user_name = ?", [$mailaddress]);
		// DB内のメールアドレスを取得できたか確認
		if($dbMail === false){
			return  Ethna::raiseNotice('データベースに接続できません',E_SAMPLE_AUTH);
		}
		// 登録されているメールアドレスかチェック
		if(!$dbMail){
			return  Ethna::raiseNotice('メールアドレスが間違っています',E_SAMPLE_AUTH);
		}
		
		// DBからユーザーのパスワードを取得
		$dbPassHash = $db->GetRow("SELECT user_pass FROM userlist WHERE user_name = ?", [$mailaddress]);
		// DB内のパスワードが取得できたか
		if($dbPassHash === false){
			return  Ethna::raiseNotice('データベースに接続できません',E_SAMPLE_AUTH);
		}
		// パスワード認証
		$bufPassHash = implode("",$dbPassHash);			// array型→String型
		if(password_verify($password, $bufPassHash)==false){
			return Ethna::raiseNotice('パスワードが間違っています',E_SAMPLE_AUTH);
		}

		// 成功時はnullを返す
		return null;
	}

	/**
	 * ランダム文字列生成 (英数字)
         *
         * @param int $length    : 生成する文字数
         * @return String $r_str : ランダムな英数字の羅列
	 */
	function makeRandStr($length) {
		$str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z"'));
	
		for ($i = 0; $i < $length; $i++) {
			$r_str .= $str[rand(0, count($str)-1)];
		}
	
		return $r_str;
	}

        /**
         * S3にファイルのアップロードを行う
         *
         * @param String $uploadData["s3Conf"]["bucket"]      : s3_ブランケット
         * @param String $uploadData["s3Conf"]["accessKey"]   : s3_アクセスキー
         * @param String $uploadData["s3Conf"]["secretKey"]   : s3_シークレットキー
         * @param String $uploadData["fileInfo"]["filePath"]  : ファイルパス
         * @param String $uploadData["fileInfo"]["fileID"]    : ファイルID
         * @param String $uploadData["fileInfo"]["type"]      : ファイルの種類
         * @param SS3Clienttring $uploadData["fileInfo"]["eventID"]   : イベントID
         */
        public function uploadFileS3($uploadData)
        {
                
		$s3 = S3Client::factory([
                       'key'    => $uploadData["s3Conf"]["accessKey"],
                       'secret' => $uploadData["s3Conf"]["secretKey"],
                       'region' => Region::AP_NORTHEAST_1
                ]);
              
                $result = $s3->putObject([
                       'Bucket'       => $uploadData["s3Conf"]["bucket"],
                       'Key'          => $uploadData["fileInfo"]["eventID"] . "/" . $uploadData["fileInfo"]["fileID"] . ".jpg",
                       'SourceFile'   => $uploadData["fileInfo"]["filePath"],
                       'ContentType'  => $uploadData["fileInfo"]["type"],
                       'ACL'          => 'public-read',
                       'StorageClass' => 'REDUCED_REDUNDANCY'
                ]);
        }

        /**
         * イベント名からイベントIDを取得する
         *
         * @param String $eventName
         * @param $this->backend $backend
         * @return int $eventID
         */
        public function getEventID($eventName, $backend)
        {
                // DBに接続
                $db = $backend->getDB();
                
                // イベント名からイベントIDの取得
                $eventID = $db->getRow("SELECT event_id FROM eventlist WHERE event_name = ?", [$eventName]);
                 
                return $eventID;
        }
        
        /**
         * s3設定ファイル(setting.php)からバケット名, アクセスキー, シークレットキーを取得する
         *
         * @return String[] $s3Conf
         */
        public function gets3Conf()
        {
                require_once("/home/m17/m17-miya/sen.rmiyamoto/conf/setting.php");
                /*
                $settingFile = "/home/m17/m17-miya/sen.rmiyamoto/conf/setting.php";
                $s3Conf = json_decode(file_get_contents($settingFile,null,null,5), true);
                return $s3Conf;
                */

        }


        /**
         * アップロードされたファイルのパスを取得
         *
         * @param String $s3Conf["bucket"]    : s3_ブランケット
         * @param String $s3Conf["accessKey"] : s3_アクセスキー
         * @param String $s3Conf["secretKey"] : s3_シークレットキー
         * @param String $eventID             : イベントID
         * @param $this->backend $backend
         * @return String[] $filePaths        : ファイルのパスの一覧
         */
        public function getUploadFilePathsDB($s3Conf ,$eventID, $backend)
        {
                // DBに接続
                $db = $backend->getDB();

                // イベントIDと関連するファイルIDを取得
                $fileUrls = $db->getAll("SELECT photo_id FROM photolist WHERE photo_event = ?", [$eventID]);	
                
                // データを取得できたか確認
                if ($fileUrls === false){
                    return  null;
                }
                
                // s3に接続
                $s3 = S3Client::factory([
                    'key'    => $s3Conf["accessKey"],
                    'secret' => $s3Conf["secretKey"],
                    'region' => Region::AP_NORTHEAST_1
                ]);

                // 一時URLの生成
                foreach($fileUrls as &$file){
                    $key = $eventID . "/" . $file['photo_id'] . ".jpg";
                    $file["photo_url"] = $s3->getObjectUrl($s3Conf["bucket"], $key, '+10 minutes');
                }
                unset($file);

                return $fileUrls;
        }

        /**
         * アップロードするファイル情報（イベント、ファイル名）を扱うテーブル(photolist)に書き込み、ファイルIDを返す
         *
         * @param String $eventID         : イベントID
         * @param String $fileName        : ファイル名
         * @param $this->backend $backend
         * @return int $fileID            : ファイルID
         */
        public function addPhotoDataDB($eventID, $fileName, $backend)
        {
                // DBに接続
                $db = $backend->getDB();

                // アップロードするファイルの情報を写真テーブル(photolist)に追加
                $db->Query("INSERT INTO photolist (photo_event, photo_name) VALUES(?,?)", [$eventID, $fileName]);

                // 先ほど登録したファイルのIDを取得
                $fileID = $db->getRow("SELECT photo_id FROM photolist WHERE photo_event = ? AND photo_name = ?", [$eventID, $fileName]);

                // ファイルIDを返す
                return $fileID;
        }
        

}

