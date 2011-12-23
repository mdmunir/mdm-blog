<?php

class GeogebraController extends Controller {

    //public $layout = 'column2';

    public function actionIndex($id=FALSE, $inframe=FALSE) {
        if ($id !== FALSE) {
            $geo = Geogebra::model()->findByPk($id);
            if ($geo != NULL)
                $data = $geo->data;
            else
                $data = FALSE;
        }else
            $data = FALSE;

        if ($inframe)
            $this->layout = 'simple';
        $this->render('index', array('ggbBase64' => $data));
    }

    public function actionFile($filename) {
        $file = '/home/mdmunir/Data/lain-lain/' . $filename;

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }

    public function actionPost() {
        $model = new Geogebra;

        // uncomment the following code to enable ajax-based validation
        /*
          if(isset($_POST['ajax']) && $_POST['ajax']==='geogebra-post-form')
          {
          echo CActiveForm::validate($model);
          Yii::app()->end();
          }
         */

        if (isset($_POST['Geogebra'])) {
            $model->attributes = $_POST['Geogebra'];
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }
        $this->render('post', array('model' => $model));
    }

}