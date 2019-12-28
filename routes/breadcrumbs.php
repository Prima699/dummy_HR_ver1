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
Breadcrumbs::for('perusahaan.edit', function ($t) {
	$t->parent('perusahaan');
    $t->push('Edit', route('admin.perusahaan.index'));
});

// jabatan
Breadcrumbs::for('jabatan', function ($t) {
    $t->push('jabatan', route('admin.jabatan.index'));
});
Breadcrumbs::for('jabatan.create', function ($t) {
	$t->parent('jabatan');
    $t->push('Create', route('admin.jabatan.create'));
});
Breadcrumbs::for('jabatan.edit', function ($t) {
	$t->parent('jabatan');
    $t->push('Edit', route('admin.jabatan.index'));
});

// province
Breadcrumbs::for('province', function ($t) {
    $t->push('province', route('admin.province.index'));
});
Breadcrumbs::for('province.create', function ($t) {
	$t->parent('province');
    $t->push('Create', route('admin.province.create'));
});
Breadcrumbs::for('province.edit', function ($t) {
	$t->parent('province');
    $t->push('Edit', route('admin.province.index'));
});

// country
Breadcrumbs::for('country', function ($t) {
    $t->push('country', route('admin.country.index'));
});
Breadcrumbs::for('country.create', function ($t) {
	$t->parent('country');
    $t->push('Create', route('admin.country.create'));
});
Breadcrumbs::for('country.edit', function ($t) {
	$t->parent('country');
    $t->push('Edit', route('admin.country.index'));
});

// Tipe Ijin
Breadcrumbs::for('TipeIjin', function ($t) {
    $t->push('TipeIjin', route('admin.TipeIjin.index'));
});
Breadcrumbs::for('TipeIjin.create', function ($t) {
	$t->parent('TipeIjin');
    $t->push('Create', route('admin.TipeIjin.create'));
});
Breadcrumbs::for('TipeIjin.edit', function ($t) {
	$t->parent('TipeIjin');
    $t->push('Edit', route('admin.TipeIjin.index'));
});