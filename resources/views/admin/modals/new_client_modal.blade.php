<!-- Modal -->
<div class="modal fade" id="newClientModal" tabindex="-1" role="dialog" aria-labelledby="newClientModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-client-form" class="modal-form" action="{{route('createClient')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="errors"></div>
                    <div class="form-body">
                        <div class="form-group">
                            <input name="name" id="name" class="form-control" type="text" value="">
                            <label class="control-label" for="name">Name</label>
                        </div>
                        <div class="form-group">
                            <input name="city" id="city" class="form-control" type="text" value="">
                            <label class="control-label" for="city">City</label>
                        </div>
                        <div class="form-group">
                            <input name="country" id="country" class="form-control" type="text" value="">
                            <label class="control-label" for="country">Country</label>
                        </div>
                        <div class="form-group">
                            <input name="reservation_contact" id="reservation_contact" class="form-control" type="text" value="">
                            <label class="control-label" for="reservation_contact">Reservation Contact</label>
                        </div>
                        <div class="form-group">
                            <input name="cancellation_email" id="cancellation_email" class="form-control" type="text" value="">
                            <label class="control-label" for="cancellation_email">Cancellation Email</label>
                        </div>
                        <div class="form-group">
                            <select class="company" name="company" data-placeholder="Company" style="width: 100%">
                                <option></option>
                                <option value="null">None</option>
                                @foreach($data['companies'] as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="company">Company</label>
                        </div>
                        <div class="form-group">
                            <select class="region" name="region" data-placeholder="Region" style="width: 100%">
                                <option></option>
                                <option value="null">None</option>
                                @foreach($data['regions'] as $region)
                                    <option value="{{$region->id}}">{{$region->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="region">Region</label>
                        </div>
                        <div class="form-group">
                            <select class="category" name="category" data-placeholder="Category" style="width: 100%">
                                <option></option>
                                <option value="null">None</option>
                                @foreach($data['categories'] as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="category">Category</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary btn-submit">
                </div>
            </form>
        </div>
    </div>
</div>