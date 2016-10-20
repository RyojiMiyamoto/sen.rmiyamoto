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
	// DBからの認証
	public function auth($mailaddress, $password, $backend)
	{			
		// DB接続
		$db = $backend->getDB();
		
		
		// DBからユーザーのメールアドレスを取得
		$dbMail = $db->GetRow("SELECT user_name FROM userlist WHERE user_name = '$mailaddress'");
		// DB内のメールアドレスを取得できたか確認
		if($dbMail === false){
			return  Ethna::raiseNotice('データベースに接続できません',E_SAMPLE_AUTH);
		}
		// 登録されているメールアドレスかチェック
		if(!$dbMail){
			return  Ethna::raiseNotice('メールアドレスが間違っています',E_SAMPLE_AUTH);
		}
		
		// DBからユーザーのパスワードを取得
		$dbPassHash = $db->GetRow("SELECT user_pass FROM userlist WHERE user_name = '$mailaddress'");
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
	 * $length: 生成する文字数
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
         * $uploadData: s3の設定(バケット名, アクセスキー, シークレットキー), ファイル名, キー名
         */
        public function uploadFileS3($uploadData)
        {

		$s3 = S3Client::factory(array(
                       'key'    => $uploadData["s3Conf"]["accessKey"],
                       'secret' => $uploadData["s3Conf"]["secretKey"],
                       'region' => Region::AP_NORTHEAST_1
                ));
              
                $result = $s3->putObject(array(
                       'Bucket'       => $uploadData["s3Conf"]["bucket"],
                       'Key'          => $uploadData["fileInfo"]["eventName"] . "/" . $uploadData["fileInfo"]["fileName"],
                       'SourceFile'   => $uploadData["fileInfo"]["filePath"],
                       'ContentType'  => $uploadData["fileInfo"]["type"],
                       'ACL'          => 'public-read',
                       'StorageClass' => 'REDUCED_REDUNDANCY'
                ));
                echo $result['ObjectURL'];
        }

        /**
         * ファイル(s3.conf)からバケット名, アクセスキー, シークレットキーを取得する
         * 
         */
        public function getS3Conf()
        {
        	$s3ConfTemp = explode("\n", file_get_contents('/home/m17/m17-miya/sen.rmiyamoto/conf/s3.conf'));
                $s3Conf = array(
                    "bucket"     => str_replace("\r\n", '',$s3ConfTemp[0]),
                    "accessKey"  => str_replace("\r\n", '',$s3ConfTemp[1]),
                    "secretKey"  => str_replace("\r\n", '',$s3ConfTemp[2])
                );
                
                return $s3Conf;
        }

        public function getUploadFilePathS3($eventName,$backend)
        {
                $result = "test";

                return $result;
        }
}

