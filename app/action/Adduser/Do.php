<?php
/**
 *  Adduser/Do.php
 *
 *  @author     {$author}
 *  @package    Sample
 */

/**
 *  adduser_do Form implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_Form_AdduserDo extends Sample_ActionForm
{
    /**
     *  @access protected
     *  @var    array   form definition.
     */
    public $form = array(
           'mailaddress' => [
               'name'        => 'メールアドレス',
               'required'    => true,
               'type'        => VAR_TYPE_STRING,
           ],
           'password'    => [
               'name'        => 'パスワード',
               'required'    => true,
               'type'        => VAR_TYPE_STRING,
           ],
           'password_chk'=> [
               'name'        => 'パスワード（確認用）',
               'required'    => true,
               'type'        => VAR_TYPE_STRING,
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
 *  adduser_do action implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_Action_AdduserDo extends Sample_ActionClass
{
    /**
     *  preprocess of adduser_do Action.
     *
     *  @access public
     *  @return string    forward name(null: success.
     *                                false: in case you want to exit.)
     */
    public function prepare()
    {
        /**
        if ($this->af->validate() > 0) {
            // forward to error view (this is sample)
            return 'error';
        }
        $sample = $this->af->get('sample');
        */
        // 空欄がないかチェック
        if ($this->af->validate() > 0) {
            return 'adduser';
        }
        // パスワードが正しく入力されているかチェック
        if ($this->af->get('password') != $this->af->get('password_chk')){
            $this->af->setApp('samepass',true);
            return 'adduser';
        } 

        return null;
    }

    /**
     *  adduser_do action implementation.
     *
     *  @access public
     *  @return string  forward name.
     */
    public function perform()
    {
        return 'login';
    }
}
