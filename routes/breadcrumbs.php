<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->add(__('Dashboard'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.banner.index', function ($trail) {
    $trail->add(__('Banner'), route('admin.banner.index'));
});

Breadcrumbs::for('admin.category.index', function ($trail) {
    $trail->add(__('Category'), route('admin.category.index'));
});

Breadcrumbs::for('admin.category.merge', function ($trail) {
    $trail->parent('admin.category.index');
    $trail->add(__('Merge'), route('admin.category.index'));
});

Breadcrumbs::for('admin.category.show', function ($trail, $category) {
    $trail->parent('admin.category.index');
    $trail->add($category->name, url()->current());
});

Breadcrumbs::for('admin.quote.index', function ($trail) {
    $trail->add(__('Quote'), route('admin.quote.index'));
});

Breadcrumbs::for('admin.quote.create', function ($trail) {
    $trail->parent('admin.quote.index');
    $trail->add(__('Create New'), route('admin.quote.create'));
});

Breadcrumbs::for('admin.quote.edit', function ($trail, $quote) {
    $trail->parent('admin.quote.index');
    $trail->add(__('Edit'), url()->current());
});

Breadcrumbs::for('admin.quote.show', function ($trail, $quote) {
    $trail->parent('admin.quote.index');
    $trail->add(__('Quote by :author', [
        'author' => $quote->author->name,
    ]), url()->current());
});

Breadcrumbs::for('admin.author.index', function ($trail) {
    $trail->add(__('Author'), route('admin.author.index'));
});

Breadcrumbs::for('admin.author.show', function ($trail, $author) {
    $trail->parent('admin.author.index');
    $trail->add($author->name, url()->current());
});

Breadcrumbs::for('admin.author.edit', function ($trail, $author) {
    $trail->parent('admin.author.index');
    $trail->add(__('Edit Author'), url()->current());
});

Breadcrumbs::for('admin.user.index', function ($trail) {
    $trail->add(__('User'), route('admin.user.index'));
});

Breadcrumbs::for('admin.country.index', function ($trail) {
    $trail->add(__('Country'), route('admin.country.index'));
});

Breadcrumbs::for('admin.language.index', function ($trail) {
    $trail->add(__('Language'), route('admin.language.index'));
});

Breadcrumbs::for('admin.user.show', function ($trail, $user) {
    $trail->parent('admin.user.index');
    $trail->add($user->name, url()->current());
});
