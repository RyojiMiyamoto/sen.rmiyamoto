<form action="." method="post">
  <h2>イベントの閲覧・編集</h2>
  <h3>{$app.eventname}【{$app.eventkey}】</h3>
  {if $app.key_dbNotConection}
    <p>
      <font color=#ff0000>データベースに接続できません</font>
    </p>
  {/if}
  <Div Align="right">
    <p>ユーザー名 : {$app.username}</p>
  </Div>
  <Div Align="left">
    {foreach from=$app.photoList item=photo}
    <img src={$photo.photo_key} alt={$photo.photo_name} width=240 />
    {/foreach}
  </Div>
  <Div Align="left">
    <p>
     <input type="submit" name="action_editevent_back" value="戻る">     
    </p>
  <HR>
  {if count($errors)}
    <ul>
      {foreach from=$errors item=error}
        <li>{$error}</li>
      {/foreach}
    </ul>
  {/if}
  <table border="0">
    {if $app.editevent_noFile}
    <tr>
      <td><font color=#ff0000>写真が登録されていません</font></td>
    </tr>
    {/if}
    <tr>
      <td><input type="submit" name="action_editevent_goUpload" value="アップロード"></td>
    </tr>
  </table>
</form>
 

