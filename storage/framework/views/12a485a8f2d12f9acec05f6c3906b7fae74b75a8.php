<?php $__env->startSection('content'); ?>
    <faculty-pds prop-civils='<?php echo json_encode($civils, 15, 512) ?>'
        prop-citizenships='<?php echo json_encode($citizenships, 15, 512) ?>'>
    </faculty-pds>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.faculty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\eshen\Desktop\Github\hr_learning_dev\resources\views/faculty/faculty-pds.blade.php ENDPATH**/ ?>