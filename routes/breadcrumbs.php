<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->add('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::for('admin.banner.index', function ($trail) {
    $trail->add('Banner', route('admin.banner.index'));
});

Breadcrumbs::for('admin.category.index', function ($trail) {
    $trail->add('Category', route('admin.category.index'));
});

Breadcrumbs::for('admin.category.merge', function ($trail) {
    $trail->parent('admin.category.index');
    $trail->add('Merge', url()->current());
});

Breadcrumbs::for('admin.category.show', function ($trail, $category) {
    $trail->parent('admin.category.index');
    $trail->add($category->name, route('admin.category.show', $category));
});

Breadcrumbs::for('admin.quote.index', function ($trail) {
    $trail->add('Quote', route('admin.quote.index'));
});

Breadcrumbs::for('admin.quote.create', function ($trail) {
    $trail->parent('admin.quote.index');
    $trail->add('Add New', route('admin.quote.create'));
});

Breadcrumbs::for('admin.quote.edit', function ($trail, $quote) {
    $trail->parent('admin.quote.index');
    $trail->add(sprintf('Edit'), url()->current());
});

Breadcrumbs::for('admin.quote.show', function ($trail, $quote) {
    $trail->parent('admin.quote.index');
    $trail->add(
        sprintf('Quote by %s', $quote->author->name),
        route('admin.quote.show', $quote)
    );
});

Breadcrumbs::for('admin.author.index', function ($trail) {
    $trail->add('Author', route('admin.author.index'));
});

Breadcrumbs::for('admin.author.show', function ($trail, $author) {
    $trail->parent('admin.author.index');
    $trail->add($author->name, route('admin.author.show', $author));
});

Breadcrumbs::for('admin.author.edit', function ($trail, $author) {
    $trail->parent('admin.author.index');
    $trail->add(sprintf('Edit %s', $author->name), url()->current());
});

Breadcrumbs::for('admin.user.index', function ($trail) {
    $trail->add('User', route('admin.user.index'));
});

Breadcrumbs::for('admin.country.index', function ($trail) {
    $trail->add('Country', route('admin.country.index'));
});

Breadcrumbs::for('admin.language.index', function ($trail) {
    $trail->add('Language', route('admin.language.index'));
});
