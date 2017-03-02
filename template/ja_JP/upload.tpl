<form action="." method="post" enctype="multipart/form-data">
{if count($errors)}
  <ul>
  {foreach from=$errors item=error}
    <li>{$error}</li>
  {/foreach}
  </ul>
{/if}
  <h2>写真のアップロード</h2>
  <h3>{$app.eventname}</h3>
  <Div Align="right">
    <p>ユーザー名 : {$app.username}</p>
  </Div>
  <Div Align="left">
    <table>
      {if $app.uploadComp}
      <tr>
        <td>
          ファイルをアップロードしました
        </td>
      </tr>
      {/if}
      <tr>
        <td>
          <input type="file" name="filePath">
          <input type="submit" name="action_upload_uploadFile" value="アップロード">
        </td>
      </tr>
    </table>
    <HR>
    <p>
     <input type="submit" name="action_upload_back" value="戻る">
    </p>
  </Div>
</form>
