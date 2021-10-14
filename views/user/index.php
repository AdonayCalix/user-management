<?php

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\UserManagement\models\search\UserSearch $searchModel
 */

$this->title = UserManagementModule::t('back', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="mb-3">
        <h3 class="h3 d-inline align-middle"><?= $this->title ?></h3>
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

			<?php Pjax::begin([
				'id'=>'user-grid-pjax',
			]) ?>

			<?= GridView::widget([
				'id'=>'user-grid',
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
                'bsVersion' => '4.x',
				'columns' => [
					['class' => 'yii\grid\SerialColumn', 'options'=>['style'=>'width:10px'] ],

					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'superadmin',
						'visible'=>Yii::$app->user->isSuperadmin,
					],

					[
						'attribute'=>'username',
						'value'=>function(User $model){
								return Html::a($model->username,['view', 'id'=>$model->id],['data-pjax'=>0]);
							},
						'format'=>'raw',
					],
					[
						'value'=>function(User $model){
								return GhostHtml::a(
									UserManagementModule::t('back', 'Roles and permissions'),
									['/user-management/user-permission/set', 'id'=>$model->id],
									['class'=>'btn btn-sm btn-primary', 'data-pjax'=>0]);
							},
						'format'=>'raw',
						'visible'=>User::canRoute('/user-management/user-permission/set'),
						'options'=>[
							'width'=>'20%',
						],
					],
					[
						'value'=>function(User $model){
								return GhostHtml::a(
									UserManagementModule::t('back', 'Change password'),
									['change-password', 'id'=>$model->id],
									['class'=>'btn btn-sm bg-white btn-default', 'data-pjax'=>0]);
							},
						'format'=>'raw',
						'options'=>[
							'width'=>'20%',
						],
					],
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'status',
						'optionsArray'=>[
							[User::STATUS_ACTIVE, UserManagementModule::t('back', 'Active'), 'success'],
							[User::STATUS_INACTIVE, UserManagementModule::t('back', 'Inactive'), 'warning'],
							[User::STATUS_BANNED, UserManagementModule::t('back', 'Banned'), 'danger'],
						],
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

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>
