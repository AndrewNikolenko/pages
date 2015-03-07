<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\ArrayHelper;
    use kartik\depdrop\DepDrop;
    use yii\helpers\Url;
    use yii\helpers\Json;
?>
<?php $catList=ArrayHelper::map(app\modules\pages\models\Category::find()->asArray()->all(), 'id', 'name'); ?>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => 1, 'id' => 'dropdown-form']]); ?>
    <?php echo $form->field($model, 'id')->dropDownList($catList, ['id'=>'cat-id']); ?>
    <?php
        echo $form->field($model, 'id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'subcat-id'],
            'pluginOptions'=>[
                'depends'=>['cat-id'],
                'placeholder'=>'Select...',
                'url'=>Url::to(['/pages/admin/subcat'])
            ]
        ]);
    ?>
<?php ActiveForm::end(); ?>
<div class="test">

</div>