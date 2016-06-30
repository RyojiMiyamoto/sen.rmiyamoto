<form action="." method="post">
{if count($erroes)}
	<ul>
	{foreach from=$errors item=error}
		<li>{$error}</li>
	{/foreach}
	</ul>
{/if}
	<table border="0">
		<tr>
			<td>メールアドレス</td>
			<td><input type="text" name="mailaddress" value="{$form.mailaddress}">{message name="mailaddress"}</td>
		</tr>
		<tr>
			<td>パスワード</td>
			<td><input type="password" name="password" balue="">{message name="password"}</td>
		</tr>
	</table>
	<p>
	<input type="submit" name="action_login_do" value="ログイン">
	</p>
</form>
