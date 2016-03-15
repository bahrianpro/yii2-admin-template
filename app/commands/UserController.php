<?php
/**
 * @author Skorobogatko Alexei <a.skorobogatko@soft-industry.com>
 * @copyright 2016 Soft-Industry
 * @version $Id$
 */

namespace app\commands;

use Yii;
use yii\console\Exception as ConsoleException;
use app\base\console\Controller;
use app\models\User;

/**
 * Manages users.
 *
 * @author skoro
 */
class UserController extends Controller
{
    
    /**
     * User list.
     * @param string $filter filter: all, enabled, disabled, pending.
     */
    public function actionIndex($filter = 'all')
    {
        $filters = ['all', 'enabled', 'disabled', 'pending'];
        if (!in_array($filter, $filters)) {
            throw new ConsoleException(Yii::t('app', 'Filter accepts values: {values}', ['values' => implode(',', $filters)]));
        }
        
        $users = User::find();
        switch ($filter) {
            case 'enabled':
                $users->where(['status' => User::STATUS_ENABLED]);
                break;
            
            case 'disabled':
                $users->where(['status' => User::STATUS_DISABLED]);
                break;
            
            case 'pending':
                $users->where(['status' => User::STATUS_PENDING]);
                break;
        }
        
        printf("%-32s %-24s %-16s %-8s\n", 'Email address', 'User name', 'Created', 'Status');
        print str_repeat('-', 80) . PHP_EOL;
        
        foreach ($users->all() as $user) {
            printf("%-32s %-24s %-16s %-8s\n",
                    $user->email,
                    $user->name,
                    date('Y-m-d H:i', $user->created_at),
                    User::getStatus($user->status)
            );
        }
    }
    
    /**
     * Creates a new user.
     * @param string $name user name
     * @param string $email user email
     * @param string $password uncrypted password, if skipped random password will be generated.
     */
    public function actionCreate($name, $email, $password = '')
    {
        if (empty($password)) {
            $random = Yii::$app->security->generateRandomString(8);
        }
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->status = User::STATUS_ENABLED;
        $user->setPassword(empty($password) ? $random : $password);
        if ($user->save()) {
            $this->p('User "{name}" has been created.', ['name' => $user->name]);
            if (empty($password)) {
                $this->p('Random password "{password}" has been generated.', ['password' => $random]);
            }
        }
        else {
            $this->err('Couldn\'t create user.');
            foreach ($user->getErrors() as $attribute => $error) {
                print reset($error) . PHP_EOL;
            }
        }
    }
    
    /**
     * Delete a user.
     * @param string $email
     */
    public function actionDelete($email)
    {
        $user = $this->findUser($email);
        if (!$this->confirm('Are you sure to delete user "' . $user->email . '"')) {
            return;
        }
        if ($user->delete()) {
            $this->p('User deleted.');
        }
        else {
            $this->err('Couldn\'t delete user.');
        }
    }
    
    /**
     * Disable user.
     * @param string $email
     */
    public function actionDisable($email)
    {
        $user = $this->findUser($email);
        if ($user->status === User::STATUS_DISABLED) {
            throw new ConsoleException(Yii::t('app', 'User "{email}" already disabled.', compact('email')));
        }
        $user->status = User::STATUS_DISABLED;
        if ($user->save()) {
            $this->p('User "{email}" disabled.', compact('email'));
        }
    }
    
    /**
     * Enable user.
     * @param string $email
     */
    public function actionEnable($email)
    {
        $user = $this->findUser($email);
        if ($user->status === User::STATUS_ENABLED) {
            throw new ConsoleException(Yii::t('app', 'User "{email}" already enabled.', compact('email')));
        }
        $user->status = User::STATUS_ENABLED;
        if ($user->save()) {
            $this->p('User "{email}" enabled.', compact('email'));
        }
    }
    
    /**
     * Change user password.
     * @param string $email
     * @param string $new_password uncrypted password, if skipped random password will be generated.
     */
    public function actionPassword($email, $new_password = '')
    {
        $user = $this->findUser($email);
        if (empty($new_password)) {
            $random = Yii::$app->security->generateRandomString(8);
        }
        $user->setPassword(empty($new_password) ? $random : $new_password);
        if ($user->save()) {
            if (empty($new_password)) {
                $this->p('Password has been changed to random "{random}"', compact('random'));
            } else {
                $this->p('Password has been changed.');
            }
        }
    }
    
    /**
     * Get User model.
     * @param string $email
     * @return User
     * @throws \yii\console\Exception
     */
    protected function findUser($email)
    {
        if (!($user = User::findByEmail($email))) {
            throw new ConsoleException(Yii::t('app', 'User not found.'));
        }
        return $user;
    }
    
}
