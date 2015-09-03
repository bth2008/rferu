<?php

namespace app\models;
use Yii;
class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $vid;
    public $firstname;
    public $lastname;
    public $pilot_rating;
    public $country;
    public $division;
    public $authKey;
    public $accessToken;
    /**
     * @inheritdoc
     */
    public function login($token){
	$data=json_decode(file_get_contents("http://login.ivao.aero/api.php?token=$token&type=json"));
	if($data->result==1)
	{
	    if($identity=self::findIdentity($data->vid))
		Yii::$app->user->login($identity,3600);
	    else{
		$user=new Users;
		$user->firstname=$data->firstname;
		$user->lastname=$data->lastname;
		$user->vid=$data->vid;
		$user->pilot_rating=$data->ratingpilot;
		$user->country=$data->country;
		$user->division=$data->division;
		$user->save();
		return Yii::$app->user->login(new static($user),3600);
	    }
	}
    }
    public function getIsadmin(){
	return in_array($this->vid,Yii::$app->params['adminsvids']);
    }

    public static function findIdentity($id)
    {
        $user=Users::find($id)->one();
	return new static($user);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->vid;
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
