<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Permission groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-group-view">

    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><?= $this->title ?></h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">

                    <p>
                        <?= Html::a(UserManagementModule::t('back', 'Edit'), ['update', 'id' => $model->code], ['class' => 'btn btn-sm btn-primary']) ?>
                        <?= Html::a(UserManagementModule::t('back', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
                        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->code], [
                            'class' => 'btn btn-sm btn-danger pull-right',
                            'data' => [
                                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name',
                            'code',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
