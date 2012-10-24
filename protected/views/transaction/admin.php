<?php
$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Transaction', 'url'=>array('index')),
	array('label'=>'Create Transaction', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('transaction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transactions</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'transaction-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'order_id',
		'type',
		'vcs_terminal_id',
		'vcs_reference_number',
		'vcs_response',
		/*
		'vcs_duplicate',
		'vcs_cardholder_name',
		'vcs_amount',
		'vcs_card_type',
		'vcs_description_of_goods',
		'vcs_cardholder_email_address',
		'vcs_budget_period',
		'vcs_expiry_date',
		'vcs_response_code',
		'vcs_personal_authentication_message',
		'vcs_m_1',
		'vcs_m_2',
		'vcs_m_3',
		'vcs_m_4',
		'vcs_m_5',
		'vcs_m_6',
		'vcs_m_7',
		'vcs_m_8',
		'vcs_m_9',
		'vcs_m_10',
		'vcs_cardholder_ip_address',
		'vcs_masked_card_number',
		'vcs_transaction_type',
		'vcs_hash',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
