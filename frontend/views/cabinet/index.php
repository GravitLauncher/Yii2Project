<?php
use yii\widgets\ActiveForm;
?>
<div id="skin_container"></div>
<script src="js\three.min.js"></script>
<script src="js\skinViewer.js"></script>
<script>
    let skinViewer = new skinview3d.SkinViewer({
        domElement: document.getElementById("skin_container"),
        width: 600,
        height: 600,
        skinUrl: "img/skin.png",
        capeUrl: "img/cape.png"
    });

    // Change the textures
    skinViewer.skinUrl = <?= "\"uploads/skins/".Yii::$app->user->identity->username.".png\"" ?>;
    skinViewer.capeUrl = <?= "\"uploads/cloaks/".Yii::$app->user->identity->username.".png\"" ?>;

    // Resize the skin viewer
    skinViewer.width = 300;
    skinViewer.height = 400;

    // Control objects with your mouse!
    let control = skinview3d.createOrbitControls(skinViewer);
    control.enableRotate = true;
    control.enableZoom = false;
    control.enablePan = false;

    skinViewer.animation = new skinview3d.CompositeAnimation();

    // Add an animation
    let walk = skinViewer.animation.add(skinview3d.WalkingAnimation);
    // Add another animation
    let rotate = skinViewer.animation.add(skinview3d.RotatingAnimation);
    // Remove an animation, stop walking dude
    walk.remove();
    // And run for now!
    let run = skinViewer.animation.add(skinview3d.RunningAnimation);

    // Set the speed of an animation
    run.speed = 3;
    // Pause single animation
    run.paused = true;
    // Pause all animations!
    skinViewer.animationPaused = true;
</script>

<?php $form = ActiveForm::begin(['action' => ['cabinet/uploadskin'],'options' => ['method' => 'post']]) ?>
<?= $form->field($uploadSkin, 'imageFile')->fileInput() ?>
<button>Загрузить скин</button>
<?php ActiveForm::end() ?>
<?php $form = ActiveForm::begin(['action' => ['cabinet/uploadcloak'],'options' => ['method' => 'post']]) ?>
<?= $form->field($uploadCloak, 'imageFile')->fileInput() ?>
<button>Загрузить плащ</button>
<?php ActiveForm::end() ?>
