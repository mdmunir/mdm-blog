<?php

class PostController extends Controller {
    const LS_VIEW = 'VIEW';
    const LS_CHANGE = 'CHANGE';

    public $layout = 'column2';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to access 'index' and 'view' actions.
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated users to access all actions
                'users' => array('@'),
                'expression' => '(!$user->isGuest && $user->can_posting)',
            ),
            array('allow',
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     */
    public function actionView() {
        $post = $this->loadModel();
        $comment = $this->newComment($post);

        $key = Yii::app()->getId() . 'POST_VIEWED' . $post->id;
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = TRUE;
            $post->updateCounters(array('viewed' => 1), "id={$post->id}");
        }

        $this->render('view', array(
            'model' => $post,
            'comment' => $comment,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Post;
        if (isset($_POST['Post'])) {
            $model->attributes = $_POST['Post'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate() {
        $model = $this->loadModel(self::LS_CHANGE);
        if (isset($_POST['Post'])) {
            $model->attributes = $_POST['Post'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel(self::LS_CHANGE)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->isHome = (!isset($_GET['tag']) && !isset($_GET['author']));
        $criteria = new CDbCriteria(array(
                    'condition' => 'status=' . Post::STATUS_PUBLISHED,
                    'order' => 't.id DESC',
                    'with' => array('commentCount', 'author'),
                ));
        if (isset($_GET['tag']))
            $criteria->addSearchCondition('tags', $_GET['tag']);

        if (isset($_GET['author'])) {
            $criteria->compare('t.author_id', $_GET['author']);
        }

        $dataProvider = new CActiveDataProvider('Post', array(
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['postsPerPage'],
                    ),
                    'criteria' => $criteria,
                ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Post('search');
        if (isset($_GET['Post']))
            $model->attributes = $_GET['Post'];
        $model->author_id = Yii::app()->user->id;
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Suggests tags based on the current user input.
     * This is called via AJAX when the user is entering the tags input.
     */
    public function actionSuggestTags() {
        if (isset($_GET['q']) && ($keyword = trim($_GET['q'])) !== '') {
            $tags = Tag::model()->suggestTags($keyword);
            if ($tags !== array())
                echo implode("\n", $tags);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel($scenario = self::LS_VIEW) {
        if ($this->_model === null) {
            if (isset($_GET['id'])) {
                if (Yii::app()->user->isGuest)
                    $condition = 'status=' . Post::STATUS_PUBLISHED . ' OR status=' . Post::STATUS_ARCHIVED;
                else
                    $condition = '';
                $this->_model = Post::model()->findByPk($_GET['id'], $condition);
            }
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            if ($scenario === self::LS_CHANGE && Yii::app()->user->id !== $this->_model->author_id) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
        }
        return $this->_model;
    }

    /**
     * Creates a new comment.
     * This method attempts to create a new comment based on the user input.
     * If the comment is successfully created, the browser will be redirected
     * to show the created comment.
     * @param Post the post that the new comment belongs to
     * @return Comment the comment instance
     */
    protected function newComment($post) {
        $comment = new Comment;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($comment);
            Yii::app()->end();
        }
        if (isset($_POST['Comment'])) {
            $comment->attributes = $_POST['Comment'];
            if ($post->addComment($comment)) {
                if ($comment->status == Comment::STATUS_PENDING)
                    Yii::app()->user->setFlash('commentSubmitted', 'Thank you for your comment. Your comment will be posted once it is approved.');
                $this->refresh();
            }
        }
        return $comment;
    }

}
