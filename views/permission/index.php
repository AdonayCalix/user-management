<?php

use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;
use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\AuthItemGroup;
use webvimark\modules\UserManagement\models\rbacDB\Permission;
use webvimark\modules\UserManagement\UserManagementModule;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\rbacDB\search\PermissionSearch $searchModel
 * @var yii\web\View $this
 */
$this->title = UserManagementModule::t('back', 'Permissions');
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
            <div class="col-12">
                <?php Pjax::begin([
                    'id' => 'permission-grid-pjax',
                ]) ?>

                <?= GridView::widget([
                    'id' => 'permission-grid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'headerContainer' => ['class' => ''],
                    'condensed' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:10px']],

                        [
                            'attribute' => 'description',
                            'value' => function ($model) {
                                if ($model->name == Yii::$app->getModule('user-management')->commonPermissionName) {
                                    return Html::a(
                                        $model->description,
                                        ['view', 'id' => $model->name],
                                        ['data-pjax' => 0, 'class' => 'label label-primary']
                                    );
                                } else {
                                    return Html::a($model->description, ['view', 'id' => $model->name], ['data-pjax' => 0]);
                                }
                            },
                            'format' => 'raw',
                        ],
                        'name',
                        [
                            'attribute' => 'group_code',
                            'filter' => ArrayHelper::map(AuthItemGroup::find()->asArray()->all(), 'code', 'name'),
                            'value' => function (Permission $model) {
                                return $model->group_code ? $model->group->name : '';
                            },
                        ],
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

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>


