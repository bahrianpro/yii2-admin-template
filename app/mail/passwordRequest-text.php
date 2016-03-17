<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/password-reset', 'token' => $user->reset_token]);
?>
Hello <?= $user->name ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
