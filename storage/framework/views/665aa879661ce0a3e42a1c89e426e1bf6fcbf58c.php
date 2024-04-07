<?php $__env->startSection('title', 'Contact Export'); ?>
<?php $__env->startSection('heading', 'Contacts'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Export Contacts</div>

                <div class="card-body">
                    <form method="GET" action="<?php echo e(url('contacts/fileExport')); ?>">
                        <button type="submit" class="btn btn-primary mt-4">Export Contacts</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\laravel\assignment\resources\views/contacts/export.blade.php ENDPATH**/ ?>