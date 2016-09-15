<?php
/**
 *  Userpage/Connectevent.php
 *
 *  @author     {$author}
 *  @package    Sample
 */

/**
 *  userpage_connectevent Form implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_Form_UserpageConnectevent extends Sample_ActionForm
{
    /**
     *  @access protected
     *  @var    array   form definition.
     */
    public $form = array(
       'connectEventKey1' => [
          'name'      => '認証キー1',
          'require'   => true,
          'type'      => VAR_TYPE_STRING.
       ],
       'connectEventKey2' => [
          'name'      => '認証キー2',
          'require'   => true,
          'type'      => VAR_TYPE_STRING.
       ],
       'connectEventKey3' => [
          'name'      => '認証キー3',
          'require'   => true,
          'type'      => VAR_TYPE_STRING.
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
 *  userpage_connectevent action implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_Action_UserpageConnectevent extends Sample_ActionClass
{
    /**
     *  preprocess of userpage_connectevent Action.
     *
     *  @access public
     *  @return string    forward name(null: success.
     *                                false: in case you want to exit.)
     */
    public function prepare()
    {
        include('adodb/adodb.inc.php');

         
        // 空欄がないかチェック
        if ($this->af->validate() > 0) {
            return 'userpage';
        }

        // 画面から認証キーを取得し整形
　　　　$cnctKey1 = $this->af->get('connectEventKey1');
        $cnctKey2 = $this->af->get('connectEventKey2');
        $cnctKey3 = $this->af->get('connectEventKey3');
        $fullCnctkey = $cnctKey1 . "-" . $cnctKey2 . "-" . $cnctKey3;

        // DBに接続
        $db = $this->backend->getDB();

        // 同一の認証キーが存在するか取得
        $result = $db->GetRow("SELECT event_key FROM eventlist WHERE user_key = '$fullCnctKey'");

        // データを取得できたか確認
        if($result === false ){
            $this->af->setApp('dbNotConection','true');
            return 'userpage';
        }
        
        // 存在しない認証キーか確認
        if (!$result){
            $this->af->setApp('wrongKey','true');
            return 'userpage';
        }


        return null;
    }

    /**
     *  userpage_connectevent action implementation.
     *
     *  @access public
     *  @return string  forward name.
     */
    public function perform()
    {        
        return 'userpage';
    }
}
