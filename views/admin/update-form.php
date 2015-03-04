<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;
    use vova07\imperavi\Widget;
?>
<?php $form = ActiveForm::begin(['id' => 'update-form']); ?>
<?= $form->field($model, 'filename') ?>
<?= $form->field($model, 'filecontent')->textArea(['id' => 'staticPageContent'])->widget(Widget::className(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 200,
        'imageUpload' => Url::to(['/pages/main/image-upload']),
        'imageManagerJson' => Url::to(['/pages/main/images-get']),
        'fileUpload' => Url::to(['/pages/main/file-upload']),
        'fileManagerJson' => Url::to(['/pages/main/files-get']),
        'plugins' => [
            'clips',
            'fullscreen',
            'imagemanager',
            'filemanager',
            'table',
            'video',
            'fontcolor',
            'fontsize',
        ],
        'buttons' => ['html', 'formatting', 'bold', 'italic', 'deleted',
            'unorderedlist', 'orderedlist', 'outdent', 'indent',
            'image', 'file', 'link', 'alignment', 'horizontalrule'],
        'buttonSource' => true,
    ]
]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'saveChanges'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>
<?php ActiveForm::end(); ?>