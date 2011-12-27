<?php

class User extends CActiveRecord {

    /**
     * The followings are the available columns in table 'tbl_user':
     * @var integer $id
     * @var string $username
     * @var string $password
     * @var string $password2
     * @var string $salt
     * @var string $email
     * @var string $profile
     */
    public $password1;
    public $password2;
    public $old_password;
    public $verifyCode;

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, email, password1, password2', 'required', 'on' => 'insert'),
            array('username', 'unique', 'on' => 'insert', 'caseSensitive' => false),
            array('username', 'match', 'pattern' => '/^([a-zA-Z0-9_])+$/'),
            array('old_password, password1, password2', 'required', 'on' => 'changePassword'),
            array('username, email', 'length', 'max' => 64),
            array('email', 'email',),
            array('password2', 'compare', 'compareAttribute' => 'password1', 'on' => array('insert', 'changePassword')),
            array('old_password', 'authenticate', 'on' => 'changePassword'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements() || true, 'on' => 'insert'),
            array('profile, password1, old_password, full_name', 'safe'),
        );
    }

    public function allowPosting($allow) {
        $this->can_posting = $allow;
        $this->update(array('can_posting'));
    }

    public function getProfileLink() {
        return CHtml::normalizeUrl(array('user/profile', 'id' => $this->id));
    }

    public function getFullName() {
        if (!empty($this->full_name))
            return $this->full_name;
        else
            return $this->username;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'posts' => array(self::HAS_MANY, 'Post', 'author_id'),
            'postingCount' => array(self::STAT, 'Post', 'author_id',
                'condition' => 'status=' . Post::STATUS_PUBLISHED . ' OR ' . 'status=' . Post::STATUS_ARCHIVED),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Id',
            'username' => 'Username',
            'password1' => 'New password',
            'password2' => 'Confirm new password',
            'email' => 'Email',
            'profile' => 'Profile',
            'verifyCode' => 'Verification Code',
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->validatePassword($this->$attribute))
            $this->addError($attribute, 'Incorrect password.');
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    /**
     * Generates the password hash.
     * @param string password
     * @param string salt
     * @return string hash
     */
    public function hashPassword($password, $salt) {
        return md5($salt . $password);
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     * @return string the salt
     */
    public function generateSalt() {
        return uniqid('', true);
    }

}