            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img style="width: 25%" src="{{ URL::asset('images/logo.png') }}" />
                            <span class="app-brand-text demo menu-text fw-bold ms-2">Stack Tips</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                {{-- <div class="menu-inner-shadow"></div> --}}

                <ul class="menu-inner py-1">
                    <li class="menu-item">
                        <a href="{{ URL('/') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            <div data-i18n="Basic">{{ __('WellCome') }}</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('drop-zone') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            <div data-i18n="Basic">{{ __('Drop Zone') }}</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('auto-suggest') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-copy"></i>
                            {{ __('Auto Suggest') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('lazy-load') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-detail"></i>
                            {{ __('Lazy Load') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('import-export') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-grid"></i>
                            {{ __('Excel Import and Export') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('generate-pdf') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-envelope"></i>
                            {{ __('Generate PDF') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('products') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-check"></i>
                            {{ __('CRUD') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('csv') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-store"></i>
                            {{ __('Import Export CSV') }}
                        </a>
                    </li>


                    <li class="menu-item">
                        <a href="{{ URL('fullcalender') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-grid"></i>
                            {{ __('Full Calander') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('weather') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-sun"></i>
                            {{ __('Weather API') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('notes') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-key"></i>
                            {{ __('Encrypt and Decrypt') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('form-builder') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-key"></i>
                            {{ __('Form Builder') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('crop') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-store"></i>
                            {{ __('Image Crop') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('dusk-test') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-test-tube"></i>
                            {{ __('Dusk Test') }}
                        </a>
                    </li>


                    <li class="menu-item">
                        <a href="{{ URL('datatable') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-test-tube"></i>
                            {{ __('Jquery Datatable') }}
                        </a>
                    </li>


                    <li class="menu-item">
                        <a href="{{ URL('send-notification') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-test-tube"></i>
                            {{ __('Real Time Notification') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('communications') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-test-tube"></i>
                            {{ __('Chat') }}
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ URL('push-notification') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-test-tube"></i>
                            {{ __('Push Notification') }}
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ URL('show-roles') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-test-tube"></i>
                            {{ __('Roles And Permissions') }}
                        </a>
                    </li>


                </ul>
            </aside>
