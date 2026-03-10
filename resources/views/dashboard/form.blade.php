@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-lg-center  flex-column flex-md-row flex-lg-row mt-3">
            <div class="flex-grow-1">
                <h3 class="mb-2 text-size-26 text-color-2">Form Element</h3>
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>

<div class="mt-4">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-3">
                    <h4 class="h4">Form Input</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                    </form>
                </div> 
            </div> 
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-3">
                    <h4 class="h4">Form select</h4>
                </div>
                <div class="card-body">
                    <form>
                        <select class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </form>
                </div> 
            </div> 
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-3">
                    <h4 class="h4">Form textarea</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Textarea</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </form>
                </div> 
            </div> 
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-3">
                    <h4 class="h4">Checkbox</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Default checkbox
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                            <label class="form-check-label" for="flexCheckChecked">
                                Checked checkbox
                            </label>
                        </div>
                        <div class="form-check mb-2 ps-0">
                            <input type="checkbox" class="custom-checkbox" id="CustomCheck">
                            <label class="form-check-label" for="CustomCheck">
                                Custom checkbox
                            </label>
                        </div>
                        <div class="form-check mb-2 form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheck">
                            <label class="form-check-label" for="flexSwitchCheck">Switch checkbox input</label>
                        </div>
                    </form>
                </div> 
            </div> 
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-3">
                    <h4 class="h4">Radios</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Default radio
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Default checked radio
                            </label>
                        </div>
                        <div class="form-check mb-2 custom-radio">
                            <input class="form-check-input" type="radio" name="flexRadioDefault1" id="flexRadioDefault3">
                            <label class="form-check-label" for="flexRadioDefault3">
                                Custom radio
                            </label>
                        </div>
                    </form>
                </div> 
            </div> 
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-3">
                    <h4 class="h4">File input</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">File input example</label>
                            <input class="form-control" type="file" id="formFile">
                        </div>
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                            <input class="form-control" type="file" id="formFileMultiple" multiple>
                        </div>
                    </form>
                </div> 
            </div> 
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-3">
                    <h4 class="h4">Form layout</h4>
                </div>
                <div class="card-body">
                    <form class="row g-3">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail4">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Password</label>
                            <input type="password" class="form-control" id="inputPassword4">
                        </div>
                        <div class="col-12">
                            <label for="inputAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary">Sign in</button>
                        </div>
                    </form>
                </div> 
            </div> 
        </div>
    </div>
</div>
@endsection