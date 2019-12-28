<?php

// Dashboard
Breadcrumbs::for('dashboard', function ($t) { // $t => $trail
    $t->push('Dashboard', route('dashboard'));
});

// Category
Breadcrumbs::for('pegawai', function ($t) {
    $t->push('Pegawai', route('admin.pegawai.index'));
});
Breadcrumbs::for('pegawai.create', function ($t) {
	$t->parent('pegawai');
    $t->push('Create', route('admin.pegawai.create'));
});
Breadcrumbs::for('pegawai.edit', function ($t) {
	$t->parent('pegawai');
    $t->push('Edit', route('admin.pegawai.index'));
});

// Category
Breadcrumbs::for('category', function ($t) {
    $t->push('Category', route('admin.category.index'));
});
Breadcrumbs::for('category.create', function ($t) {
	$t->parent('category');
    $t->push('Create', route('admin.category.create'));
});
Breadcrumbs::for('category.edit', function ($t) {
	$t->parent('category');
    $t->push('Edit', route('admin.category.index'));
});

// Perusahaan
Breadcrumbs::for('perusahaan', function ($t) {
    $t->push('perusahaan', route('admin.perusahaan.index'));
});
Breadcrumbs::for('perusahaan.created', function ($t) {
	$t->parent('perusahaan');
    $t->push('Create', route('admin.perusahaan.created'));
});