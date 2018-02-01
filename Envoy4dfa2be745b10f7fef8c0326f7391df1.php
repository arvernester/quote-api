<?php $env = isset($env) ? $env : null; ?>
<?php $__container->servers(['staging' => 'laravel@103.84.194.14', 'production' => 'kutip@103.84.194.14']); ?>

<?php $__container->startTask('git'); ?>
    rm composer.lock
    git pull origin master
<?php $__container->endTask(); ?>

<?php $__container->startTask('composer'); ?>
    composer update -vvv
<?php $__container->endTask(); ?>

<?php $__container->startTask('migrate'); ?>
    php artisan migrate
<?php $__container->endTask(); ?>

<?php $__container->startTask('deploy', ['on' => ['staging', 'production']], 'parallel' => true); ?>
    <?php if($env == 'production'): ?>
        cd web/kutip.org
    <?php else: ?>if
        cd web/kutip.laravel.web.id
    <?php endif; ?>

    php artisan down

    git

    composer

    migrate
    
    php artisan up
@task