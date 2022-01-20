<?php

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\rbacDB\search\AuthItemGroupSearch $searchModel
 */

$this->title = UserManagementModule::t('back', 'Permission groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-group-index">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">

            <p>
                <?= GhostHtml::a(
                    '<i class="align-middle" data-feather="check-circle"></i>&nbsp;' . UserManagementModule::t('back', 'Create'),
                    ['create'],
                    ['class' => 'btn btn-success']
                ) ?>
            </p>

            <div class="row">


                <div class="col-12">
                    <?php Pjax::begin([
                        'id' => 'auth-item-group-grid-pjax',
                    ]) ?>

                    <?= GridView::widget([
                        'id' => 'auth-item-group-grid',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'bsVersion' => '4.x',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:10px']],
                            [
                                'attribute' => 'name',
                                'value' => function ($model) {
                                    return Html::a($model->name, ['update', 'id' => $model->code], ['data-pjax' => 0]);
                                },
                                'format' => 'raw',
                                'width' => '30%'
                            ],
                            'code',
                            [
                                'class' => 'yii\grid\ActionColumn',
                            ],
                        ],
                    ]); ?>

                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>
