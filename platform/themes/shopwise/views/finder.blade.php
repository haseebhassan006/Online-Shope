
@php
Theme::set('pageName', __('Find the Blade You Need ') );

Theme::layout('blog-sidebar');
@endphp
<form action="{{ route('search.blade') }}" method="post" enctype="multipart/form-data">
    @csrf
<div class="blade-option-header">
    <div class="step-number">1</div>
    <div class="step-text">What Saw Do You Have?</div>
</div>

    <div class="form-row">

            <div class="form-group col-md-3">
                <label for="inputEmail4">Saw Make</label>
                <select id="inputState" class="form-control" name="brand">
                    <option selected value="">Choose...</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach

                  </select>
            </div>
            <div class="form-group col-md-3">
                <label for="inputPassword4">Saw Model</label>
                <select  class="form-control" name="model">
                <option selected value="">Choose...</option>
                @foreach($models as $model)
                <option value="{{ $model->id }}">{{ $model->title }}</option>
                @endforeach

              </select>
            </div>
        --OR--
        <div class="form-group col-md-1">
            <label for="inputEmail4">Blade Size(inches)</label>
            <select id="inputState" class="form-control" name="bladesizeinche">
                <option selected value="">Choose...</option>
                @foreach($bladelengthinches as $bladelengthinche)
                <option value="{{ $bladelengthinche->id }}">{{ $bladelengthinche->title }}</option>
                @endforeach

              </select>
        </div>
        <div class="form-group col-md-1">
            <label for="inputEmail4">Blade Size(fraction)</label>
            <select id="inputState" class="form-control" name="bladesizefrac">
                <option selected value="">Choose...</option>
                @foreach($bladelengthfractions as $bladelengthfraction)
                <option id="{{ $bladelengthfraction->id }}">{{ $bladelengthfraction->title }}</option>
                @endforeach
              </select>
        </div>
        <div class="form-group col-md-1">
            <label for="inputPassword4">Blade Length(width)</label>
            <select  class="form-control" name="bladelengthwidth">
            <option selected value="">Choose...</option>
            @foreach($bladesizewidths as $bladesizewidth)
            <option name="{{ $bladesizewidth->id }}">{{ $bladesizewidth->title }}</option>
            @endforeach

          </select>


        </div>
        <div class="form-group col-md-1">
            <label for="inputPassword4">Blade Length(thickness)</label>
            <select  class="form-control" name="bladelengthick">
            <option selected value="">Choose...</option>

            @foreach($bladesizethicks as $bladesizethick)
            <option value="{{ $bladesizethick->id }}">{{  $bladesizethick->title }}</option>
            @endforeach

          </select>


        </div>

    </div>
    <div class="blade-option-header">
        <div class="step-number">2</div>
        <div class="step-text">What is the Cross Section?</div>
    </div>
    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="inputPassword4">Cross Section</label>
            <select  class="form-control"  name="cross">
            <option selected value="">Choose...</option>
            @foreach($crossSections as $crossSection)
            <option id="{{ $crossSection->id }}">{{ $crossSection->title }}</option>
            @endforeach
          </select>
        </div>


    </div>
    <div class="blade-option-header">
        <div class="step-number">3</div>
        <div class="step-text">What material are you cutting?</div>
    </div>
    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="inputPassword4">Material</label>
            <select  class="form-control" name="material">
            <option selected value="">Choose...</option>
            @foreach($materials as $material)
            <option value="{{ $material->id }}">{{ $material->title}}</option>
            @endforeach
          </select>
        </div>


    </div>
    <div class="blade-option-header">
        <div class="step-number">3</div>
        <div class="step-text">What are the dimensions of material?</div>
    </div>
    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="inputPassword4">Dimension(inches)</label>
            <select  class="form-control" name="dimension">
            <option selected value="">Choose...</option>
            @foreach($materialwidths as $materialwidth)
            <option id="{{ $materialwidth->id }}">{{ $materialwidth->title }}</option>
            @endforeach

          </select>
        </div>


    </div>
    <button type="submit" class="btn btn-primary">Find Blade</button>
</form>


