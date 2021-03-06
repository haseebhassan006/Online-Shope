
@php
Theme::asset()->add('core-style', 'themes/shopwise/css/findcss.css');
Theme::asset()->add('head-style', 'themes/shopwise/css/head.css');
Theme::asset()->add('u-style', 'themes/shopwise/css/tomac.css');
Theme::partial('header')

@endphp
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
<main id="maincontent" class="page-main" >
   <div class="row">
     <a id="contentarea" tabindex="-1"></a>
      <div class="container">
        <div class="page-title-wrapper">
           <h1 class="page-title">
            <span class="base" data-ui-id="page-title-wrapper" >@php Theme::set('pageName', __('Find the Blade You Need ') ); @endphp </span>
           </h1>
        </div>
      </div>
    <div class="columns">
    <div class="bladefinder-wrapper">
        <form class="bladefinder-form" action="{{ route('search.blade') }}" method="post">
            @csrf
            <fieldset class="fieldset">
                <section class="blade-option option-saw-setup">
        <div class="blade-option-header">
            <div class="step-number">1</div>

            <div class="step-text">What Saw Do You Have?</div>
        </div>
        <div class="blade-option-body">
            <div class="blade-select-section make-model">
                <div class="selection saw-make">
                    <div class="selection-label">Saw Make</div>
                    <div class="select-container">
                <select id="make" name="brand" title="Saw Make" class="validate-select saw-make-select data-hj-whitelist">
                            <option value>
                            Select an Option
                            </option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                </select>
                                        </div>
                </div>
                <div class="selection saw-model">
                    <div class="selection-label">Saw Model</div>
                    <div class="select-container">
                                            <select id="model" name="model" title="Saw Model" class="validate-select saw-model-select data-hj-whitelist">
                            <option value>
                                    Select an Option            </option>

                                    @foreach($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->title }}</option>
                                    @endforeach
                                    </select>
                                        </div>
                </div>
                <div class="hidden-blade-measurements"></div>
            </div>

            <div class="blade-select-section or-saw-option">
                <span class="">- OR -</span>
            </div>

            <div class="blade-select-section measurements">
                <div class="selection blade-length">


                        <div class="selection-label">Blade Length</div>

                                <div class="select-container small first one" style="display:none">
                                   <select id="blade-length-feet" title="Feet" class="validate-select blade-length-feet data-hj-whitelist">
                                       <option value="">Choose</option>
                                    @foreach($lengthFeets as $lengthFeet)
                                    <option value="{{ $lengthFeet->id }}">{{ $lengthFeet->title }}</option>
                                    @endforeach
                                    </select>
                                   <div class="select-label-small">Feet</div>
                                </div>
                            <div class="select-container small second" style="display:none">
                                   <select id="blade-length-inch" title="Inch" class="validate-select blade-length-inch data-hj-whitelist">
                                       <option value="">Choose</option>
                                       @foreach ($lengthInches as $lengthInch)
                                       <option value="{{ $lengthInch->id }}">{{ $lengthInch->title }}</option>
                                       @endforeach
                                    </select>
                                    <div class="select-label-small">Inch</div>
                            </div>
                            <div class="select-container small third" style="display:none">
                                   <select id="blade-length-inch" title="Inch" class="validate-select blade-length-inch data-hj-whitelist">
                                       <option value="">Choose</option>
                                       @foreach($bladelengthfractions  as $fraction)
                                        <option value="{{ $fraction->id }}">{{ $fraction->title }}</option>
                                      @endforeach
                                    </select>
                                 <div class="select-label-small ">Fraction</div>
                            </div>
                            <div class="select-container small first forth">
                                <select id="blade-length-totalInches" title="Total Inches" class="validate-select blade-length-totalInches data-hj-whitelist">
                                     <option value="">Choose</option>
                                    @foreach($bladelengthinches as $inche)
                                    <option value="{{ $inche->id }}">{{ $inche->title }}</option>
                                    @endforeach
                                </select>
                                <div class="select-label-small">Inches</div>
                            </div>
                            <div class="select-container small fifth" >
                                <select id="blade-length-inch" title="Inch" class="validate-select blade-length-inch data-hj-whitelist">
                                    <option value="">Choose</option>
                                    @foreach($bladelengthfractions  as $fraction)
                                        <option value="{{ $fraction->id }}">{{ $fraction->title }}</option>
                                      @endforeach
                                 </select>
                                <div class="select-label-small">Fraction</div>
                            </div>
                        </div>

                <div class="selection blade-width w2">
                    <div class="selection-label">Blade Size</div>
                     <div class="select-container small first">
                        <select id="blade-width-inch" title="Width" class="validate-select blade-width-inch data-hj-whitelist" name="bladelengthwidth">
                            <option value="">Choose</option>
                            @foreach($bladesizewidths as $bladesizewidth)
                            <option name="{{ $bladesizewidth->id }}">{{ $bladesizewidth->title }}</option>
                            @endforeach
                        </select>
                        <div class="select-label-small">Width</div>
                    </div>
                    <div class="select-container small">
                        <select id="blade-blade_thickness-inch" title="Thickness" class="validate-select data-hj-whitelist" name="bladelengthick">
                            <option value="">Choose</option>
                            @foreach($bladesizethicks as $bladesizethick)
                            <option value="{{ $bladesizethick->id }}">{{  $bladesizethick->title }}</option>
                            @endforeach
                        </select>
                        <div class="select-label-small">Thickness</div>
                    </div>
                </div>
               <div class="switch-container">
                    <span class="feet-switch-text">Inches</span>
                    <label class="feet-switch">
                        <input type="checkbox" class="feet-slider" id="changePara">
                        <span class="slider"></span>
                    </label>
                  <span class="feet-switch-text">Feet-Inches</span>
                </div>
                <input type="hidden" name="length" id="blade-length"/>
                <input type="hidden" name="blade_width" id="blade-width"/>
                <input type="hidden" name="blade_thickness" id="blade-blade_thickness"/>
            </div>
        </div>
            <div class="bladefinder-saw-help">
                <a href="blog/post/how-to-measure-your-bandsaw-blade/index.html" target="_blank" id="launch-bladefinder-help-modal">Get Help Determining Blade Length</a>
            </div>
        </div>
    </section>
    <section class="blade-option option-cross_section">
        <div class="blade-option-header">
            <div class="step-number">2</div>
            <div class="step-text">What Is The Cross Section?</div>
        </div>
        <div class="blade-option-body">
            <div class="selection-options">
                <div class="swatch-opt-cross_section selection-swatch" data-role="swatch-options">
        <div class="field cross_section swatches-list">
            @foreach($crossSections as $index => $crossSection)
               <label for="{{ $crossSection->id }}">
                    <span class="swatch-label">{{ $crossSection->title }}</span>
                    <input
                        type="radio"
                        name="cross""
                        class="radio"
                        value="{{ $crossSection->id }}"
                        id="{{ $crossSection->id }}"
                        data-label="{{ $crossSection->title }}"
                        @if (!$index) {!! "checked" !!} @endif
                    >
                    <img class="swatch-image" src="{{ asset('storage/'.$crossSection->image) }}" alt="General Purpose" data-value="0" >
                </label>
            @endforeach
         </div>
     </div>
   </div>
 </div>
</section>
<section class="blade-option option-type">
        <div class="blade-option-header">
            <div class="step-number">3</div>
            <div class="step-text">What Material Are You Cutting?</div>
        </div>
        <div class="blade-option-body">
            <div class="selection-options">
                <div class="swatch-opt-type selection-swatch" data-role="swatch-options">
                    <div class="field type swatches-list">
                       @foreach($materials as $index => $material)
                    <label for="{{ $material->id }}">
                         <span class="swatch-label">{{ $material->title}}</span>
                       <input
                        type="radio"
                        name="material"
                        class="radio"
                        value="{{ $material->id }}"
                        id="{{ $material->id }}"
                        data-label="{{ $material->title}}"
                        @if (!$index) {!! "checked" !!} @endif
                        >
                     <img class="swatch-image" src="{{ asset('storage/'.$material->image) }}" alt="Steel" data-value="0">
                    </label>
                     @endforeach
         </div>
       </div>
   </div>
</div>
</section>
<section class="blade-option option-thickness">
        <div class="blade-option-header">
            <div class="step-number">4</div>
            <div class="step-text">What Are The Dimensions Of The Material?</div>
        </div>
        <div class="blade-option-body">
            <div class="blade-select-section thickness-image">
                <img src="media/bladefinder/material-thickness.png" />
            </div>
            {{-- <div class="blade-select-section thickness-selections">
                <div class="selection diameter">
                    <div class="selection-label">Material Width</div>
                       <div class="select-container">
                <select id="diameter" name="diameter" title="Material Width" class="validate-select diameter-select data-hj-whitelist">
                        <option value="">Choose</option>

                </select>
                <div class="select-label-small">Inch</div>
                </div>
            </div> --}}
            <div class="selection thickness">
                <div class="selection-label">Material Thickness</div>
                    <div class="select-container">
                        <select id="thickness" name="dimension" title="Material Thickness" class="validate-select thickness-select data-hj-whitelist">
                            <option value>-</option>
                            @foreach($materialwidths as $materialwidth)
                            <option id="{{ $materialwidth->id }}">{{ $materialwidth->title }}</option>
                            @endforeach
                        </select>
                 <div class="select-label-small">Inch</div>
            </div>
        </div>
    </div>
</div>
</section>
    <div class="blade-actions">
        <button type="submit" class="action secondary submit">
            <span>Find Blades</span>
        </button>
    </div>
    </fieldset>
        </form>
    </div>
</div>
</div>
</main>
</div>
    </div>
</div>
</div>
</div>






