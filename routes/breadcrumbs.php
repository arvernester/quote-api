<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->add(__('Dashboard'), route_lang('admin.dashboard'));
});

Breadcrumbs::for('admin.banner.index', function ($trail) {
    $trail->add(__('Banner'), route_lang('admin.banner.index'));
});

Breadcrumbs::for('admin.category.index', function ($trail) {
    $trail->add(__('Category'), route_lang('admin.category.index'));
});

Breadcrumbs::for('admin.category.merge', function ($trail) {
    $trail->parent('admin.category.index');
    $trail->add(__('Merge'), route_lang('admin.category.index'));
});

Breadcrumbs::for('admin.category.show', function ($trail, $lang, $category) {
    $trail->parent('admin.category.index');
    $trail->add($category->name, route_lang('admin.category.index'));
});

Breadcrumbs::for('admin.quote.index', function ($trail) {
    $trail->add(__('Quote'), route_lang('admin.quote.index'));
});

Breadcrumbs::for('admin.quote.create', function ($trail) {
    $trail->parent('admin.quote.index');
    $trail->add(__('Add New'), route_lang('admin.quote.create'));
});

Breadcrumbs::for('admin.quote.edit', function ($trail, $quote) {
    $trail->parent('admin.quote.index');
    $trail->add(__('Edit'), url()->current());
});

Breadcrumbs::for('admin.quote.show', function ($trail, $quote) {
    $trail->parent('admin.quote.index');
    $trail->add(
        sprintf('Quote by %s', $quote->author->name),
        route_lang('admin.quote.show', $quote)
    );
});

Breadcrumbs::for('admin.author.index', function ($trail) {
    $trail->add(__('Author'), route_lang('admin.author.index'));
});

Breadcrumbs::for('admin.author.show', function ($trail, $lang, $author) {
    $trail->parent('admin.author.index');
    $trail->add($author->name, route_lang('admin.author.show', $author));
});

Breadcrumbs::for('admin.author.edit', function ($trail, $author) {
    $trail->parent('admin.author.index');
    $trail->add(sprintf('Edit %s', $author->name), url()->current());
});

Breadcrumbs::for('admin.user.index', function ($trail) {
    $trail->add(__('User'), route_lang('admin.user.index'));
});

Breadcrumbs::for('admin.country.index', function ($trail) {
    $trail->add(__('Country'), route_lang('admin.country.index'));
});

Breadcrumbs::for('admin.language.index', function ($trail) {
    $trail->add(__('Language'), route_lang('admin.language.index'));
});
