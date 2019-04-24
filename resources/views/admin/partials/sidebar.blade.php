<div class="main-sidebar">
   <aside id="sidebar-wrapper">
     <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">{{config('app.name')}}</a>
     </div>
     <div class="sidebar-brand sidebar-brand-sm">
       <a href="index.html">St</a>
     </div>
     <ul class="sidebar-menu">
         <li class="menu-header">Dashboard</li>
         <li class="nav-item dropdown">
           <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
           <ul class="dropdown-menu">
             <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
             <li><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
           </ul>
         </li>
         <li class="menu-header">Users</li>
         <li class="nav-item dropdown">
           <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>Users</span></a>
           <ul class="dropdown-menu">
              <li><a class="nav-link" href="{{ route('admin.users.create') }}">Create</a></li>
              <li><a class="nav-link" href="{{ route('admin.users.index') }}">List</a></li>
           </ul>
         </li>
       </ul>

       <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
         <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
           <i class="fas fa-rocket"></i> Documentation
         </a>
       </div>
   </aside>
 </div>