<form method="post" action="<?php echo $this->getPostFinanceUri()?>" id="<?php echo $this->formName?>" name="<?php echo $this->formName?>">
<?php foreach($this->getParameters() as $key => $value) :?>
	<?php if(false !== $value) :?>
	<input type="hidden" name="<?php echo $key?>" value="<?php echo htmlspecialchars($value) ?>"  />
	<?php endif?>
<?php endforeach?>
<input type="hidden" name="<?php echo PostFinance\PaymentRequest::SHASIGN_FIELD ?>" value="<?php echo $this->getShaSign()?>" />

<?php if($this->showSubmitButton) :?>
	<input name="PostFinancesubmit" type="submit" value="Submit" id="PostFinancesubmit" />
<?php endif?>
</form>