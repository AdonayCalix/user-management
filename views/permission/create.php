<?php
/**
 *
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var webvimark\modules\UserManagement\models\rbacDB\Permission $model
 */

use webvimark\modules\UserManagement\UserManagementModule;

$this->title = UserManagementModule::t('back', 'Permission creation');
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mb-3">
    <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <?= $this->render('_form', compact('model')) ?>
            </div>
        </div>
    </div>
</div>