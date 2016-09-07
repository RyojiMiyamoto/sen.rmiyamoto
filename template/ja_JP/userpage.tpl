<h2>ユーザーページ</h2>
<form action="." method="post">
  <Div Align="right">
    <p><input type="submit" name="action_userpage_logout" value="ログアウト"></p>
    <p>ユーザー名 : {$app.username}</p>
    </p>
  </Div>
  <HR>
  <p>閲覧・編集するイベントを選択</p>
  <table border="0">
    <tr>
      <td>イベントを選択</td>
      <td>
        <select name="authEventNaem" size="4">
          <option>テスト1</option>
          <option>テスト2</option>
          <option>テスト3</option>
          <option>テスト4</option>
        </select>
　　　</td>
    </tr>
  </table>
  <p><input type="submit" name="action_userpage_viewevent" value="イベントを閲覧・編集"></p>
  <HR>
  <p>既存のイベントと関連付ける</p>
  <table border="0">
    <tr>
      <td>認証キー</td>
    </tr>
　　<tr>
      <td>
        <input type="text" name="connectEventKey1" value="" size="2">
        -
        <input type="text" name="connectEventKey2" value="" size="2">
        -
        <input type="text" name="connectEventKey3" value="" size="2">
      </td>
    </tr>
  </table>
  <p><input type="submit" name="action_userpage_connectevent" value="既存のイベントと関連付ける"></p>
  <HR>
  <p>新規のイベントを追加する</p>
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
      <td><font color=#ff0000>データベースに接続できません</font></td>
    </tr>
    {/if}
    <tr>
      <td>新規イベント名</td>
      <td><input type="text" name="newEventName" value="">{message name="newEventName"}</td>
      {if $app.sameevent}
      <td><font color=#ff0000>既に登録されているアドレスです</font></td>
      {/if}
    </tr>
    <tr>
      <td>新規イベントパスワード</td>
      <td><input type="password" name="newEventPassword" value="">{message name="newEventPassword"}</td>
    </tr>
    <tr>
      <td>新規イベントパスワード（確認用）</td>
      <td><input type="password" name="newEventPassword_chk" value="">{message name="newEventPassword_chk"}</td>
      {if $app.samepass}
      <td><font color=#ff0000>パスワードが正しくありません</font></td>
      {/if}
    </tr>
  </table>
  <p><input type="submit" name="action_userpage_newevent" value="新規イベントの追加"></p>
</form>

