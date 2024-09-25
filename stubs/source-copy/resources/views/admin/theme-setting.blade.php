<div class="row">
    <div class="col-4 col-lg-2">
        <div class="nav flex-column nav-pills">
            @foreach([
                'home' => __('General'),
                'footer' => __('Footer'),
                'social' => __('Social'),
            ] as $tab => $label)
                <a class="nav-link {{ $tab == request('tab', 'home') ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['tab' => $tab]) }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-8 col-lg-10">
        <div class="tab-content">
            <div class="tab-pane fade show active">
                @switch(request('tab', 'home'))
                    @case('home')
                        <div class="form-horizontal">
                            @mediamanager(['name' => 'logo', 'label' => __('Logo')])
                            @mediamanager(['name' => 'favicon', 'label' => __('Favicon')])
                        </div>
                        @break

                    @case('footer')
                        <div class="form-horizontal">
                            @mediamanager(['name' => 'logo_footer', 'label' => __('Logo Footer')])
                            @editor(['name' => 'footer_content', 'label' => __('Coyright Content')])
                            @editor(['name' => 'copyright_footer', 'label' => __('Coyright Footer')])
                        </div>
                        @break

                    @case('social')
                        <div class="form-horizontal">
                            @input(['name' => 'social_facebook', 'label' => __('Facebook')])
                            @input(['name' => 'social_twitter', 'label' => __('Twitter')])
                            @input(['name' => 'social_instagram', 'label' => __('Instagram')])
                            @input(['name' => 'social_youtube', 'label' => __('Youtube')])
                        </div>
                        @break

                    @case('dev')
                        <div class="form-horizontal">
                            @input(['name' => 'demo_text', 'label' => __('Text')])
                            @textarea(['name' => 'demo_textarea', 'label' => __('Textarea')])
                            @checkbox(['name' => 'demo_checkbox', 'label' => __('Checkbox')])

                            @select(['name' => 'demo_select', 'label' => __('Select'), 'options' => theme_demo_options()])
                            @selecth(['name' => 'demo_selecth', 'label' => __('Select 2'), 'options' => theme_demo_options()])
                            @sumoselect(['name' => 'demo_sumoselect', 'label' => __('Sumo Select'), 'options' => theme_demo_options()])
                            @sumoselect(['name' => 'demo_select_multiple', 'label' => __('Multiple Select'), 'options' => theme_demo_options(), 'multiple' => true])

                            @dateinput(['name' => 'demo_dateinput', 'label' => __('Date')])
                            @datetimeinput(['name' => 'demo_datetimeinput', 'label' => __('Date Time')])
                            @daterangeinput(['name' => 'demo_daterangeinput', 'label' => __('Date Range')])
                            @datetimerangeinput(['name' => 'demo_datetimerangeinput', 'label' => __('Date Time Range')])

                            @input(['name' => 'demo_money', 'label' => __('Money'), 'mask' => 'money'])

                            <hr>

                            @editor(['name' => 'demo_editor', 'label' => __('Editor')])

                            <hr>

                            @mediamanager(['name' => 'demo_mediamanager', 'label' => __('Media Manager')])
                            @mediafile(['name' => 'demo_image', 'label' => __('Image')])
                            @gallery(['name' => 'demo_gallery', 'label' => __('Gallery')])
                        </div>
                        @break
                @endswitch
            </div>
        </div>
    </div>
</div>
