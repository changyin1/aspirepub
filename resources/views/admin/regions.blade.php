@extends('admin.admin_base')

@section('content')
    <div class="admin-page regions-page mt-4">
        <h2>Regions</h2>
        <div>
            <h5 class="float-left">Here are your regions</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#newRegionModal">
                Create New
            </button>
            <div class="clear"></div>
        </div>
        <div class="company-list">
            @if($data['regions']->isEmpty())
                No Regions Created Add One to Get Started!
            @else
                <table class="data-table" data-searchable="false">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Region Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['regions'] as $region)
                        <tr class="link-row" data-href="{{route('admin/regions') . '/'.$region->id}}">
                            <td>{{$region->id}}</td>
                            <td>{{$region->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @include('admin/modals/new_region_modal')
@endsection