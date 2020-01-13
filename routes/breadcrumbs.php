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

// Departemen
Breadcrumbs::for('departemen', function ($t) {
    $t->push('departemen', route('admin.departemen.index'));
});
Breadcrumbs::for('departemen.create', function ($t) {
    $t->parent('departemen');
    $t->push('Create', route('admin.departemen.create'));
});
Breadcrumbs::for('departemen.edit', function ($t) {
    $t->parent('departemen');
    $t->push('Edit', route('admin.departemen.index'));
});

// Presence - Type
Breadcrumbs::for('presence.type', function ($t) {
    $t->push('Presence Type', route('admin.presence.type.index'));
});
Breadcrumbs::for('presence.type.create', function ($t) {
	$t->parent('presence.type');
    $t->push('Create', route('admin.presence.type.create'));
});
Breadcrumbs::for('presence.type.edit', function ($t) {
	$t->parent('presence.type');
    $t->push('Edit', route('admin.presence.type.index'));
});
Breadcrumbs::for('presence.type.detail', function ($t) {
	$t->parent('presence.type');
    $t->push('Detail', route('admin.presence.type.index'));
});

// Presence - Variant
Breadcrumbs::for('presence.variant', function ($t) {
    $t->push('Presence Variant', route('admin.presence.variant.index'));
});
Breadcrumbs::for('presence.variant.create', function ($t) {
	$t->parent('presence.variant');
    $t->push('Create', route('admin.presence.variant.create'));
});
Breadcrumbs::for('presence.variant.edit', function ($t) {
	$t->parent('presence.variant');
    $t->push('Edit', route('admin.presence.variant.index'));
});
Breadcrumbs::for('presence.variant.detail', function ($t) {
	$t->parent('presence.variant');
    $t->push('Detail', route('admin.presence.variant.index'));
});

// Agenda
Breadcrumbs::for('agenda', function ($t) {
    $t->push('Agenda', route('admin.agenda.index'));
});
Breadcrumbs::for('agenda.create', function ($t) {
	$t->parent('agenda');
    $t->push('Create', route('admin.agenda.create'));
});
Breadcrumbs::for('agenda.edit', function ($t) {
	$t->parent('agenda');
    $t->push('Edit', route('admin.agenda.index'));
});
Breadcrumbs::for('agenda.detail', function ($t) {
	$t->parent('agenda');
    $t->push('Detail', route('admin.agenda.index'));
});