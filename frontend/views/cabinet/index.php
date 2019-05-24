<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['action' => ['cabinet/uploadskin'],'options' => ['method' => 'post']]) ?>
<?= $form->field($uploadSkin, 'image')->fileInput() ?>
<button>Загрузить скин</button>
<?php ActiveForm::end() ?>
<?php $form = ActiveForm::begin(['action' => ['cabinet/uploadcloak'],'options' => ['method' => 'post']]) ?>
<?= $form->field($uploadCloak, 'image')->fileInput() ?>
<button>Загрузить плащ</button>
<?php ActiveForm::end() ?>
