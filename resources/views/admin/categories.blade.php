@extends('admin.admin_base')

@section('content')
    <div class="admin-page categories-page mt-4">
        <h2>Categories</h2>
        <div>
            <h5 class="float-left">Here are your categories</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#newCategoryModal">
                Create New
            </button>
            <div class="clear"></div>
        </div>
        <div class="category-list">
            @if($data['categories']->isEmpty())
                No Categories Created Add One to Get Started!
            @else
                <table class="data-table" data-searchable="false">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['categories'] as $category)
                        <tr class="link-row" data-href="{{route('admin/categories') . '/'.$category->id}}">
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @include('admin/modals/new_category_modal')
@endsection