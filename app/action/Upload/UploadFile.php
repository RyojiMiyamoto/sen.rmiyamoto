<?php

/**
 *  Upload/UploadFile.php
 *
 *  @author     {$author}
 *  @package    Sample
 */

/**
 *  upload_uploadFile Form implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_Form_UploadUploadFile extends Sample_ActionForm
{
    /**
     *  @access protected
     *  @var    array   form definition.
     */
    public $form = array(
       'filePath' => [
           'name'      => 'ファイルパス',
           'required'  => true,
           'type'      => VAR_TYPE_FILE,
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
 *  upload_uploadFile action implementation.
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Sample
 */
class Sample_Action_UploadUploadFile extends Sample_ActionClass
{
    /**
     *  preprocess of upload_uploadFile Action.
     *
     *  @access public
     *  @return string    forward name(null: success.
     *                                false: in case you want to exit.)
     */
    public function prepare()
    {
        /*
        $uploaddir = '/var/www/html/sen.rmiyamoto/tempupload/';
        $uploadfile = $uploaddir . basename($_FILES['filePath']['name']);
        
        var_dump($_FILES['filePath']['tmp_name']);
        // ファイルの移動
        if (move_uploaded_file($_FILES['filePath']['tmp_name'], $uploadfile)){
            var_dump("アップロードできました");
        }
        else{
            var_dump("失敗");
        }
        */     

        /*
        $keyname = $_FILES['filePath']['name'];				
        $filepath = $_FILES['filePath']['tmp_name'];
        $contenttype = $_FILES['filePath']['type'];
						
        // Instantiate the client.
        $s3 = S3Client::factory();
        */

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
     *  upload_uploadFile action implementation.
     *
     *  @access public
     *  @return string  forward name.
     */
    public function perform()
    {
        $um = new Sample_UserManager();

        // S3の設定(バケット,　アクセスキー,　シークレットキー)を取得
        $s3Conf = $um->getS3Conf();
        var_dump($s3Conf);

        // ファイルのアップデート
        //$um->uploadFileS3($uploadData);

        return 'upload';
    }
}
