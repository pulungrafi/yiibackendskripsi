<?php

namespace backend\controllers;

use backend\models\LoginForm;
use backend\models\RegisterForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'register', 'choose-role'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->asJson(['message' => 'Already logged in']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->asJson(['message' => 'Login successful']);
        }

        $model->password = '';
        return $this->asJson(['error' => $model->errors, 'message' => 'Login failed']);
    }

    /**
     * Register action.
     *
     * @return string|Response
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->asJson(['message' => 'Already registered']);
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->asJson(['message' => 'Registration successful']);
        }

        return $this->asJson(['error' => $model->errors, 'message' => 'Registration failed']);
    }

    /**
     * Action untuk memilih role setelah login.
     * @return string|Response
     */
    public function actionChooseRole()
    {
        // Pastikan pengguna sudah login
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // Pastikan pengguna belum memilih role sebelumnya
        if (!Yii::$app->user->identity->role_id) {
            $roles = [
                ['id' => 1, 'name' => 'Peternak'],
                ['id' => 2, 'name' => 'Admin'],
                ['id' => 3, 'name' => 'Calon Pembeli Ternak'],
            ];

            // Menggunakan asJson untuk mengubah respons menjadi JSON
            return $this->asJson(['roles' => $roles]);
        }

        // Redirect ke halaman sesuai dengan role yang dipilih
        $selectedRoleId = Yii::$app->user->identity->role_id;

        if ($selectedRoleId === null) {
            // Handle kesalahan atau alur lainnya
            return $this->asJson(['error' => 'Invalid role selected']);
        }

        if ($selectedRoleId == 1) {
            // Menggunakan asJson untuk mengubah respons menjadi JSON
            return $this->asJson(['redirect' => ['peternak/index']]); // Ganti dengan path peternak yang sesuai
        } elseif ($selectedRoleId == 2) {
            // Menggunakan asJson untuk mengubah respons menjadi JSON
            return $this->asJson(['redirect' => ['admin/index']]); // Ganti dengan path admin yang sesuai
        } elseif ($selectedRoleId == 3) {
            // Menggunakan asJson untuk mengubah respons menjadi JSON
            return $this->asJson(['redirect' => ['calon-pembeli/index']]); // Ganti dengan path calon pembeli yang sesuai
        }

        // Jika terdapat perubahan atau kesalahan, arahkan ke halaman default
        return $this->asJson(['redirect' => ['site/index']]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
