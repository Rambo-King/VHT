<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
$this->title = 'Order Quick';
?>
<div class="content">
    <h1>Order Quick</h1>
<div class="bs-example2 order-quick">


    <div class="bs-example mailing-address">
        <?= Select2::widget([
            'name' => 'mailing-address',
            'data' => [1, 2, 3],
            'size' => Select2::MEDIUM,
            'options' => ['placeholder' => 'Select a address ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
        <?= Html::a('Add Mailing Address', '#', [
            'id' => 'create',
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
        ]);
        ?>
    </div>

    <div class="bs-example receiving-address">
        <?= Select2::widget([
            'name' => 'mailing-address',
            'data' => [1, 2, 3],
            'size' => Select2::MEDIUM,
            'options' => ['placeholder' => 'Select a address ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
        <?= Html::a('Add Receiving Address', '#', [
            'id' => 'create',
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'class' => 'btn btn-success',
        ]);
        ?>
    </div>

    <div class="bs-example2 product clearFix">
        <div class="product-piece-wrapper">
            <?php for($i = 1; $i<=10; $i++): ?>
            <div class="productPiece clearFix <?= $i==1 ? 'show' : 'hide' ?>">
                <input name="" class="pName" title="Name" placeholder="Name *">
                <input name="" class="pLength" title="Length" placeholder="Length *">
                <input name="" class="pWidth" title="Width" placeholder="Width *">
                <input name="" class="pHeight" title="Height" placeholder="Height *">
                <div class="unit-select">
                    <?= Select2::widget([
                        'hideSearch' => true,
                        'name' => '',
                        'data' => ['cm', 'cm2'],
                        'size' => 'sm',
                    ]) ?>
                </div>
                <input name="" class="pWeight" title="Weight" placeholder="Weight *">
                <div class="unit-select">
                    <?= Select2::widget([
                        'hideSearch' => true,
                        'name' => '',
                        'data' => ['kg', 'kg2'],
                        'size' => Select2::SMALL,
                    ]) ?>
                </div>
                <input name="" class="pQty" title="Quantity" placeholder="Quantity *">
                <input name="" class="pDes notRequired" title="Description" placeholder="Description">
                <div class="product-actions">
                    <a href="javascript:;" class="addAnchor" onclick="AddRow(this)" title="Add"></a>
                    <a href="javascript:;" class="removeAnchor hide" onclick="RemoveRow(this)" title="Remove"></a>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>

    <div class="commit">
        <?= Html::a('Order Commit', '#', [
            'id' => 'create',
            'data-toggle' => 'modal',
            'data-target' => '#commit-modal',
            'class' => 'btn btn-success',
        ]);
        ?>
    </div>

    <?php
    Modal::begin([
        'id' => 'create-modal',
        'header' => '<h4 class="modal-title">Add Mailing Address</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
    ]);
    echo 'Say hello... waybill';
    Modal::end();
    Modal::begin([
        'id' => 'commit-modal',
        'header' => '<h4 class="modal-title">Title</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
    ]);
    echo 'Developing....';
    Modal::end();
    ?>
</div>

</div>
<?php
$this->registerCssFile('css/quick.css', ['depends' => 'app\assets\AppAsset']);
?>
<script type="text/javascript">
    function AddRow(obj){
        var row = $(obj).parent().parent().siblings('.hide').first();
        row.removeClass('hide').addClass('show');

        var show = $('.productPiece.show');
        show.find('.product-actions').find('a.removeAnchor').removeClass('hide');
        show.find('.product-actions').find('a.addAnchor').addClass('hide');
        if($('.productPiece.hide').length > 0){
            show.last().find('.product-actions').find('a.addAnchor').removeClass('hide');
        }
    }

    function RemoveRow(obj){
        if($('.productPiece.show').length == 1){ return; }

        $(obj).parent().parent().addClass('hide').removeClass('show');

        var show = $('.productPiece.show');
        if($('.productPiece.show').length > 1){
            show.last().find('.product-actions').find('a.addAnchor').removeClass('hide');
        }else{
            show.last().find('.product-actions').find('a.addAnchor').removeClass('hide');
            show.last().find('.product-actions').find('a.removeAnchor').addClass('hide');
        }
    }

    function Check(){
        var flag = true;
        var inputs = $('.product-piece-wrapper input:visible');
        inputs.each(function(k, i){
            if(!$(this).hasClass('notRequired')){
                if($(this).val().trim() == ''){
                    $(this).addClass('error');
                    flag = false;
                }
            }
        });
        if(flag){
            //提交
        }
    }
</script>