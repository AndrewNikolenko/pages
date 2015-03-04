<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
    use app\modules\pages\models as models;
    use yii\bootstrap\ActiveForm;
    use kartik\sortinput\SortableInput;
    use yii\widgets\Pjax;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
?>
<div class="col span_4_of_12 systemPages">
    <h1><?=Yii::t('admin', 'System pages'); ?></h1>
    <?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => Yii::t('admin', 'createPage'), 'class'=>'createPageLink', 'url' => ['/page/create'], 'linkOptions' => ['class'=>'createPageLink']],
        ],
    ]);
    ?>
    <h1><?=Yii::t('admin', 'inactive'); ?></h1>
    <?php Pjax::begin(['id'=>'inactivePagesContainer']) ?>
    <?php
    echo SortableInput::widget([
        'name'=>'pages',
        'items' => $inactiveItems,
        'hideInput' => true,
        'sortableOptions' => [
            'connected'=>true,
        ],
        'options' => ['class'=>'form-control', 'readonly'=>true]
    ]);
    ?>
    <?php Pjax::end() ?>
</div>
<div class="col span_4_of_12 allPages">
    <h1><?=Yii::t('admin', 'Pages'); ?></h1>
    <?php Pjax::begin(['id'=>'allPagesContainer']) ?>
    <?php
        echo SortableInput::widget([
            'name'=>'pages',
            'items' => $items,
            'hideInput' => true,
            'sortableOptions' => [
                'connected'=>true,
            ],
            'options' => ['class'=>'form-control', 'readonly'=>true]
        ]);
    ?>
    <?php Pjax::end() ?>
</div>
<div class="col span_4_of_12 menuPages">
    <h1><?=Yii::t('admin', 'Menu'); ?></h1>
    <?php Pjax::begin(['id'=>'menuContainer']) ?>
    <?php
        echo SortableInput::widget([
            'name'=>'menu',
            'id'=>'menu',
            'items' => $menuItems,
            'hideInput' => true,
            'sortableOptions' => [
                'itemOptions'=>['class'=>'alert alert-warning dropMenu'],
                'connected'=>true,
            ],
            'options' => ['class'=>'form-control', 'readonly'=>true]
        ]);
    ?>
    <?php Pjax::end() ?>
    <button id="saveMenu" class="btn btn-primary">Сохранить меню</button>
</div>
<div class="col span_12_of_12 formContainer" id="formContainer"></div>