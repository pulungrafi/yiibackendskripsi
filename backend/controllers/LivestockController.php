<?php

namespace backend\controllers;

use Yii;
use backend\models\Livestock;
use backend\models\LivestockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * LivestockController implements the CRUD actions for Livestock model.
 */
class LivestockController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'], // Adjust roles as needed
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Livestock models.
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LivestockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->asJson([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider->getModels(),
        ]);
    }

    /**
     * Displays a single Livestock model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->asJson($this->findModel($id));
    }

    // ... (Other actions such as create, update, delete)

    /**
     * Finds the Livestock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Livestock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Livestock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
