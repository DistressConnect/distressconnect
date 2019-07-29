<?php if($this->session->flashdata('info')): ?>

	<div class="alert alert-info alert-dismissible fade show custom-alert" role="alert">
		<?php echo $this->session->flashdata('info'); ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
	<div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">		
		<?php echo $this->session->flashdata('error'); ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif; ?>
