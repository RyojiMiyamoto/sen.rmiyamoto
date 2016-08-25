<?php
/**
 *  Userpage/Newevent.php
 *
 *  @author     {$author}
 *  @package    Sample
 */

/**
 *  userpage_newevent Form implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_Form_UserpageNewevent extends Sample_ActionForm
{
    /**
     *  @access protected
     *  @var    array   form definition.
     */
    public $form = array(

       // 新規イベント名
       'newEventName' => [
           'name'      => '新規イベント名',
           'required'  => true,
           'type'      => VAR_TYPE_STRING,
       ],
       // 新規イベントパスワード
       'newEventPassword' => [
           'name'      => '新規イベントパスワード',
           'required'  => true,
           'type'      => VAR_TYPE_STRING,
       ],
       // 新規イベントパスワード（確認用）
       'newEventPassword_chk' => [
           'name'      => '新規イベントパスワード（確認用）',
           'required'  => true,
           'type'      => VAR_TYPE_STRING,
       ],
       /*
        *  TODO: Write form definition which this action uses.
        *  @see http://ethna.jp/ethna-document-dev_guide-form.html
        *
        *  Example(You can omit all elements except for "type" one) :
        *
        *  'sample' => array(
        *      // Form definition
        *      'type'        => VAR_TYPE_INT,    // Input type
        *      'form_type'   => FORM_TYPE_TEXT,  // Form type
        *      'name'        => 'Sample',        // Display name
        *
        *      //  Validator (executes Validator by written order.)
        *      'required'    => true,            // Required Option(true/false)
        *      'min'         => null,            // Minimum value
        *      'max'         => null,            // Maximum value
        *      'regexp'      => null,            // String by Regexp
        *
        *      //  Filter
        *      'filter'      => 'sample',        // Optional Input filter to convert input
        *      'custom'      => null,            // Optional method name which
        *                                        // is defined in this(parent) class.
        *  ),
        */
    );

    /**
     *  Form input value convert filter : sample
     *
     *  @access protected
     *  @param  mixed   $value  Form Input Value
     *  @return mixed           Converted result.
     */
    /*
    protected function _filter_sample($value)
    {
        //  convert to upper case.
        return strtoupper($value);
    }
    */
}

/**
 *  userpage_newevent action implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_Action_UserpageNewevent extends Sample_ActionClass
{
    /**
     *  preprocess of userpage_newevent Action.
     *
     *  @access public
     *  @return string    forward name(null: success.
     *                                false: in case you want to exit.)
     */
    public function prepare()
    {
        include('adodb/adodb.inc.php');
        include('password_compat/password.php');

        // 空欄がないかチェック
        if ($this->af->validate() > 0) {
            return 'userpage';
        }

        // パスが一致しているかチェック
        if ($this->af->get('newEventPassword') != $this->af->get('newEventPassword_chk')){
            $this->af->setApp('samepass',true);
            return 'userpage';
        }

        // DBに接続
        $db = $this->backend->getDB();

        // ユーザーテーブルを取得
        $newEventName = $this->af->get('newEventName');
        $eventList = $db->GetRow("SELECT eventname FROM eventauth WHERE eventname = '$newEventName'");


        // データを取得できたか確認
        if($eventLsit === false){
            $this->af->setApp('dbNotConection','true');
            return 'userpage';
        }


        // 既に登録されているイベント名かチェック
        if($eventLsit){
            $this->af->setApp('sameevent',true);
            return 'userpage';
        }

        /**
        if ($this->af->validate() > 0) {
            // forward to error view (this is sample)
            return 'error';
        }
        $sample = $this->af->get('sample');
        */
        return null;
    }

    /**
     *  userpage_newevent action implementation.
     *
     *  @access public
     *  @return string  forward name.
     */
    public function perform()
    {
        // 追加するイベントを取得
        $addEventName = $this->af->get('newEventName');                                              // イベント名
        $addEventPassHash = password_hash($this->af->get('newEventPassword'), PASSWORD_DEFAULT);     // イベントのハッシュ化したパス
        
        // DBに接続
        $db = $this->backend->getDB();
        
        // ユーザーテーブルに追加
        $db->Query("INSERT INTO eventauth (eventname, eventauth) VALUES('$addEventName','$addEventPassHash' )");

        return 'editevent';
    }
}
