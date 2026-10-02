@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-1">All Categories</h5>
        <p class="text-muted small mb-0">Manage book categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Category
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:70px;">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th style="width:160px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td class="fw-medium">{{ $cat->name }}</td>
                        <td class="text-muted small">
                            {{ $cat->description ? Str::limit($cat->description, 60) : '—' }}
                        </td>
                        <td class="text-muted small">{{ $cat->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $cat) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            No categories yet. Click "Add Category" to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $categories->links() }}
        </div>
    @endif
</div>

@endsection