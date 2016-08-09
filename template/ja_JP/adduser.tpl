<form action="." method="post">
  {if count($error)}
    <ul>
    {foreach from=$error item=error}
      <li>{$error}</li>
    {/foreach}
    </ul>
  {/if}
  <table border="0">
    {if $app.dbNotConection}
    <tr>
      <td><font color=#ff0000>データベースに接続できません</font><td>
    </tr>
    {/if}
    <tr>
      <td>メールアドレス</td>
      <td><input type="text" name="mailaddress" value="">{message name="mailaddress"}</td>
      {if $app.sameaddresss}
      <td><font color=#ff0000>既に登録されているアドレスです</font></td>
      {/if}
    </tr>
    <tr>
      <td>パスワード</td>
      <td><input type="password" name="password" value="">{message name="password"}</td>
    </tr>
    <tr>
      <td>パスワード（確認用）</td>
      <td><input type="password" name="password_chk" value="">{message name="password_chk"}</td>
      {if $app.samepass}
      <td><font color=#ff0000>パスワードが正しくありません</font></td>
      {/if}
    </tr>
  </table>
  <p>
  <input type="submit" name="action_adduser_do" value="登録">
  </p>
</form>
