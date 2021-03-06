<?php

class Comment extends CActiveRecord {
    /**
     * The followings are the available columns in table 'tbl_comment':
     * @var integer $id
     * @var string $content
     * @var integer $status
     * @var integer $create_time
     * @var string $author
     * @var string $email
     * @var string $url
     * @var integer $post_id
     */
    const STATUS_PENDING=1;
    const STATUS_APPROVED=2;

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
        return '{{comment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content, author, email', 'required'),
            array('author, email, url', 'length', 'max' => 128),
            array('email', 'email'),
            array('url', 'url'),
            array('comment_parent','safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'comment_parent', 'condition' => 'comments.status=' . Comment::STATUS_APPROVED, 'order' => 'comments.create_time ASC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Id',
            'content' => 'Comment',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'author' => 'Name',
            'email' => 'Email',
            'url' => 'Website',
            'post_id' => 'Post',
        );
    }

    /**
     * Approves a comment.
     */
    public function approve() {
        $this->status = Comment::STATUS_APPROVED;
        $this->update(array('status'));
    }

    /**
     * @param Post the post that this comment belongs to. If null, the method
     * will query for the post.
     * @return string the permalink URL for this comment
     */
    public function getUrl($post=null) {
        if ($post === null)
            $post = $this->post;
        return $post->url . '#c' . $this->id;
    }

    /**
     * @return string the hyperlink display for the current comment's author
     */
    public function getAuthorLink() {
        if (!empty($this->url))
            return CHtml::link(CHtml::encode($this->author), $this->url);
        else
            return CHtml::encode($this->author);
    }

    /**
     * @return integer the number of comments that are pending approval
     */
    public function getPendingCommentCount() {
        return $this->with(array(
                    'post' => array(
                        'condition' => 'post.author_id = ' . Yii::app()->user->id,
                        ))
                )->count('t.status=' . self::STATUS_PENDING);
    }

    /**
     * @param integer the maximum number of comments that should be returned
     * @return array the most recently added comments
     */
    public function findRecentComments($limit=10) {
//		return $this->with('post')->findAll(array(
//			'condition'=>'t.status='.self::STATUS_APPROVED.' AND post.status='.Post::STATUS_PUBLISHED,
//			'order'=>'t.create_time DESC',
//			'limit'=>$limit,
//		));
        return $this->with(array(
                    'post' => array(
                        'condition' => 'post.status != ' . Post::STATUS_DRAFT,
                        ))
                )->findAll(array(
                    'condition' => 't.status=' . self::STATUS_APPROVED,
                    'order' => 't.create_time DESC',
                    'limit' => $limit,
                ));
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord)
                $this->create_time = time();
            return true;
        }
        else
            return false;
    }

}