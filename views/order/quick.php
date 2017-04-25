<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use app\models\Unit;

$this->title = 'Order Quick';
?>
<div class="content">
    <h1>Order Quick</h1>

    <?php
    if(Yii::$app->session->hasFlash('error')){
        echo '<div class="alert alert-warning">'.Yii::$app->session->getFlash('error').'</div>';
    }
    ?>

    <div class="bs-example2 order-quick">
        <?php $form = ActiveForm::begin([
            'id' => 'order-form',
            /*'enableAjaxValidation' => true,
            'validationUrl' => \yii\helpers\Url::toRoute(['validate-form']),*/
        ]); ?>

        <div class="bs-example mailing-address">
            <?= Html::dropDownList('mailing-address', null,
                \app\models\AddressBook::BookList(Yii::$app->user->identity->getId(), 1),
                ['class' => 'address-select']
            ) ?>
            <?/*= Select2::widget([
                'name' => 'mailing-address',
                'data' => \app\models\AddressBook::BookList(Yii::$app->user->identity->getId(), 1),
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => 'Select a Address ...'],
            ]) */?>
            <?= Html::a('Add Mailing Address', '#', [
                'id' => 'mailing-create',
                'data-toggle' => 'modal',
                'data-target' => '#address-modal',
                'data-url' => \yii\helpers\Url::toRoute(['/book/modal-create']),
                'data-title' => 'Add Mailing Address',
                'data-type' => 1,
                'class' => 'modalDialog btn btn-success',
            ]);
            ?>
        </div>

        <div class="bs-example receiving-address">
            <?= Html::dropDownList('receiving-address', null,
                \app\models\AddressBook::BookList(Yii::$app->user->identity->getId(), 2),
                ['class' => 'address-select']
            ) ?>
            <?= Html::a('Add Receiving Address', '#', [
                'id' => 'receiving-create',
                'data-toggle' => 'modal',
                'data-target' => '#address-modal',
                'data-url' => \yii\helpers\Url::toRoute(['/book/modal-create']),
                'data-title' => 'Add Receiving Address',
                'data-type' => 2,
                'class' => 'modalDialog btn btn-success',
            ]);
            ?>
        </div>

        <div class="bs-example2 product clearFix">
            <div class="product-piece-wrapper">
                <?php for($i = 1; $i<=10; $i++): ?>
                <div class="productPiece clearFix <?= $i==1 ? 'show' : 'hide' ?>">
                    <input name="name[]" class="pName" title="Name" placeholder="Name *" <?= $i==1 ? '' : 'disabled' ?>>
                    <input name="length[]" class="pLength float" title="Length" placeholder="Length *" <?= $i==1 ? '' : 'disabled' ?>>
                    <input name="width[]" class="pWidth float" title="Width" placeholder="Width *" <?= $i==1 ? '' : 'disabled' ?>>
                    <input name="height[]" class="pHeight float" title="Height" placeholder="Height *" <?= $i==1 ? '' : 'disabled' ?>>
                    <div class="unit-select">
                        <?= Select2::widget([
                            'hideSearch' => true,
                            'name' => 'length-unit[]',
                            'data' => Unit::UnitList(1),
                            'size' => 'sm',
                            'options' => ['disabled' => ($i==1 ? false : true)]
                        ]) ?>
                    </div>
                    <input name="weight[]" class="pWeight float" title="Weight" placeholder="Weight *" <?= $i==1 ? '' : 'disabled' ?>>
                    <div class="unit-select">
                        <?= Select2::widget([
                            'hideSearch' => true,
                            'name' => 'weight-unit[]',
                            'data' => Unit::UnitList(2),
                            'size' => Select2::SMALL,
                            'options' => ['disabled' => ($i==1 ? false : true)]
                        ]) ?>
                    </div>
                    <input name="qty[]" class="pQty" title="Quantity" placeholder="Quantity *" <?= $i==1 ? '' : 'disabled' ?>>
                    <input name="des[]" class="pDes" title="Description" placeholder="Description" <?= $i==1 ? '' : 'disabled' ?>>
                    <div class="product-actions">
                        <a href="javascript:;" class="addAnchor" onclick="AddRow(this)" title="Add"></a>
                        <a href="javascript:;" class="removeAnchor hide" onclick="RemoveRow(this)" title="Remove"></a>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <div class="commit clearBoth">
            <?= Html::submitButton('Order Commit', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php
        Modal::begin([
            'size' => Modal::SIZE_LARGE,
            'id' => 'address-modal',
            'header' => '<h4 class="modal-title"></h4>',
            'options' => ['tabindex' => false]
        ]);
        Modal::end();
        ?>
    </div>

</div>
<?php
$this->registerCssFile('css/quick.css', ['depends' => 'app\assets\AppAsset']);
$script = <<<JS
    _InputCheck();
    $('.modalDialog').on('click', function(){
        $('#address-modal').find('.modal-title').text($(this).attr('data-title'));
        $.get($(this).attr('data-url'), {'type': $(this).attr('data-type')}, function(data){
            $('#address-modal').find('.modal-body').html(data);
        });
    });
    $('select[name="mailing-address"]').change(function(){
        $('div.mailing-address').removeClass('has-error');
    });
    $('select[name="receiving-address"]').change(function(){
        $('div.receiving-address').removeClass('has-error');
    });
    $('form#order-form').on('beforeSubmit', function(){
        var flag = true;
        if($('select[name="mailing-address"]').val() == ''){
            $('div.mailing-address').addClass('has-error');
            flag = false;
        }
        if($('select[name="receiving-address"]').val() == ''){
            $('div.receiving-address').addClass('has-error');
            flag = false;
        }
        var inputs = $('.product-piece-wrapper input:visible');
        inputs.each(function(){
            if(!$(this).hasClass('pDes')){
                var val = $(this).val().trim();
                if(val == ''){
                    $(this).addClass('error');
                    flag = false;
                }else{
                    if($(this).hasClass('float')){
                        var FloatReg = /^[0-9]+.?[0-9]*$/;
                        if(!FloatReg.test(val)){
                            $(this).addClass('error');
                            flag = false;
                        }
                    }else if($(this).hasClass('pQty')){
                        var IntegerReg = /^[1-9]+[0-9]*]*$/;
                        if(!IntegerReg.test(val)){
                            $(this).addClass('error');
                            flag = false;
                        }
                    }
                }
            }
        });
        if(flag){
            $(this).submit();
        }
    }).on('submit', function(e){
        e.preventDefault();
    });
JS;
$this->registerJs($script);
?>
<script type="text/javascript">
    function _InputCheck(){
        var inputs = $('.product-piece-wrapper input:visible');
        inputs.blur(function(){
            if(!$(this).hasClass('pDes')){
                var val = $(this).val().trim();
                if(val != ''){
                    if($(this).hasClass('pName')){
                        $(this).removeClass('error');
                    }else if($(this).hasClass('float')){
                        var FloatReg = /^[0-9]+.?[0-9]*$/;
                        if(FloatReg.test(val)){
                            $(this).removeClass('error');
                        }else{
                            $(this).addClass('error');
                        }
                    }else if($(this).hasClass('pQty')){
                        var IntegerReg = /^[1-9]+[0-9]*]*$/;
                        if(IntegerReg.test(val)){
                            $(this).removeClass('error');
                        }else{
                            $(this).addClass('error');
                        }
                    }
                }else{
                    $(this).addClass('error');
                }
            }
        });
    }

    function AddRow(obj){
        var row = $(obj).parent().parent().siblings('.hide').first();
        row.removeClass('hide').addClass('show');
        row.find('input').attr('disabled', false);
        row.find('select').attr('disabled', false);

        var show = $('.productPiece.show');
        show.find('.product-actions').find('a.removeAnchor').removeClass('hide');
        show.find('.product-actions').find('a.addAnchor').addClass('hide');
        if($('.productPiece.hide').length > 0){
            show.last().find('.product-actions').find('a.addAnchor').removeClass('hide');
        }
        _InputCheck();
    }

    function RemoveRow(obj){
        if($('.productPiece.show').length == 1){ return; }

        var row = $(obj).parent().parent();
        row.addClass('hide').removeClass('show');
        row.find('input').attr('disabled', true);
        row.find('select').attr('disabled', true);

        var show = $('.productPiece.show');
        if($('.productPiece.show').length > 1){
            show.last().find('.product-actions').find('a.addAnchor').removeClass('hide');
        }else{
            show.last().find('.product-actions').find('a.addAnchor').removeClass('hide');
            show.last().find('.product-actions').find('a.removeAnchor').addClass('hide');
        }
        _InputCheck();
    }
</script>