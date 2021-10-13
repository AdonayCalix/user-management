<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\UserVisitLog $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Visit log'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-visit-log-view">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= 'Registro: ' . $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'user_id',
                                'value' => @$model->user->username,
                            ],
                            'ip',
                            'language',
                            'os',
                            'browser',
                            'user_agent',

                            'visit_time:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
