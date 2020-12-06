<?php
// for search and autocomplete purposes (IDE feature)
/** @var $this \app\core\View */
/** @var $model \app\models\ContactForm */

use \app\core\form\Form;
use \app\core\form\TextareaField;

$this->title = 'Contact';
?>

<h1>Contact Us</h1>

<?php $form = Form::begin('', 'post') ?>
    <?= $form->field($model, 'subject') ?>
    <?= $form->field($model, 'email') ?>
    <?= new TextareaField($model, 'body') ?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>
