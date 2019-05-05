@extends('base')

@section('content')
   <div class="settings-page mt-4">
       <h2>Settings</h2>
       <ul class="nav nav-tabs">
           <li class="active"><a data-toggle="tab" href="#contact-info">Contact Information</a></li>
           {{--<li><a data-toggle="tab" href="#preferences">Preferences</a></li>--}}
       </ul>
       <div class="tab-content">
           <div id="contact-info" class="tab-pane fade in active show">
               <form id="contact-info-form" class="contact-info-form" action="{{route('saveSettings')}}" method="post">
                   @csrf
                   <div class="form-heading">Contact Information</div>
                   <div class="errors"></div>
                   <div class="form-body">
                       <div class="form-group">
                           <input name="name" id="name" class="form-control" type="text" value="{{$data['user']->name}}">
                           <label class="control-label" for="name">Name</label>
                       </div>
                       <div class="form-group">
                           <input name="phone" id="phone" class="form-control" type="tel" value="{{$data['user']->phone}}">
                           <label class="control-label" for="phone">Phone Number</label>
                       </div>
                       <div class="form-group">
                           <input name="email" id="email" class="form-control" type="email" value="{{$data['user']->email}}">
                           <label class="control-label" for="email">Email Address</label>
                       </div>
                   </div>
                   <div class="form-heading">Address</div>
                   <div class="form-group">
                       <input name="address" id="address" class="form-control" type="text">
                       <label class="control-label" for="address">Client Address</label>
                   </div>
                   <div class="form-group">
                       <input name="post-code" id="post-code" class="form-control" type="text">
                       <label class="control-label" for="post-code">Postal Code</label>
                   </div>
                   <div class="form-group">
                       <div class="form-row">
                           <select class="city" name="city" data-placeholder="City"></select>
                           <select class="state" name="state" data-placeholder="State">
                               <option></option>
                               @foreach($states as $key => $state)
                                   <option value="{{$state}}">{{$key}}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
                   <div class="form-group">
                       <input type="submit" class="btn btn-primary" value="Save">
                   </div>
               </form>
           </div>
           {{--<div id="preferences" class="tab-pane fade">--}}
               {{--test2--}}
           {{--</div>--}}
           <input type="hidden" id="city-url" value="{{url('/api/cities')}}">
       </div>
   </div>
@endsection