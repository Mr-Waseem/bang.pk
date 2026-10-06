<?php if($errors->any()): ?>
	<ul class="alert alert-danger">
		<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li> <?php echo e($error); ?></li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ul>
<?php endif; ?><?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/errors/validation.blade.php ENDPATH**/ ?>