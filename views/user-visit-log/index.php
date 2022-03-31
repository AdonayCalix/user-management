<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\search\UserVisitLogSearch $searchModel
 */

$this->title = UserManagementModule::t('back', 'Visit log');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-visit-log-index">

    <div class="mb-3">
        <h3 class="h3 d-inline align-middle"><?= $this->title ?></h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">

                    <?php Pjax::begin([
                        'id' => 'user-visit-log-grid-pjax',
                    ]) ?>

                    <?= GridView::widget([
                        'id' => 'user-visit-log-grid',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'floatHeader' => true,
                        'headerContainer' => ['class' => ''],
                        'condensed' => true,
                        'floatHeaderOptions' => ['top' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:10px']],

                            [
                                'attribute' => 'user_id',
                                'value' => function ($model) {
                                    return Html::a(@$model->user->username, ['view', 'id' => $model->id], ['data-pjax' => 0]);
                                },
                                'format' => 'raw',
                            ],
                            'language',
                            'os',
                            'browser',
                            array(
                                'attribute' => 'ip',
                                'value' => function ($model) {
                                    return Html::a($model->ip, "http://ipinfo.io/" . $model->ip, ["target" => "_blank"]);
                                },
                                'format' => 'raw',
                            ),
                            'visit_time:datetime',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                                'contentOptions' => ['style' => 'width:70px; text-align:center;'],
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
