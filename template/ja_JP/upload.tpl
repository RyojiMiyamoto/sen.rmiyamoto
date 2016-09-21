<form action="." method="post" enctype="multipart/form-data">
  <h2>写真のアップロード</h2>
  <h3>{$app.eventname}</h3>
  <Div Align="right">
    <p>ユーザー名 : {$app.username}</p>
  </Div>
  <Div Align="left">
    <p>
     <input type="submit" name="action_upload_back" value="戻る">
    </p>
  <HR>
  <table>
    <tr>
      <td>
        <input type="file" name="filePath">
        <input type="submit" name="action_upload_uploadFile" value="アップロード">
      </td>
    </tr>
  </table>
</form>
