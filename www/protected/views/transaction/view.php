<?php
$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Transaction', 'url'=>array('index')),
	array('label'=>'Create Transaction', 'url'=>array('create')),
	array('label'=>'Update Transaction', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Transaction', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Transaction', 'url'=>array('admin')),
);
?>

<h1>View Transaction #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'order_id',
		'type',
		'vcs_terminal_id',
		'vcs_reference_number',
		'vcs_response',
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
	),
)); ?>
