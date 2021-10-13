<?php
/**
 * @var $this yii\web\View
 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<div class="container" id="login-wrapper">
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2"><?= UserManagementModule::t('front', 'Authorization') ?></h1>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">

                                    <?php $form = ActiveForm::begin([
                                        'id' => 'login-form',
                                        'options' => ['autocomplete' => 'off'],
                                        'validateOnBlur' => false,
                                        'fieldConfig' => [
                                            'template' => "{input}\n{error}",
                                        ],
                                    ]) ?>

                                    <div class="mb-3">
                                        <label class="form-label"><?= UserManagementModule::t('front', 'Username') ?></label>
                                        <?= $form->field($model, 'username')
                                            ->textInput(
                                                [
                                                    'placeholder' => $model->getAttributeLabel('username'),
                                                    'autocomplete' => 'off'
                                                ]) ?>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><?= UserManagementModule::t('front', 'Password') ?></label>
                                        <?= $form->field($model, 'password')
                                            ->passwordInput(
                                                [
                                                    'placeholder' => $model->getAttributeLabel('password'),
                                                    'autocomplete' => 'off'
                                                ]) ?>
                                    </div>

                                    <?= (isset(Yii::$app->user->enableAutoLogin) && Yii::$app->user->enableAutoLogin) ? $form->field($model, 'rememberMe')->checkbox(['value' => true]) : '' ?>

                                    <div class="text-center mt-3">
                                        <?= Html::submitButton(
                                            UserManagementModule::t('front', 'Login'),
                                            ['class' => 'btn btn-lg btn-primary btn-block']
                                        ) ?>
                                    </div>

                                    <?php ActiveForm::end() ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</div>