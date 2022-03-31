<?php

use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;
use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\UserManagementModule;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\rbacDB\search\RoleSearch $searchModel
 * @var yii\web\View $this
 */
$this->title = UserManagementModule::t('back', 'Roles');
$this->params['breadcrumbs'][] = $this->title;

?>

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
            <?php Pjax::begin([
                'id' => 'role-grid-pjax',
            ]) ?>
            <?= GridView::widget([
                'id' => 'role-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'responsive' => true,
                'headerContainer' => ['class' => ''],
                'hover' => true,
                'bsVersion' => '4.x',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:10px']],

                    [
                        'attribute' => 'description',
                        'value' => function (Role $model) {
                            return Html::a($model->description, ['view', 'id' => $model->name], ['data-pjax' => 0]);
                        },
                        'format' => 'raw',
                    ],
                    'name',
                    [
                        'class' => 'yii\grid\ActionColumn'
                    ],
                ],
            ]); ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>

