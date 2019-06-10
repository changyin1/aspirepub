@extends('admin.admin_base')

@section('content')
    <div class="admin-page call-settings-page mt-4">
        <h2>Settings</h2>
        <div>
            <h5 class="float-left">Call Types</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#newCallTypeModal">
                Add Call Type
            </button>
            <div class="clear"></div>
            <table>
                @if($data['types']->isEmpty())
                    No Call Types Added Add One to Get Started!
                @else
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Edit</th>
                        {{--<th>Remove</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['types'] as $type)
                        <tr data-id="{{$type->id}}">
                            <td>{{$type->type}}</td>
                            <td>{{$type->price}}</td>
                            <td><a href="{{route('admin/call/type', ['id' => $type->id])}}">Edit</a></td>
                            {{--<td><button type="button" data-type="{{$type->id}}" class="btn btn-danger removeCallType" data-toggle="modal" data-target="#removeCallTypeModal">--}}
                                {{--Remove--}}
                            {{--</button></td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
        <br>
        <div>
            <h5 class="float-left">Languages</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#newLanguageModal">
                Add Language
            </button>
            <div class="clear"></div>
            <table>
            @if($data['languages']->isEmpty())
                No Languages Added Add One to Get Started!
            @else
                <thead>
                <tr>
                    <th>Language</th>
                    <th>Edit</th>
                    {{--<th>Remove</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($data['languages'] as $language)
                    <tr data-id="{{$language->id}}">
                        <td>{{$language->language}}</td>
                        <td><a href="{{route('admin/language', ['id' => $language->id])}}">Edit</a></td>
                        {{--<td><button type="button" data-language="{{$language->id}}" class="btn btn-danger removeLanguage" data-toggle="modal" data-target="#removeLanguageModal">--}}
                            {{--Remove--}}
                        {{--</button></td>--}}
                    </tr>
                @endforeach
                </tbody>
            @endif
            </table>
        </div>
    </div>
    @include('admin.modals.new_call_type_modal')
    @include('admin.modals.new_language_modal')
@endsection