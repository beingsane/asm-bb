<?php

namespace frontend\controllers;

use Yii;
use common\models\Thread;
use common\models\Comment;
use frontend\models\ThreadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ThreadController implements the CRUD actions for Thread model.
 */
class ThreadController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Thread models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThreadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearchByTag($tag)
    {
        $_GET['ThreadSearch']['tag'] = $tag;
        return $this->actionIndex();
    }

    /**
     * Displays a single Thread model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $newCommentModel = new Comment();
        $newCommentModel->user_id = Yii::$app->user->id;
        $newCommentModel->thread_id = $model->id;

        if (Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                throw new \yii\web\ForbiddenHttpException(Yii::t('app', 'Please log in'));
            }

            $newCommentModel->load(Yii::$app->request->post());

            if ($newCommentModel->save()) {
                $newCommentModel = new Comment();
                $newCommentModel->user_id = Yii::$app->user->id;
                $newCommentModel->thread_id = $model->id;
            }
        }

        return $this->render('view', [
            'model' => $model,
            'newCommentModel' => $newCommentModel,
        ]);
    }

    /**
     * Creates a new Thread model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Thread();
        $model->user_id = Yii::$app->user->id;

        $newCommentModel = new Comment();
        $newCommentModel->user_id = Yii::$app->user->id;

        $postData = Yii::$app->request->post();
        if ($model->load($postData) && $res = $model->save()) {
            $newCommentModel->load(Yii::$app->request->post());
            $newCommentModel->thread_id = $model->id;
            $newCommentModel->user_id = Yii::$app->user->id;
            $newCommentModel->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'newCommentModel' => $newCommentModel,
            ]);
        }
    }

    /**
     * Finds the Thread model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Thread the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Thread::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
