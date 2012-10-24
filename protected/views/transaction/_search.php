<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_terminal_id'); ?>
		<?php echo $form->textField($model,'vcs_terminal_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_reference_number'); ?>
		<?php echo $form->textField($model,'vcs_reference_number',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_response'); ?>
		<?php echo $form->textField($model,'vcs_response',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_duplicate'); ?>
		<?php echo $form->textField($model,'vcs_duplicate',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_cardholder_name'); ?>
		<?php echo $form->textField($model,'vcs_cardholder_name',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_amount'); ?>
		<?php echo $form->textField($model,'vcs_amount',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_card_type'); ?>
		<?php echo $form->textField($model,'vcs_card_type',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_description_of_goods'); ?>
		<?php echo $form->textField($model,'vcs_description_of_goods',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_cardholder_email_address'); ?>
		<?php echo $form->textField($model,'vcs_cardholder_email_address',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_budget_period'); ?>
		<?php echo $form->textField($model,'vcs_budget_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_expiry_date'); ?>
		<?php echo $form->textField($model,'vcs_expiry_date',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_response_code'); ?>
		<?php echo $form->textField($model,'vcs_response_code',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_personal_authentication_message'); ?>
		<?php echo $form->textField($model,'vcs_personal_authentication_message',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_1'); ?>
		<?php echo $form->textField($model,'vcs_m_1',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_2'); ?>
		<?php echo $form->textField($model,'vcs_m_2',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_3'); ?>
		<?php echo $form->textField($model,'vcs_m_3',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_4'); ?>
		<?php echo $form->textField($model,'vcs_m_4',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_5'); ?>
		<?php echo $form->textField($model,'vcs_m_5',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_6'); ?>
		<?php echo $form->textField($model,'vcs_m_6',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_7'); ?>
		<?php echo $form->textField($model,'vcs_m_7',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_8'); ?>
		<?php echo $form->textField($model,'vcs_m_8',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_9'); ?>
		<?php echo $form->textField($model,'vcs_m_9',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_m_10'); ?>
		<?php echo $form->textField($model,'vcs_m_10',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_cardholder_ip_address'); ?>
		<?php echo $form->textField($model,'vcs_cardholder_ip_address',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_masked_card_number'); ?>
		<?php echo $form->textField($model,'vcs_masked_card_number',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_transaction_type'); ?>
		<?php echo $form->textField($model,'vcs_transaction_type',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vcs_hash'); ?>
		<?php echo $form->textField($model,'vcs_hash',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->