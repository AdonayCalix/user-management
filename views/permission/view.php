<?php
/**
 * @var $this yii\web\View
 * @var yii\widgets\ActiveForm $form
 * @var array $routes
 * @var array $childRoutes
 * @var array $permissionsByGroup
 * @var array $childPermissions
 * @var yii\rbac\Permission $item
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = UserManagementModule::t('back', 'Settings for permission') . ': ' . $item->description;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
        </div>

        <p>
            <?= GhostHtml::a(UserManagementModule::t('back', 'Edit'), ['update', 'id' => $item->name], ['class' => 'btn btn-sm btn-primary']) ?>
            <?= GhostHtml::a(UserManagementModule::t('back', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
        </p>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <strong>
                            <h5 class="card-title"><?= UserManagementModule::t('back', 'Child permissions') ?></h5>
                        </strong>
                    </div>
                    <div class="card-body">

                        <?= Html::beginForm(['set-child-permissions', 'id' => $item->name]) ?>

                        <div class="row">
                            <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                                <div class="col-sm-12">
                                    <fieldset>
                                        <legend> <strong>
                                                <h5 class="card-title"><?= $groupName ?></h5>
                                            </strong></legend>

                                        <?php foreach ($permissions as $permission): ?>
                                            <label>
                                                <?php $isChecked = in_array($permission->name, ArrayHelper::map($childPermissions, 'name', 'name')) ? 'checked' : '' ?>
                                                <input type="checkbox" <?= $isChecked ?> name="child_permissions[]"
                                                       value="<?= $permission->name ?>">
                                                <?= $permission->description ?>
                                            </label>

                                            <?= GhostHtml::a(
                                            '&nbsp;<i class="align-middle" data-feather="edit-3"></i>',
                                            ['view', 'id' => $permission->name],
                                            ['target' => '_blank']
                                        ) ?>
                                            <br/>
                                        <?php endforeach ?>

                                    </fieldset>
                                    <br/>
                                </div>

                            <?php endforeach ?>
                        </div>

                        <hr/>
                        <?= Html::submitButton(
                            '<i class="align-middle" data-feather="check-circle"></i>&nbsp;' . UserManagementModule::t('back', 'Save'),
                            ['class' => 'btn btn-primary btn-sm']
                        ) ?>

                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <strong>

                            <?= Html::a(
                                UserManagementModule::t('back', 'Refresh routes (and delete unused)'),
                                ['refresh-routes', 'id' => $item->name, 'deleteUnused' => 1],
                                [
                                    'class' => 'btn btn-outline-primary btn-sm pull-right',
                                    'style' => 'margin-top:-5px; text-transform:none;',
                                    'data-confirm' => UserManagementModule::t('back', 'Routes that are not exists in this application will be deleted. Do not recommended for application with "advanced" structure, because frontend and backend have they own set of routes.'),
                                ]
                            ) ?>

                            <?= Html::a(
                                UserManagementModule::t('back', 'Refresh routes'),
                                ['refresh-routes', 'id' => $item->name],
                                [
                                    'class' => 'btn btn-outline-primary btn-sm pull-right',
                                    'style' => 'margin-top:-5px; text-transform:none;',
                                ]
                            ) ?>

                        </strong>
                    </div>

                    <div class="card-body">

                        <?= Html::beginForm(['set-child-routes', 'id' => $item->name]) ?>

                        <div class="row">
                            <div class="col-md-3">
                                <?= Html::submitButton(
                                    '<i class="align-middle" data-feather="check-circle"></i>&nbsp;' . UserManagementModule::t('back', 'Save'),
                                    ['class' => 'btn btn-primary btn-sm']
                                ) ?>
                            </div>

                            <div class="col-md-7">
                                <input id="search-in-routes" autofocus="on" type="text" class="form-control"
                                       placeholder="<?= UserManagementModule::t('back', 'Search route'); ?>">
                            </div>

                            <div class="col-md-2">
                                <span id="show-only-selected-routes" class="btn btn-outline-primary btn-sm">Hide</span>
                                <span id="show-all-routes" class="btn btn-outline-primary btn-sm"
                                      style="display: none">Show</span>
                            </div>
                        </div>

                        <hr/>

                        <?= Html::checkboxList(
                            'child_routes',
                            ArrayHelper::map($childRoutes, 'name', 'name'),
                            ArrayHelper::map($routes, 'name', 'name'),
                            [
                                'id' => 'routes-list',
                                'separator' => '<div class="separator"></div>',
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return Html::checkbox($name, $checked, [
                                        'value' => $value,
                                        'label' => '<span class="route-text">' . $label . '</span>',
                                        'labelOptions' => ['class' => 'route-label'],
                                        'class' => 'route-checkbox hide',
                                    ]);
                                },
                            ]
                        ) ?>

                        <hr/>
                        <?= Html::submitButton(
                            '<i class="align-middle" data-feather="check-circle"></i>&nbsp;' . UserManagementModule::t('back', 'Save'),
                            ['class' => 'btn btn-primary btn-sm']
                        ) ?>

                        <?= Html::endForm() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS

var routeCheckboxes = $('.route-checkbox');
var routeText = $('.route-text');

// For checked routes
var backgroundColor = '#D6FFDE';

function showAllRoutesBack() {
	$('#routes-list').find('.hide').each(function(){
		$(this).show();
	});
}

//Make tree-like structure by padding controllers and actions
routeText.each(function(){
	var _t = $(this);

	var chunks = _t.html().split('/').reverse();
	var margin = chunks.length * 40 - 40;

	if ( chunks[0] == '*' )
	{
		margin -= 40;
	}

	_t.closest('label').css('margin-left', margin);

});

// Highlight selected checkboxes
routeCheckboxes.each(function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('label').css('background', backgroundColor);
	}
});

// Change background on check/uncheck
routeCheckboxes.on('change', function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('label').css('background', backgroundColor);
	}
	else
	{
		_t.closest('label').css('background', 'none');
	}
});


// Hide on not selected routes
$('#show-only-selected-routes').on('click', function(){
	$(this).hide();
	$('#show-all-routes').show();

	routeCheckboxes.each(function(){
		var _t = $(this);

		if ( ! _t.is(':checked') )
		{
			_t.closest('label').hide();
			_t.closest('label').addClass('hide');
			_t.closest('div.separator').hide();
			_t.closest('div.separator').addClass('hide');
		}
	});
});

// Show all routes back
$('#show-all-routes').on('click', function(){
	$(this).hide();
	$('#show-only-selected-routes').show();

	showAllRoutesBack();
});

// Search in routes and hide not matched
$('#search-in-routes').on('change keyup', function(){
	var input = $(this);

	if ( input.val() == '' )
	{
		showAllRoutesBack();
		return;
	}

	routeText.each(function(){
		var _t = $(this);

		if ( _t.html().indexOf(input.val()) > -1 )
		{
			_t.closest('label').show();
			_t.closest('label').removeClass('hide');
			_t.closest('div.separator').show();
			_t.closest('div.separator').removeClass('hide');
		}
		else
		{
			_t.closest('label').hide();
			_t.closest('label').addClass('hide');
			_t.closest('div.separator').hide();
			_t.closest('div.separator').addClass('hide');
		}
	});
});

JS;

$this->registerJs($js);
?>