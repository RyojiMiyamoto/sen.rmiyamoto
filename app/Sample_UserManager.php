<?php
class Sample_UserManager
{
	// DBからの認証
	public function auth($mailaddress, $password, $backend)
	{			
		// DB接続
		$db = $backend->getDB();
		// DBからユーザー情報を取得
		$userdata = $db->GetRow('SELECT address FROM usertable WHERE address = $mailaddress ORDER BY adduser');
		if(!$userdata)
		{
			var_dump('ユーザー名が違います');
		}
		// テスト
		else
		{
			var_dump($userdata);
		}
		if ($mailaddress != $password) {
			return Ethna::raiseNotice('メールアドレスまたはパスワードが正しくありません', E_SAMPLE_AUTH);
		}
		$db->disconnect();
		// 成功時はnullを返す
		return null;
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
