<?php
class Sample_UserManager
{
	public function auth($mailaddress, $password)
	{
		// このロジックはダミーです。
		// 実際にはまともな認証処理を行う
		if ($mailaddress != $password) {
			return Ethna::raiseNotice('メールアドレスまたはパスワードが正しくありません', E_SAMPLE_AUTH);
		}
		// 成功時はnullを返す
		return null;
	}
}
