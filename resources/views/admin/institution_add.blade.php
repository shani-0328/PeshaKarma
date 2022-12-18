<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Institution - Textile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="SysCodTech" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{URL::asset('../assets/images/Picture3.png')}}">

    <!-- third party css -->
    <link rel="stylesheet" href="{{URL::asset('../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{URL::asset('../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link rel="stylesheet" href="{{URL::asset('../assets/css/bootstrap-purple.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link rel="stylesheet" href="{{URL::asset('../assets/css/app-purple.min.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link rel="stylesheet" href="{{URL::asset('../assets/css/bootstrap-purple-dark.min.css')}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
    <link rel="stylesheet" href="{{URL::asset('../assets/css/app-purple-dark.min.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />

    <!-- icons -->
    <link rel="stylesheet" href="{{URL::asset('../assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    

                    <li class="dropdown d-inline-block d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-search noti-icon"></i>
                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-right p-0">
                            <form class="p-3">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>

                    <li class="dropdown d-none d-lg-inline-block">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                            <i class="fe-maximize noti-icon"></i>
                        </a>
                    </li>

                    <!-- <li class="dropdown d-none d-lg-inline-block topbar-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-grid noti-icon"></i>
                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-right">

                            <div class="p-lg-1">
                                <div class="row no-gutters">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">

                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">

                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">

                                        </a>
                                    </div>
                                </div>

                                <div class="row no-gutters">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">

                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">

                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">

                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </li>



                     -->

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src={{asset('../assets/images/users/unnamed.png')}} alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1">
                                    {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i> 
                                </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="{{url('/profile')}}" class="dropdown-item notify-item">
                                <i class="fe-settings"></i>
                                <span>Settings</span>
                            </a>

                            

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                        </div>
                    </li>

                    <li class="dropdown notification-list">
                        <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                            <i class="fe-settings noti-icon"></i>
                        </a>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="{{url('/')}}" class="logo logo-dark text-center">
                        <span class="logo-sm">
                                <img src={{asset('../assets/images/Picture3.png')}} alt="" height="40">
                                <!-- <span class="logo-lg-text-light">Textile</span> -->
                        </span>
                        <span class="logo-lg">
                                <img src={{asset('../assets/images/LOGO2.png')}} alt="" height="70">
                                <!-- <span class="logo-lg-text-light">U</span> -->
                        </span>
                    </a>

                    <a href="{{url('/')}}" class="logo logo-light text-center">
                        <span class="logo-sm">
                                <img src={{asset('../assets/images/Picture3.png')}} alt="" height="40">
                            </span>
                        <span class="logo-lg">
                                <img src={{asset('../assets/images/LOGO1.png')}} alt="" height="70">
                            </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                                <i class="fe-menu"></i>
                            </button>
                    </li>

                    <li>
                        <!-- Mobile menu toggle (Horizontal Layout)-->
                        <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>




                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="h-100" data-simplebar>

                <!-- User box -->
                <div class="user-box text-center">
                    <img src={{asset('../assets/images/users/unnamed.png')}} alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
                    <div class="dropdown">
                        <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown">{{ Auth::user()->name }} Kennedy</a>
                        <div class="dropdown-menu user-pro-dropdown">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user mr-1"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings mr-1"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-lock mr-1"></i>
                                <span>Lock Screen</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-log-out mr-1"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </div>
                    <p class="text-muted">Admin Head</p>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul id="side-menu">

                        <li class="menu-title">Navigation</li>

                        <li>
                            <a href="{{url('/')}}">
                                <i class="mdi mdi-view-dashboard-outline"></i>

                                <span> Dashboard </span>
                            </a>

                        </li>

                        <li class="menu-title mt-2">Apps</li>





                        <li>
                            <a href="{{url('/customerslist')}}">
                                <i class="mdi mdi-account-multiple-outline"></i>
                                <span> All Customers </span>
                            </a>
                        </li>


                        





                        @if(auth()->user()->role->name == 'SuperAdmin' ||auth()->user()->role->name == 'Admin')
                        <li>
                            <a href="{{url('/admin/departmentlist')}}">
                                <i class="mdi mdi-domain"></i>
                                <span> Departments </span>
                            </a>
                        </li>
                        @endif



                        @if(auth()->user()->role->name == 'SuperAdmin' ||auth()->user()->role->name == 'Admin')
                        <li class="menu-title mt-2">Admin</li>
                        <li>
                            <a href="#sidebarContacts" data-toggle="collapse">
                                <i class="mdi mdi-book-account-outline"></i>
                                <span> Manage </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarContacts">
                                <ul class="nav-second-level">

                                    @if(auth()->user()->role->name == 'SuperAdmin')
                                    <li>
                                        <a href="{{url('/admin/users')}}">Users</a>
                                    </li>
                                @endif
                                    <li>
                                        <a href="{{url('/admin/departments')}}">Departments</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/admin/institutions')}}">Institution</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="{{url('/admin/customers')}}">
                                <i class="mdi mdi-account-multiple-outline"></i>
                                <span> Customers </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/admin/sp-invoice')}}">
                                <i class="mdi mdi-note-text"></i>
                                <span> Special Invoice List </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('installment-payment.index')}}">
                                <i class="mdi mdi-receipt"></i>
                                <span> Add Payments </span>
                            </a>
                        </li>
                        

                        <li>
                            <a href="#sidebarreports" data-toggle="collapse">
                                <i class="mdi mdi-clipboard-text-outline"></i>
                                <span> Reports </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarreports">
                                <ul class="nav-second-level">

                                    
                                    
                                    <li>
                                        <a href="{{url('/admin/cashbook-report')}}">Cashbook Report</a>
                                    </li>
                                   <li>
                                        <a href="{{url('/admin/institution-report')}}">Institutions List</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/admin/letter-report-institutions')}}">Institutions Letter report</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/admin/allcustomers-report')}}">All Customers</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/admin/daily_payments_report')}}">Daily Payments</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/admin/log-institution-report')}}">Institutions List book</a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li>
                            <a href="#sidebarsms" data-toggle="collapse">
                                <i class="mdi mdi-email"></i>
                                <span> SMS </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarsms">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{url('/admin/customers_list_sms')}}">All Customers</a>
                                    </li>
                                </ul>
                            </div>
                        </li>



                        






                        
                        





                    @endif
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Textile</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">App</a></li>
                                        <li class="breadcrumb-item active">Departments</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Institution</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-2">

                            <!-- end card-->
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-3 header-title">Add Institution</h4>

                                    {!! Form::open(['method'=>'POST' , 'action'=>'App\Http\Controllers\InstitutionController@store']) !!}
                                        <div class="form-group">
                                            <label for="exampleInputcode1">Institution Code</label>
                                            {!! Form:: text('code', null,['class'=>'form-control', 'required'=> 'true', 'placeholder'=> 'Institution Code']) !!}
                                            @if($errors->has('code'))
                                          <small class = "text-danger">
                                            {{$errors->first('code')}}
                                          </small>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputname1">Institution Name</label>
                                            {!! Form:: text('name', null,['class'=>'form-control', 'required'=> 'true', 'placeholder'=> 'Institution Name']) !!}
                                            @if($errors->has('name'))
                                          <small class = "text-danger">
                                            {{$errors->first('name')}}
                                          </small>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputname1">Responsible Person</label>
                                            {!! Form:: text('responsible_person', null,['class'=>'form-control', 'required'=> 'true', 'placeholder'=> 'Responsible Person Name']) !!}
                                           
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputname1">Address</label>
                                            {!! Form:: text('address', null,['class'=>'form-control', 'placeholder'=> 'Address']) !!}
                                           
                                        </div>
                                        <div class="form-group">
                                            <label for="example-select">Department</label>
                                            {!! Form:: select('department_id', [''=>'-- Choose Department --'] + $departments , null,['class'=>'form-control', 'required'=> 'true']) !!}
                                        </div>


                                        <button type="submit" class="btn btn-primary waves-effect waves-light"> <i class="mdi mdi-content-save-all-outline"></i> Save</button>
                                        <a href="{{url('/admin/institutions')}}" type="button" class="btn btn-danger waves-effect waves-light float-right">Cancel</a>
                                    {!! Form::close() !!}

                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <div class="col-lg-2">

                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            
                            <script>
                                document.write(new Date().getFullYear())
                            </script> &copy; Textile Systems by <a href="syscodtech.com">SysCodtech</a>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-right footer-links d-none d-sm-block">

                                <a href="javascript:void(0);">Help</a>

                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-bordered nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link py-2" data-toggle="tab" href="#chat-tab" role="tab">
                        <i class="mdi mdi-message-text d-block font-22 my-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2" data-toggle="tab" href="#tasks-tab" role="tab">
                        <i class="mdi mdi-format-list-checkbox d-block font-22 my-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 active" data-toggle="tab" href="#settings-tab" role="tab">
                        <i class="mdi mdi-cog-outline d-block font-22 my-1"></i>
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content pt-0">



                <div class="tab-pane active" id="settings-tab" role="tabpanel">
                    <h6 class="font-weight-medium px-3 m-0 py-2 font-13 text-uppercase bg-light">
                        <span class="d-block py-1">Theme Settings</span>
                    </h6>

                    <div class="p-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                        </div>

                        <h6 class="font-weight-medium font-14 mt-4 mb-2 pb-1">Color Scheme</h6>
                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="color-scheme-mode" value="light" id="light-mode-check" checked />
                            <label class="custom-control-label" for="light-mode-check">Light Mode</label>
                        </div>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="color-scheme-mode" value="dark" id="dark-mode-check" />
                            <label class="custom-control-label" for="dark-mode-check">Dark Mode</label>
                        </div>

                        <!-- Width -->
                        <h6 class="font-weight-medium font-14 mt-4 mb-2 pb-1">Width</h6>
                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="width" value="fluid" id="fluid-check" checked />
                            <label class="custom-control-label" for="fluid-check">Fluid</label>
                        </div>
                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="width" value="boxed" id="boxed-check" />
                            <label class="custom-control-label" for="boxed-check">Boxed</label>
                        </div>

                        <!-- Menu positions -->
                        <h6 class="font-weight-medium font-14 mt-4 mb-2 pb-1">Menus (Leftsidebar and Topbar) Positon</h6>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="menus-position" value="fixed" id="fixed-check" checked />
                            <label class="custom-control-label" for="fixed-check">Fixed</label>
                        </div>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="menus-position" value="scrollable" id="scrollable-check" />
                            <label class="custom-control-label" for="scrollable-check">Scrollable</label>
                        </div>

                        <!-- Left Sidebar-->
                        <h6 class="font-weight-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Color</h6>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="leftsidebar-color" value="light" id="light-check" checked />
                            <label class="custom-control-label" for="light-check">Light</label>
                        </div>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="leftsidebar-color" value="dark" id="dark-check" />
                            <label class="custom-control-label" for="dark-check">Dark</label>
                        </div>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="leftsidebar-color" value="brand" id="brand-check" />
                            <label class="custom-control-label" for="brand-check">Brand</label>
                        </div>

                        <div class="custom-control custom-switch mb-3">
                            <input type="radio" class="custom-control-input" name="leftsidebar-color" value="gradient" id="gradient-check" />
                            <label class="custom-control-label" for="gradient-check">Gradient</label>
                        </div>

                        <!-- size -->
                        <h6 class="font-weight-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Size</h6>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="leftsidebar-size" value="default" id="default-size-check" checked />
                            <label class="custom-control-label" for="default-size-check">Default</label>
                        </div>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="leftsidebar-size" value="condensed" id="condensed-check" />
                            <label class="custom-control-label" for="condensed-check">Condensed <small>(Extra Small size)</small></label>
                        </div>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="leftsidebar-size" value="compact" id="compact-check" />
                            <label class="custom-control-label" for="compact-check">Compact <small>(Small size)</small></label>
                        </div>

                        <!-- User info -->
                        <h6 class="font-weight-medium font-14 mt-4 mb-2 pb-1">Sidebar User Info</h6>

                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" name="leftsidebar-user" value="fixed" id="sidebaruser-check" />
                            <label class="custom-control-label" for="sidebaruser-check">Enable</label>
                        </div>


                        <!-- Topbar -->
                        <h6 class="font-weight-medium font-14 mt-4 mb-2 pb-1">Topbar</h6>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="topbar-color" value="dark" id="darktopbar-check" checked />
                            <label class="custom-control-label" for="darktopbar-check">Dark</label>
                        </div>

                        <div class="custom-control custom-switch mb-1">
                            <input type="radio" class="custom-control-input" name="topbar-color" value="light" id="lighttopbar-check" />
                            <label class="custom-control-label" for="lighttopbar-check">Light</label>
                        </div>


                        <button class="btn btn-primary btn-block mt-4" id="resetBtn">Reset to Default</button>



                    </div>

                </div>
            </div>

        </div>
        <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="{{URL::asset('../assets/js/vendor.min.js')}}"></script>

    <!-- third party js -->
    <script src="{{URL::asset('../assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('../assets/libs/jquery-datatables-checkboxes/js/dataTables.checkboxes.min.js')}}"></script>
    <!-- third party js ends -->

    <!-- Datatables init -->
    <script src="{{URL::asset('../assets/js/pages/institution.init.js')}}"></script>

    <!-- App js -->
    <script src="{{URL::asset('../assets/js/app.min.js')}}"></script>

</body>

</html>