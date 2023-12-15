<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username dan password wajib diisi
            [['username', 'password'], 'required', 'message' => '{attribute} cannot be blank.'],
            // rememberMe harus berupa boolean
            ['rememberMe', 'boolean'],
            // validasi password dengan metode validatePassword
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'rememberMe' => 'Remember Me',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password. Please try again.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();

            // Check if the user is valid
            if ($user) {
                // Generate JWT token
                $jwt = Yii::$app->jwt;
                $token = $jwt->getBuilder()
                    ->setIssuer(Yii::$app->request->hostInfo)
                    ->setSubject((string)$user->id)
                    ->setAudience(Yii::$app->request->hostInfo)
                    ->setIssuedAt(time())
                    ->setExpiration(time() + 3600) // Token expiration time (1 hour)
                    ->setId(Yii::$app->security->generateRandomString(16), true)
                    ->set('uid', $user->id) // Set custom claims
                    ->sign($jwt->getSigner(), $jwt->key)
                    ->getToken();

                // Set the generated token to the user identity
                $user->token = (string)$token;

                // Save the user with the token
                if ($user->save()) {
                    Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
