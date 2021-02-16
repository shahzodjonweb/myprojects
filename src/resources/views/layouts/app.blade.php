
<!DOCTYPE html>
<html lang="en" style="background-color:#e5e5e5;">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Easy Logistics</title>
        <link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet" />
        <link href="{{ URL::asset('css/ss.css') }}" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
      <link href="{{ URL::asset('css/mystyle.css') }}" rel="stylesheet" />
      <link href="{{ URL::asset('css/semantic.min.css') }}" rel="stylesheet" />
      <link href="{{ URL::asset('css/jquery-weekdays.css') }}" rel="stylesheet" />
      <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
      
      <style>
    
      </style>
     @yield('css')
    

    </head>

    <body class="sb-nav-fixed">
      <div id="notification-container"></div>
       @include('modals')
    <div class="mainwindow">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">Easy Logistics</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="{{ url('load/searchload/unit') }}" method="post">
                <div class="input-group">
                  
                    @csrf
                    <input class="form-control" type="text" name="l_number" id="l_number" placeholder="Search by load number" aria-label="Search" aria-describedby="basic-addon2"
                    @if (!empty($search['l_number']))
                    value="{{ $search['l_number'] }}"
                @endif
                    />
                    <input type="hidden" name="page" value="load.loadlist">
                  
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                  
                </div>
            </form>
            {{-- <a href="{{ route('deadline.index') }}" class="navbar-top-button button-bell deadline" style="text-decoration: none;" id="button-bell">
              <i class="fas fa-bell 
              @if ($customers->count()!=0)
              belling
              @endif
              "></i>
             
            </a> --}}
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}"  method="POST">
                          @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                      </form>
                    </div>
                </li>
            </ul> 
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            
                           
                            <div class="sb-sidenav-menu-heading">Main menu</div>
                            <a class="nav-link dashboard" href="{{ url("driver/activedrivers") }}">
                              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                              Dashboard
                          </a>
                      
                            <div class="sb-sidenav-menu-heading">Loads</div>
                            <a class="nav-link load" href="{{ route('load.index') }}" >
                                <div class="sb-nav-link-icon"><i class="fas fa-th-list"></i></div>
                                Loads
                            </a>

                           
                            <a class="nav-link driver" href="{{ route('driver.index') }}" >
                              <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                              Drivers
                          </a>
                            
                          <a class="nav-link broker" href="{{  route('broker.index')  }}" >
                            <div class="sb-nav-link-icon"><i class="fas fa-headset"></i></div>
                            Brokers
                        </a>
                  @if (Auth::user()->role ==  'admin')
                        <div class="sb-sidenav-menu-heading">Accounting</div>
                        <a class="nav-link dreport" href="{{ route('report.index') }}" >
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Driver Report
                        </a>


                        <a class="nav-link creport" href="{{ url('report/showcompany1') }}" >
                          <div class="sb-nav-link-icon"><i class="fas fa-calculator"></i></div>
                          Company report
                        </a>
                          
                        <a class="nav-link admin" href="{{ route('admin.index') }}" >
                        <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                        Settings
                        </a>
                  @endif
                     
{{--                            
                            <a class="nav-link chegirma" href="#" >
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Chegirma kartalari
                              
                            </a>
                      
                           
                            
                           
                            <div class="sb-sidenav-menu-heading">Xarajatlar</div>
                            <a class="nav-link xarajat" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                               Umimiy Xarajatlar
                            </a>
                            <a class="nav-link qaytgan" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Qaytgan Tovarlar
                            </a> --}}
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content" >
                <main>
                  <div class="container-fluid makezoom">
                 @yield('content')
              
                  </div>
                </main>
                
            
            </div>
        </div>
        </div>
        <script src="{{ URL::asset('js/extention/choices.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('js/scripts.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('assets/demo/datatables-demo.js') }}"></script>
        <script src="{{ URL::asset('js/JsBarcode.all.min.js') }}"></script>
        <script src="{{ URL::asset('js/jquery.table2excel.js') }}"></script>
        <script src="{{ URL::asset('js/semantic.js') }}"></script>
        <script src="{{ URL::asset('js/jquery-weekdays.js') }}"></script>
        <script type="text/javascript">
  
      var notification;
      var container = document.querySelector('#notification-container');
      var visible = false;
      
      function createNotification() {
        notification = document.createElement('div');
        var btn = document.createElement('button');
        var title = document.createElement('div');
        var msg = document.createElement('div');
        btn.className = 'notification-close';
        title.className = 'notification-title';
        msg.className = 'notification-message';
        btn.addEventListener('click', hideNotification, false);
        notification.addEventListener('animationend', hideNotification, false);
        notification.addEventListener('webkitAnimationEnd', hideNotification, false);
        notification.appendChild(btn);
        notification.appendChild(title);
        notification.appendChild(msg);
      }
      
      function updateNotification(type, title, message) {
        notification.className = 'notification notification-' + type;
        notification.querySelector('.notification-title').innerHTML = title;
        notification.querySelector('.notification-message').innerHTML = message;
      }
      
      function showNotification(type, title, message) {
        if (visible) {
          queue.push([type, title, message]);
          return;
        }
        if (!notification) {
          createNotification();
        }
        updateNotification(type, title, message);
        container.appendChild(notification);
        visible = true;
      }
      
      function hideNotification() {
        if (visible) {
          visible = false;
          container.removeChild(notification);
          if (queue.length) {
            showNotification.apply(null, queue.shift());
          }
        } 
      }
   //$('table').addClass('table-striped');
      
    </script>
       @if(session()->has('success'))
       <script>
       showNotification('success', 'Success!', '{{ session()->get('success') }}');
       </script>
       
       @endif
    @yield('js')
    </body>
</html>
