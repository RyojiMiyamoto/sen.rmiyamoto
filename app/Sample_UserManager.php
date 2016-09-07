<?php
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

	// old
	/*
	public function auth($mailaddress, $password)
        {
                // このロジックはダミーです。
                // 実際にはまともな認証処理を行う
                if ($mailaddress != $password) {
                        return Ethna::raiseNotice('メールアドレスまたはパスワードが正しくあり
ません', E_SAMPLE_AUTH);
                }
                // 成功時はnullを返す
                return null;
        }
	*/

}
