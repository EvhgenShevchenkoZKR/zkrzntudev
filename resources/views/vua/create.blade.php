@extends('adm')

@extends('partials.tab-gmap-script')

@section('content')
    <div class="col-md-12 admin-content">
        <h1 class="apage-title">{{trans('m.adm_page_title')}}</h1>
        {!! Form::open(array('url' => 'company-store', 'method' => 'POST', 'class' => 'form main-form company-form clearfix', 'files' => true)) !!}

        <div class="hidden" id="select-something">{{trans('m.chose_something')}}</div>
        <div id="selectImage">
            {!! Form::label(trans('m.select_image')) !!}
            {!! Form::file('file[]', array('multiple' => true, 'class' => 'form-control img-upload', 'id' => 'files')) !!}
            <output id="result" /></output>
        </div>
        <script type="text/javascript" src="/js/ckeditor_dark/ckeditor.js"></script>
        <script type="text/javascript" src="/js/ckeditor_dark/adapters/jquery.js"></script>
        <div class="admin-tab">
            <ul class="tab admin-tab">
                <li><a href="#" class="tablinks" onclick="openCity(event, 'EN')">{{trans('m.en')}}</a></li>
                <li><a href="#" class="tablinks active" onclick="openCity(event, 'UK')">{{trans('m.uk')}}</a></li>
                <li><a href="#" class="tablinks" onclick="openCity(event, 'RU')">{{trans('m.ru')}}</a></li>
            </ul>
        </div>
        <div id="EN" class="tabcontent">
            <div class="form-group">
                {!! Form::label(Lang::get('m.title') . ' ' . trans('m.by_en')) !!}
                {!! Form::text('title_en',old('title_en'),array('class' => 'form-control', 'placeholder' => trans('m.title'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.metatitle') . ' ' . trans('m.by_en')) !!}
                {!! Form::text('metatitle_en',old('metatitle_en'),array('class' => 'form-control', 'placeholder' => trans('m.metatitle'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.metakeywords') . ' ' . trans('m.by_en')) !!}
                {!! Form::text('metakeywords_en',old('metakeywords_en'),array('class' => 'form-control', 'placeholder' => trans('m.metakeywords'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.metadescription') . ' ' . trans('m.by_en')) !!}
                {!! Form::textarea('metadescription_en',old('metadescription_en'),array('class' => 'form-control', 'size' => '50x3', 'placeholder' => trans('m.metadescription'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.description') . ' ' . trans('m.by_en')) !!}
                {!! Form::textarea('description_en',old('description_en'),array('class' => 'form-control body-text', 'placeholder' => trans('m.description'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.address') . ' ' . trans('m.by_en')) !!}
                {!! Form::text('address_en',old('address_en'),array('class' => 'form-control', 'placeholder' => trans('m.address'))) !!}
            </div>
        </div>
        <div id="UK" class="tabcontent act">
            <div class="form-group">
                {!! Form::label('title_uk', Lang::get('m.title') . ' ' . trans('m.by_uk'), ['class' => 'required']) !!}
                {!! Form::text('title_uk',old('title_uk'),array('class' => 'form-control', 'placeholder' => trans('m.title'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.metatitle') . ' ' . trans('m.by_uk')) !!}
                {!! Form::text('metatitle_uk',old('metatitle_uk'),array('class' => 'form-control', 'placeholder' => trans('m.metatitle'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.metakeywords') . ' ' . trans('m.by_uk')) !!}
                {!! Form::text('metakeywords_uk',old('metakeywords_uk'),array('class' => 'form-control', 'placeholder' => trans('m.metakeywords'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.metadescription') . ' ' . trans('m.by_uk')) !!}
                {!! Form::textarea('metadescription_uk',old('metadescription_uk'),array('class' => 'form-control', 'size' => '50x3', 'placeholder' => trans('m.metadescription'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.description') . ' ' . trans('m.by_uk')) !!}
                {!! Form::textarea('description_uk',old('description_uk'),array('class' => 'form-control body-text', 'placeholder' => trans('m.description'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.address') . ' ' . trans('m.by_uk')) !!}
                {!! Form::text('address_uk',old('address_uk'),array('class' => 'form-control', 'placeholder' => trans('m.address'))) !!}
            </div>
        </div>
        <div id="RU" class="tabcontent">
            <div class="form-group">
                {!! Form::label(Lang::get('m.title') . ' ' . trans('m.by_ru')) !!}
                {!! Form::text('title_ru',old('title_ru'),array('class' => 'form-control', 'placeholder' => trans('m.title'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.metatitle') . ' ' . trans('m.by_ru')) !!}
                {!! Form::text('metatitle_ru',old('metatitle_ru'),array('class' => 'form-control', 'placeholder' => trans('m.metatitle'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.metakeywords') . ' ' . trans('m.by_ru')) !!}
                {!! Form::text('metakeywords_ru',old('metakeywords_ru'),array('class' => 'form-control', 'placeholder' => trans('m.metakeywords'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.metadescription') . ' ' . trans('m.by_ru')) !!}
                {!! Form::textarea('metadescription_ru',old('metadescription_ru'),array('class' => 'form-control', 'size' => '50x3', 'placeholder' => trans('m.metadescription'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.description') . ' ' . trans('m.by_ru')) !!}
                {!! Form::textarea('description_ru',old('description_ru'),array('class' => 'form-control body-text', 'placeholder' => trans('m.description'))) !!}
            </div>
            <div class="form-group">
                {!! Form::label(Lang::get('m.address') . ' ' . trans('m.by_ru')) !!}
                {!! Form::text('address_ru',old('address_ru'),array('class' => 'form-control', 'placeholder' => trans('m.address'))) !!}
            </div>
        </div>
        <script>$('textarea.body-text').ckeditor();</script>
        <div class="span11">
            <div id="map"></div>
        </div>

        <div class="coordinates">
            <div class="form-group col-md-6">
                {!! Form::label(Lang::get('m.latitude')) !!}
                {!! Form::text('latitude',old('latitude'),array('class' => 'form-control lat')) !!}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label(Lang::get('m.longitude')) !!}
                {!! Form::text('longitude',old('longitude'),array('class' => 'form-control lng')) !!}
            </div>
        </div>

        <div class="form-group col-md-12">
            {!! Form::label(trans('m.goods_type')) !!}
            <select id="goods_types" class="form-control chosen-select" name="goods_types[]" multiple="multiple">
                <?php $title_lang = 'title_' .  App::getLocale(); ?>
                @foreach($data['goods_types'] as $key=>$tag)
                    @if($tag->parent_id == 0)
                        <option style="font-weight: bold" class="category" value="{{$tag->id}}">{{$tag->$title_lang}}</option>
                    @else
                        <option class="subclass" value="{{$tag->id}}">{{$tag->$title_lang}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-12">
            {!! Form::label(trans('m.service_type')) !!}
            <select id="service_types" class="form-control chosen-select" name="service_types[]" multiple="multiple">
                <?php $title_lang = 'title_' .  App::getLocale(); ?>
                @foreach($data['service_types'] as $key=>$tag)
                    @if($tag->parent_id == 0)
                        <option style="font-weight: bold" class="category" value="{{$tag->id}}">{{$tag->$title_lang}}</option>
                    @else
                        <option class="subclass" value="{{$tag->id}}">{{$tag->$title_lang}}</option>
                    @endif
                @endforeach
            </select>
        </div>



        <div class="form-group col-md-4">
            {!! Form::label(trans('m.company_type')) !!}
            <select id="company_types" class="form-control chosen-select" name="company_types">
                <?php $title_lang = 'title_' .  App::getLocale(); ?>
                @foreach($data['tags'] as $key=>$tag)
                    @if($tag->parent_id == 0)
                        <option style="font-weight: bold" class="category" value="{{$tag->id}}">{{$tag->$title_lang}}</option>
                    @else
                        <option class="subclass" value="{{$tag->id}}">{{$tag->$title_lang}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            {!! Form::label(trans('m.owner')) !!}
            {!! Form::select('owner_id', $data['users'], null, array('class' => 'form-control chosen-select')) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label(trans('m.region')) !!}
            {!! Form::select('region_id', $data['regions'], null, array('class' => 'form-control chosen-select')) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label(trans('m.url')) !!}
            {!! Form::text('url', old('url'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label(trans('m.email')) !!}
            {!! Form::text('email', old('email'),array('class' => 'form-control')) !!}
        </div>

        <div class="pub-wrapper">
            <div class="form-group phones-wrapper col-md-4">
                {!! Form::label(trans('m.phone_label')) !!}
                {!! Form::text('phone', old('phone'), ['class' => 'form-control']) !!}
                {!! Form::submit(trans('m.add_one_more') ,array('class' => 'btn pull-right', 'id' => 'add_phone')) !!}
            </div>
            <div class="pub-sub-wrapper">
                <div class="hours-wrapper col-md-4">
                    <div class="form-group">
                        {!! Form::label(trans('m.work_hours_start')) !!}
                        {!! Form::time('work_hours_start', old('work_hours_start'),array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label(trans('m.work_hours_end')) !!}
                        {!! Form::time('work_hours_end', old('work_hours_end'),array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group published-wrapper col-md-4">
                    {!! Form::label(trans('m.published')) !!}
                    {!! Form::checkbox('published', 1, false, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::submit(trans('m.save') ,array('class' => 'btn btn-success pull-right')) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('footerscripts')
    <script>
        $(document).ready(function(){
            var multi_select_label = $('#select-something').html();
            $(function(){
                $(".chosen-select").chosen({
                    placeholder_text_multiple: multi_select_label
                });
            });

            GMaps.on('click', map.map, function(event) {
                map.removeMarkers();
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();

                map.addMarker({
                    lat: lat,
                    lng: lng,
                    title: 'Координаты',
//                    infoWindow: {
//                        content: 'Index: index'
//                    },
                    icon: "/icons/gmap/blue-marker.png",
                    opacity: 0.8,
                    crossOnDrag: false,
                    draggable: false
                });
            });
            GMaps.on('marker_added', map, function(marker) {
                $('.coordinates .lat').val(marker.position.lat());
                $('.coordinates .lng').val(marker.position.lng());
            });

            var addPhoneClicks = 0;
            $( "#add_phone" ).click(function( event ) {
                addPhoneClicks++;
                event.preventDefault();
                $( '<input class="form-control" name="phone_' + addPhoneClicks + '" type="text">').insertBefore('.phones-wrapper #add_phone');
            });

            //code taken from http://stackoverflow.com/questions/20779983/multiple-image-upload-and-preview
            //allows us to preview multiple image before upload
            //also modified to create alt and title input`s
            if(window.File && window.FileList && window.FileReader)
            {
                var filesInput = document.getElementById("files");
                filesInput.addEventListener("change", function(event){
                    var files = event.target.files; //FileList object
                    var output = document.getElementById("result");
                    for(var i = 0; i< files.length; i++)
                    {
                        var file = files[i];
                        //Only pics
                        if(!file.type.match('image'))
                            continue;
                        $('#result div').remove();// removing old images on uploading new
                        var picReader = new FileReader();
                        var j = 0;
                        picReader.addEventListener("load",function(event){
                            j++;
                            var picFile = event.target;
                            var div = document.createElement("div");
                            div.innerHTML = "<div class='thumbnail-wrapper'><img class='thumbnail' src='" + picFile.result + "'" +
                                    "title='" + picFile.name + "'/></div>"
                                    + '<div class="form-group at-wrapper">'
                                    + '<input name="i_alt_' + j + '" type="text" class="form-control result-alt" placeholder="alt">'
                                    + '<input name="i_title_' + j + '" type="text" class="form-control result-title" placeholder="title">';
                            + '</div>';
                            output.insertBefore(div,null);
                        });
                        //Read the image
                        picReader.readAsDataURL(file);
                    }
                });
            }
            else
            {
                console.log("Your browser does not support File API");
            }

        });

    </script>
@endsection