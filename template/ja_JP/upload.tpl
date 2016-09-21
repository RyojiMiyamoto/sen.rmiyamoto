  <form action="." method="post">
  <h2>写真のアップロード</h2>
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
    <p>
     <input type="submit" name="action_upload_back" value="戻る">
    </p>
  <HR>
</form>
