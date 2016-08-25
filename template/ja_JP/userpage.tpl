<h2>ユーザーページ</h2>
<form action="." method="post">
  <Div Align="right">
    <p><input type="submit" name="action_userpage_logout" value="ログアウト"></p>
    <p>ユーザー名 : {$app.username}</p>
    </p>
  </Div>
  <HR>
  <p>閲覧するイベントを選択</p>
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
  <p><input type="submit" name="action_loginevent_go" value="イベントを閲覧"></p>
  <HR>
  <p>既存のイベントと関連付ける</p>
  <table border="0">
    <tr>
      <td>イベントの選択</td>
      <td>
        <select name="allEventNaem" size="4">
          <option>テスト1</option>
          <option>テスト2</option>
          <option>テスト3</option>
          <option>テスト4</option>
        </select>
      </td>
    </tr>
　　<tr>
      <td>イベントパスワード</td>
      <td><input type="password" name="connectEventPassword" value=""></td>
    </tr>
  </table>
    <p><input type="submit" name="action_connectevent_go" value="既存のイベントと関連付ける"></p>
  <HR>
  <p>新規のイベントを追加する</p>
  <table border="0">
    <tr>
      <td>新規イベント名</td>
      <td><input type="text" name="newEventName" value=""></td>
    </tr>
      <tr>
      <td>新規イベントパスワード</td>
      <td><input type="password" name="newEventPassword" value=""></td>
    </tr>
  </table>
  <p><input type="submit" name="action_newevent_go" value="新規イベントの追加"></p>
</form>

