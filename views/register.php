<?php
// for IDE search purposes
/** @var $model \app\models\User */

use \app\core\form\Form;
?>

<h1>Register</h1>

<?php $form = Form::begin('', 'post') ?>
    <div class="row">
        <div class="col">
            <?php echo $form->field($model, 'first_name') ?>
        </div>
        <div class="col">
            <?php echo $form->field($model, 'last_name') ?>
        </div>
    </div>
    <?php echo $form->field($model, 'email') ?>
    <?php echo $form->field($model, 'password')->passwordField() ?>
    <?php echo $form->field($model, 'password2')->passwordField() ?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>