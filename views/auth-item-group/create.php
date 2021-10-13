<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup $model
 */

$this->title = UserManagementModule::t('back', 'Creating permission group');
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Permission groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-group-create">

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

</div>
